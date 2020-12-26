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
class PrimitiveArray extends AbstractDataType implements IGenericDataType, IPrimitiveType
{

    function __construct($sValue = null) {

        if ($sValue !== null)
        {
            throw new InvalidArgumentException(__CLASS__ . " cannot hold any other value then \"array\".");
        }
        parent::__construct($sValue);
    }

    function __toString(): string {
        return 'array';
    }
}
