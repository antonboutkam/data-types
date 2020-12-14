<?php

namespace Hurah\Types\Type\Html;

use Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\PlainText;

class Attribute extends AbstractDataType {

    private PlainText $sAttributeType;
    private PlainText $sAttributeValue;

    public function __construct($mValue = null)
    {
        if(!isset($mValue['type']))
        {
            throw new InvalidArgumentException("Attributes need a type");
        }

        $this->sAttributeType = new PlainText((string)$mValue['type']);
        if(isset($mValue['value']))
        {
            $this->sAttributeValue = new PlainText((string) $mValue['value']);
        }
        parent::__construct($mValue);
    }
    public static function create(string $sType, string $sValue):self
    {
        return new self(['type' => $sType, 'value' => $sValue]);
    }
    public function __toString(): string {
        if($this->sAttributeValue)
        {
            return "{$this->sAttributeType}=\"{$this->sAttributeValue}\"";
        }
        return "{$this->sAttributeType}=\"\"";
    }
}
