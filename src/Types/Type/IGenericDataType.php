<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

interface IGenericDataType
{
    /**
     * IGenericDataType constructor.
     * @param null $sValue
     */
    public function __construct($sValue = null);

    public function __toString(): string;

    public function setValue($sValue);

    public function getValue();
}
