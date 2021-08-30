<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use function is_string;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;

class Json extends AbstractDataType implements IGenericDataType
{

    /**
     * Passed argument is converted into a prettyfied json string internally so __toString returns a json encoded string.
     * @param null|array|object|File|string|PlainText $mValue
     *
     * @throws InvalidArgumentException
     */
    public function __construct($mValue = null)
    {
        if ($mValue instanceof PlainText)
        {
            $mJsonValue = "{$mValue}";
        }
        elseif($mValue instanceof File)
        {
            $tmp = $mValue->contents();
            // Would throw an Exception if passed string is not valid json
            $mJsonValue = JsonUtils::encode(JsonUtils::decode($tmp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        elseif (is_string($mValue))
        {
            // Would throw an Exception if passed string is not valid json
            $mJsonValue = JsonUtils::encode(JsonUtils::decode($mValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        elseif (is_array($mValue) || is_object($mValue))
        {
            $mJsonValue = JsonUtils::encode($mValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        parent::__construct($mJsonValue);
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function toArray(): array
    {
        return JsonUtils::decode($this->getValue());
    }

    public function getValue()
    {
        return parent::getValue();
    }
}
