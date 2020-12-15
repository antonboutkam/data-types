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
        return Element::create('i')->addClass("fa fa-{$this}");
    }

}
