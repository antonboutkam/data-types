<?php

namespace Hurah\Types\Type;

use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\IElementizable;
use Hurah\Types\Util\JsonUtils;

/**
 * Represents a string, but string is a reserved keyword
 * Class PlainText
 * @package Hurah\Type
 */
class PlainText extends AbstractDataType implements IGenericDataType
{
    /**
     * @return Json
     * @throws InvalidArgumentException
     */
    public function toJson(): Json
    {
        try {
            $aJsonData = JsonUtils::decode($this->getValue(), true);
            return new Json($aJsonData);
        } catch (Exception $e) {
            throw new InvalidArgumentException("PlainText does not contain a valid JSON string");
        }
    }
    public function addLn(string $data):self
    {
        $this->setValue($this->getValue() . $data . PHP_EOL);
        return $this;
    }
    public function append(...$data):self
    {
        foreach ($data as $part)
        {
            if(is_array($part))
            {
                $this->append(...$part);
            }
            else
            {
                $this->setValue($this->getValue() . $part);
            }
        }
        return $this;
    }

    public function prepend(...$data)
    {
        foreach ($data as $part)
        {
            if(is_array($part))
            {
                $this->append(...$part);
            }
            else
            {
                $this->setValue($part . $this->getValue());
            }
        }
    }

    /**
     * Checks if the text contains the text passed as the argument.
     * @param string $sString
     * @return bool
     */
    public function contains(string $sString): bool
    {
        return strpos($sString, $this->getValue()) !== false;
    }

    public function __toString(): string
    {
        return trim((string)$this->getValue());
    }
}
