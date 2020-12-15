<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Icon;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Url;

class MenuItem extends AbstractDataType implements IElementizable {

    private Url $oUrl;
    private PlainText $sHtml;
    private ?Icon $oIcon = null;
    private ?AttributeCollection $oAttributeCollection = null;

    public function __construct($mValue = null) {
        parent::__construct($mValue);
    }

    /**
     * @param mixed ...$params
     * @return MenuItem
     * @throws InvalidArgumentException
     */
    public static function create(...$params): MenuItem {
        $oMenuItem = new MenuItem();
        $oMenuItem->oAttributeCollection = new AttributeCollection();
        foreach ($params as $param) {
            if ($param instanceof Url) {
                $oMenuItem->oUrl = $param;
            } elseif (is_string($param)) {
                $oMenuItem->sHtml = new PlainText($param);
            } elseif ($param instanceof Element) {
                $oMenuItem->sHtml = new PlainText("$param");
            } elseif ($param instanceof Icon) {
                $oMenuItem->oIcon = $param;
            } elseif ($param instanceof AttributeCollection) {
                $oMenuItem->oAttributeCollection->addCollection($param);
            } elseif ($param instanceof Attribute) {
                $oMenuItem->oAttributeCollection->addAttribute($param);
            }
        }
        return $oMenuItem;
    }

    /**
     * @return Element
     * @throws InvalidArgumentException
     */
    public function toElement(): Element {
        $oContainer = Element::create('li');
        $oContainer->addChild($this->oIcon);
        $oContainer->addChild(Link::create($this->oUrl, $this->sHtml));
        return $oContainer;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function __toString(): string {
        return "{$this->toElement()}";
    }
}
