<?php

namespace Hurah\Types\Type;

use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\IElementizable;

class Icon extends AbstractDataType implements IGenericDataType, IElementizable
{

    public function __construct($sValue = null)
    {
        parent::__construct($sValue);
    }
    public function toElement():Element
    {
        $oElement = Element::create('span');
        $oElement->addAttribute('class', "fa fa-regular fa-{$this}");
        return $oElement;
    }
    public function __toString(): string
    {
        $element = clone $this->toElement();
        $mValue = $element->getValue();
        return (string)$mValue;
    }


}
