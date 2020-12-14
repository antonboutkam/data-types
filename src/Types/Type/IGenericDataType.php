<?php

namespace Hurah\Types\Type;

interface IGenericDataType
{
    public function __construct($sValue = null);

    public function __toString(): string;

    public function setValue($sValue);

    public function getValue();
}
