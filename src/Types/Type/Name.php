<?php

namespace Hurah\Types\Type;

class Name extends AbstractDataType implements IGenericDataType
{

    public function isValid(): bool
    {
        if (empty($this->getValue())) {
            return true;
        }
        return false;
    }
}
