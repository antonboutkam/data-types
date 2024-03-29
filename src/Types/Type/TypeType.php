<?php

namespace Hurah\Types\Type;

use Error;
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
     *
     * @param null $mValue
     *
     * @throws RuntimeException
     */
    public function __construct($mValue = null)
    {
        if (is_string($mValue) && in_array($mValue, Primitive::TYPES))
        {
            $oValue = Primitive::create($mValue);
            parent::__construct(get_class($oValue));
        }
        elseif (is_string($mValue) && class_exists($mValue))
        {
            parent::__construct($mValue);
        }
        elseif ($mValue instanceof PhpNamespace && $mValue->implementsInterface(IGenericDataType::class))
        {
            parent::__construct("{$mValue->getFqn()}");
        }
        elseif ($mValue instanceof IGenericDataType)
        {
            parent::__construct(get_class($mValue));
        }
        else
        {
            $sMsg = "Could not detect type of " . print_r($mValue->getFqn(), true);
            throw new RuntimeException($sMsg);
        }
    }

    /**
     * @param mixed ...$constructorParams
     *
     * @return IGenericDataType
     */
    public function createInstance($constructorParams): IGenericDataType
    {
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

    public function __toString(): string
    {
        if ($this->isPrimitive())
        {
            $oPhpNamespace = new PhpNamespace("{$this->getValue()}");
            return "{$oPhpNamespace->getConstructed()}";
        }
        return "{$this->getValue()}";
    }

    /**
     * @return bool
     */
    public function isPrimitive(): bool
    {
        try
        {
            return $this->toPhpNamespace()->implementsInterface(IPrimitiveType::class);
        }
        catch (InvalidArgumentException $e)
        {
            throw new Error($e->getMessage());
        }

    }

    /**
     * @return PhpNamespace
     */
    public function toPhpNamespace(): PhpNamespace
    {
        return new PhpNamespace("{$this->getValue()}");
    }
}
