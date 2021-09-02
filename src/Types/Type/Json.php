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
            $mJsonValue = $mValue;
        }
        elseif (is_string($mValue))
        {
            $mJsonValue = $mValue;
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
