<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Primitive\IPrimitiveType;
use Hurah\Types\Type\Primitive\PrimitiveArray;
use Hurah\Types\Type\Primitive\PrimitiveBool;
use Hurah\Types\Type\Primitive\PrimitiveFloat;
use Hurah\Types\Type\Primitive\PrimitiveInt;
use Hurah\Types\Type\Primitive\PrimitiveString;

/**
 * Class Color
 * @package Hurah\Type
 */
class Primitive extends AbstractDataType implements IGenericDataType
{
    public function __construct($sValue = null) {
        parent::__construct($sValue);
    }

    public static function create(string $sType) : IPrimitiveType
    {
        if($sType == 'bool' || $sType == 'boolean' || $sType === PrimitiveBool::class)
        {
            return new PrimitiveBool();
        }
        elseif($sType === 'string' || $sType === PrimitiveString::class)
        {
            return new PrimitiveString();
        }
        elseif($sType === 'array' || $sType === PrimitiveArray::class)
        {
            return new PrimitiveArray();
        }
        elseif($sType === 'float' || $sType === PrimitiveFloat::class)
        {
            return new PrimitiveFloat();
        }
        elseif($sType === 'int' || $sType === 'integer' || $sType === PrimitiveInt::class)
        {
            return new PrimitiveInt();
        }
        throw new InvalidArgumentException("$sType is not a primitive type.");
    }

}
