<?php

namespace Hurah\Types\Type\Php;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;

class VarName extends AbstractDataType implements IGenericDataType {
    public function __construct($mValue = null)
    {
        parent::__construct($mValue);
    }
}
