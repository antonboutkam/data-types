<?php

namespace Hurah\Types\Type\Primitive;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;

/**
 * Represents strings, arrays, bools, ints, floats
 * Class Primitive
 * @package Hurah\Type
 */
class PrimitiveFloat extends AbstractDataType implements IGenericDataType, IPrimitiveType
{

    function __construct($sValue = null) {

        if ($sValue !== null)
        {
            throw new InvalidArgumentException(__CLASS__ . " cannot hold any other value then \"float\".");
        }
        parent::__construct($sValue);
    }

    function __toString(): string {
        return 'float';
    }
}
