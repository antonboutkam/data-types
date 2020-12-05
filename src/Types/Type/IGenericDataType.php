<?php

namespace Hurah\Types\Type;

interface IGenericDataType {
    function __construct($sValue = null);

    function __toString(): string;

    function setValue($sValue);

    function getValue();
}
