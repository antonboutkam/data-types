<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Php class name without namespace.
 * Class PhpClassName
 * @package Hurah\Types\Type
 */
class PhpClassName extends AbstractDataType implements IGenericDataType {

    /**
     * PhpClassName constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    function __construct($sValue = null) {

        if(!preg_match($sRegex = '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $sValue))
        {
            throw new InvalidArgumentException("{$sValue} is not a valid php class name ($sRegex)");
        }
        parent::__construct($sValue);
    }
}
