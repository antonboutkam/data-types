<?php

namespace Hurah\Types\Type;

use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use ReflectionClass;
use LogicException;
use Hurah\Types\Exception\ClassNotFoundException;
use ReflectionException;

class PhpNamespace extends AbstractDataType implements IGenericDataType
{

    /**
     * @param mixed ...$allArguments
     * @return mixed
     * @throws ClassNotFoundException
     */
    public function getConstructed(...$allArguments)
    {
        $sClassName = $this->getValue();
        if (!class_exists($sClassName)) {
            throw new ClassNotFoundException("Class not found $sClassName.");
        }
        return new $sClassName(...$allArguments);
    }

    public function getShortName(): string
    {
        if (preg_match('@\\\\([\w]+)$@', $this->getValue(), $matches)) {
            return $matches[1];
        }
        throw new LogicException("Could not shorten Namespace name");

    }

    /**
     * @param mixed ...$aParts
     * @return $this
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function extend(...$aParts):self{
        return self::make($this, $aParts);
    }

    public function implementsInterface($mInterfaceName):bool {
        try {
            $oReflector = new ReflectionClass("{$this}");
            if($oReflector->implementsInterface("{$mInterfaceName}"))
            {
                return true;
            }
            return false;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * @param mixed ...$aParts
     * @return static
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function make(...$aParts): self
    {
        $aUseParts = [];
        foreach ($aParts as $mPart) {
            if (is_null($mPart)) {
                continue;
            }
            if (is_array($mPart)) {
                $aUseParts[] =  join('\\', $mPart);
            } elseif (is_string($mPart)) {
                $aUseParts[] =  $mPart;
            } elseif (is_object($mPart) && $mPart instanceof self) {
                $aUseParts[] =  (string) $mPart;
            } elseif (is_object($mPart)) {
                $reflector = new ReflectionClass(get_class($mPart));
                $aUseParts[] = (string) $reflector->getNamespaceName();
            }
        }
        return new self(join('\\', $aUseParts));
    }
}
