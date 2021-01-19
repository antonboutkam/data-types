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
    const TYPES = ['float', 'bool', 'int', 'string', 'array'];
    private IPrimitiveType $mPrimitive;
    public function __construct($sValue = null) {
        $this->mPrimitive = self::create($sValue);
        parent::__construct($this->mPrimitive);
    }
    public static function create(string $sType): IPrimitiveType {
        if ($sType == 'bool' || $sType == 'boolean' || $sType === PrimitiveBool::class)
        {
            return new PrimitiveBool();
        } else if ($sType === 'string' || $sType === PrimitiveString::class)
        {
            return new PrimitiveString();
        } else if ($sType === 'array' || $sType === PrimitiveArray::class)
        {
            return new PrimitiveArray();
        } else if ($sType === 'float' || $sType === PrimitiveFloat::class)
        {
            return new PrimitiveFloat();
        } else if ($sType === 'int' || $sType === 'integer' || $sType === PrimitiveInt::class)
        {
            return new PrimitiveInt();
        }
        throw new InvalidArgumentException("$sType is not a primitive type.");
    }
    public function getImplementationClassName(): string {
        return get_class($this->mPrimitive);
    }

}

