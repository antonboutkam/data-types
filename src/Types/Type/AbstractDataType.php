<?php

namespace Hurah\Types\Type;


abstract class AbstractDataType implements IGenericDataType
{
    private $sValue;

    public function __construct($sValue = null)
    {
        $this->sValue = $sValue;
    }

    public function setValue($sValue):self
    {
        $this->sValue = $sValue;
		return $this;
    }

    public function __toString(): string
    {
        return (string)$this->getValue();
    }

    public function getValue()
    {
        return $this->sValue;
    }

    public function isValid(): bool
    {
        return true;
    }
}
