<?php

namespace Hurah\Types\Type;

use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;

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
            throw new InvalidArgumentException("PlainText does not contain a valid JSON string");
        }
    }

    function __toString(): string {
        return trim((string)$this->getValue());
    }

}
