<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Html;
use Hurah\Types\Type\PlainText;

class Element extends AbstractDataType implements IElementizable {

    use AttributesTrait;

    // When type is null, the child elements are returned and no container element (this object) is surrounding it.
    private ?string $sType = null;

    protected AttributeCollection $oAttributes;

    public function __construct($mValue = null) {
        $this->oAttributes = new AttributeCollection();
        $this->aChildren = [];
        if (isset($mValue['type'])) {
            $this->sType = new PlainText((string)$mValue['type']);
        }
        if (isset($mValue['attributes'])) {
            $this->oAttributes = $mValue['attributes'];
        }
        if (isset($mValue['html']) && $mValue['html'] instanceof IElementizable) {
            $this->addChild($mValue['html']);
        }
        if (isset($mValue['html']) && $mValue['html'] instanceof PlainText) {
            $this->addHtml($mValue['html']);
        }

        parent::__construct($mValue);
    }

    public function toElement(): Element {
        return $this;
    }

    public function setType(string $sType): Element {
        $this->sType = $sType;
        return $this;
    }

    public static function create(string $sType = null, AttributeCollection $attributes = null): Element {
        $oElement = new Element();
        if ($sType) {
            $oElement->setType($sType);
        }
        if ($attributes) {
            $oElement->setAttributes($attributes);
        }
        return $oElement;
    }

    public function __toString(): string {
        $oHtml = new Html();

        if (!$this->sType) {
            return join(PHP_EOL, $this->aChildren);
        }
        if (!empty($this->aChildren)) {
            $oHtml->addLn("<{$this->sType}{$this->oAttributes}>");
            foreach ($this->aChildren as $oChild) {
                $oHtml->addLn("{$oChild}");
            }
            $oHtml->addLn('</' . $this->sType . '>');
        } else {
            $oHtml->addLn("<{$this->sType}{$this->oAttributes}></{$this->sType}>");
        }
        return "{$oHtml}";
    }
}
