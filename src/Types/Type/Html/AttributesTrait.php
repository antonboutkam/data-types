<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\PlainText;

trait AttributesTrait {

    protected AttributeCollection $oAttributes;
    private array $aChildren;

    /**
     * @param string $sAttributeValue
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addClass(string $sAttributeValue): self {
        $this->addAttribute('class', $sAttributeValue);
        return $this;
    }

    /**
     * @param string $sAttributeType
     * @param string $sAttributeValue
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addAttribute(string $sAttributeType, string $sAttributeValue): self {
        $this->oAttributes->add(new Attribute([
            'type'  => $sAttributeType,
            'value' => $sAttributeValue,
        ]));
        return $this;
    }
    /**
     * @param AttributeCollection $oAttributeCollection
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addAttributes(AttributeCollection $oAttributeCollection): self {
        foreach($oAttributeCollection as $oAttribute)
        {
            $this->oAttributes->add($oAttribute);
        }
        return $this;
    }
    public function addHtml(PlainText $oItem)
    {
        $this->aChildren[] = $oItem;
        return $this;
    }
    public function addChild(IElementizable $oItem): self {
        $this->aChildren[] = $oItem->toElement();
        return $this;
    }

    public function setAttributes(AttributeCollection $attributeCollection): self {
        $this->oAttributes = $attributeCollection;
        return $this;
    }

    /**
     * @param string $sId
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setId(string $sId): self {
        $this->addAttribute('id', $sId);
        return $this;
    }


}
