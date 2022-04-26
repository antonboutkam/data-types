<?php

namespace Hurah\Types\Type;

use function get_class;
use function is_array;
use function is_int;
use function is_null;
use function is_object;
use function is_string;
use function json_encode;

class TypeInfo extends AbstractDataType implements IGenericDataType
{
    public function __toString():string
    {
        $mValue = $this->getValue();
        if(is_object($mValue))
        {
            return '(object:' . get_class($mValue). ' )' . json_encode($mValue);
        }
        elseif(is_string($mValue))
        {
            return '(string)' . $mValue;
        }
        elseif(is_array($mValue))
        {
            return '(array)' . json_encode($mValue);
        }
        elseif(is_int($mValue))
        {
            return '(int)' . ((string)$mValue);
        }
        elseif(is_null($mValue))
        {
            return '(null)' . 'null';
        }
        elseif(empty($mValue))
        {
            return '(empty)' . 'empty';
        }
        return '(unknown)' . 'unknown type';
    }

}