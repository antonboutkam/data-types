<?php

namespace Hurah\Types\Type;

class Email extends AbstractDataType implements IGenericDataType
{

    public function isValid(): bool
    {
        if (filter_var($this->getValue(), FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public static function make(string $sEmail): self
    {
        return new self($sEmail);
    }
}
