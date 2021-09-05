<?php

namespace Hurah\Types\Type;

use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use function is_string;
use function preg_replace;


/**
 * Represents a tag of some sort
 * Class Tag
 * @package Hurah\Type
 */
class Tag extends PlainText implements IGenericDataType
{

    public function __construct($sValue = null)
    {
        if(is_string($sValue))
        {
            $sValue = preg_replace('/^#/', '', $sValue);
        }
        parent::__construct($sValue);
    }

    public function __toString():string
    {
        return '#' . parent::__toString(); // TODO: Change the autogenerated stub
    }
}