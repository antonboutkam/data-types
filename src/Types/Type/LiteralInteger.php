<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Contracts\IScalarValue;

class LiteralInteger extends AbstractDataType implements IGenericDataType, IScalarValue
{


    public function asInt():int
    {
        return (int) $this->getValue();
    }
    /**
     * Does a cast but only when the string contains a valid integer value.
     * @param string $sValue
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromString(string $sValue): self {
        $iValue = (int) $sValue;
        $sTestValue = (string) $iValue;

        if($sTestValue === $sValue)
        {
            return new self($sValue);
        }
        throw new InvalidArgumentException("Passed argument {$sValue} cannot be casted to an integer");
    }

}
