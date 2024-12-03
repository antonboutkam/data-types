<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Url;

class Link extends AbstractDataType implements IElementizable {

    use AttributesTrait;

    private ?PlainText $sHtml = null;
    public const TARGET_BLANK = '_blank';
    public const TARGET_SELF = '_self';
    public const TARGET_PARENT = '_parent';
    public const TARGET_TOP = '_top';

    /**
     * Link constructor.
     * @param null $mValue
     * @throws InvalidArgumentException
     */
    public function __construct($mValue = null) {
        parent::__construct($mValue);

        if (isset($mValue['html']) && is_string($mValue['html']))
        {
            $this->sHtml = new PlainText($mValue['html']);
        }
        elseif(isset($mValue['html']))
        {
            $this->sHtml = $mValue['html'];
        }

        $this->oAttributes = new AttributeCollection();

        $aPossibleAttributes = [
            'href',
            'title',
            'id',
            'style',
            'tabindex',
            'hreflang',
            'media',
            'ping',
            'rel',
            'target',
            'type',
        ];
        foreach ($aPossibleAttributes as $sKey) {
            if (isset($mValue[$sKey])) {
                $this->oAttributes->add($sKey, "{$mValue[$sKey]}");
            }
        }

    }

    /**
     * @param Url $oUrl
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setHref(Url $oUrl) : self {
        $this->addAttribute('href', $oUrl);
        return $this;
    }

    /**
     * @param Url|null $oUrl
     * @param AbstractDataType|null $sHtml
     * @param string|null $sTitle
     * @param string|null $sTarget
     * @return Link
     * @throws InvalidArgumentException
     */
    public static function create(Url $oUrl = null, AbstractDataType $sHtml = null, string $sTitle = null, string $sTarget = null): Link {

        $aConstructorArguments = [];

        if($oUrl)
        {
            $aConstructorArguments['href'] = $oUrl;
        }

        if($sHtml)
        {
            $aConstructorArguments['html'] = $sHtml;
        }
        if($sTarget)
        {
            $aConstructorArguments['target'] = $sTarget;
        }
        if($sTitle)
        {
            $aConstructorArguments['title'] = $sTitle;
        }

        return new self($aConstructorArguments);
    }

    /**
     * @return Element
     * @throws InvalidArgumentException
     */
    public function toElement(): Element {
        $oElement = Element::create('a');

        if($this->oAttributes)
        {
            $oElement->addAttributes($this->oAttributes);
        }

        if($this->aChildren && is_iterable($this->aChildren))
        {
            foreach($this->aChildren as $oChild)
            {
                $oElement->addChild($oChild);
            }
        }
        if($this->sHtml)
        {
            $oElement->addHtml($this->sHtml);
        }
        return $oElement;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function __toString(): string {
        return "{$this->toElement()}";
    }
}
