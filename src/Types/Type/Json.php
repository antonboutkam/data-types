<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;

class Json extends AbstractDataType implements IGenericDataType
{
    public function __construct($mValue = null)
    {
        if (is_array($mValue) || is_object($mValue)) {
            $mValue = JsonUtils::encode($mValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        parent::__construct($mValue);
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
