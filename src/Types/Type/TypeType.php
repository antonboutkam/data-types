<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;

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
        if(is_string($mValue))
        {
            parent::__construct(new PhpNamespace(get_class($mValue)));
        }
        elseif(is_object($mValue) && $mValue instanceof IGenericDataType)
        {
            parent::__construct(new PhpNamespace(get_class($mValue)));
        }
        else
        {
            $sMsg = "Constructor argument of " . __CLASS__ . " must implement IGenericDataType";
            throw new RuntimeException($sMsg);
        }

    }
}
