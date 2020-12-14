<?php

namespace Hurah\Types\Type;

use Core\Reflector;
use Exception\LogicException;
use Hurah\Types\Exception\ClassNotFoundException;

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

    public function extend(...$aParts):self{
        return self::make($this, $aParts);
    }

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
            } elseif (is_object($mPart) && $mPart instanceof \Core\DataType\PhpNamespace) {
                $aUseParts[] =  (string) $mPart;
            } elseif (is_object($mPart)) {
                $reflector = new Reflector($mPart);
                $aUseParts[] = (string) $reflector->getNamespaceName();
            }
        }
        return new self(join('\\', $aUseParts));
    }
}
