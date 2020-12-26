<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\Primitive\IPrimitiveType;

/**
 * Represents one of the IGenericDataType types.
 **/
class TypeType extends AbstractDataType implements IGenericDataType
{

    /**
     * TypeType constructor.
     * @param null $mValue
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    function __construct($mValue = null) {
        if (is_string($mValue))
        {
            parent::__construct($mValue);
        } else if (is_object($mValue) && $mValue instanceof PhpNamespace)
        {
            parent::__construct("{$mValue}");
        } else if (is_object($mValue) && $mValue instanceof IGenericDataType)
        {
            parent::__construct(get_class($mValue));
        } else
        {
            $sMsg = "Constructor argument of " . __CLASS__ . " must implement IGenericDataType";
            throw new RuntimeException($sMsg);
        }
    }
    /**
     * @param mixed ...$constructorParams
     * @return IGenericDataType
     * @throws InvalidArgumentException
     */
    public function createInstance($constructorParams): IGenericDataType {
        $sClassName = $this->getValue();
        try
        {
            /**
             * @throws InvalidArgumentException
             */
            return new $sClassName($constructorParams);
        }
        catch (InvalidArgumentException $e)
        {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
    public function __toString(): string {
        if ($this->isPrimitive())
        {
            $oPhpNamespace = new PhpNamespace("{$this->getValue()}");
            return "{$oPhpNamespace->getConstructed()}";
        }
        return "{$this->getValue()}";
    }
    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isPrimitive(): bool {
        return $this->toPhpNamespace()
                    ->implementsInterface(IPrimitiveType::class);
    }
    /**
     * @return PhpNamespace
     * @throws InvalidArgumentException
     */
    public function toPhpNamespace(): PhpNamespace {
        return new PhpNamespace("{$this->getValue()}");
    }
}
