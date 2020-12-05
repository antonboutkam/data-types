<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception;
use Hurah\Util\JsonUtils;

/**
 * Represents a string, but string is a reserved keyword
 * Class PlainText
 * @package Hurah\Type
 */
class PlainText extends AbstractDataType implements IGenericDataType {
    function toJson(): Json {
        try {
            $aJsonData = JsonUtils::decode($this->getValue(), true);
            return new Json($aJsonData);
        } catch (Exception $e) {
            throw new Exception\InvalidArgumentException("PlainText does not contain a valid JSON string");
        }
    }

}
