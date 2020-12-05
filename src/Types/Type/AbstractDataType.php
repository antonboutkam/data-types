<?php

namespace Hurah\Types\Type;

abstract class AbstractDataType implements IGenericDataType {
    private $sValue;

    function __construct($sValue = null) {
        $this->sValue = $sValue;
    }

    function setValue($sValue) {
        $this->sValue = $sValue;
    }

    function __toString(): string {
        return (string)$this->getValue();
    }

    function getValue() {
        return $this->sValue;
    }

    function isValid(): bool {
        return true;
    }

}
