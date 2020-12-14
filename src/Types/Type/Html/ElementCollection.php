<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\IComplexDataType;

class ElementCollection extends AbstractCollectionDataType implements IComplexDataType
{
    private int $position = 0;
    private array $data;

    /***
     * PathCollection constructor.
     *
     * @param array $mValues - An array of strings[] or Path[], internally will all be converted to Paths.
     */
    public function __construct($mValues = null)
    {
        parent::__construct([]);

        $this->position = 0;
        $this->data = [];


        if (is_iterable($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }
    public function current(): Element
    {
        return $this->data[$this->position];
    }
    public function addCollection(ElementCollection $oElementCollection) : void
    {
        foreach ($oElementCollection as $oElement)
        {
            $this->addElement($oElement);
        }
    }
    public function addElement(Element $oElement) : void
    {
        array_push($this->data, $oElement);
    }
    /**
     * @param $mValue
     * @throws InvalidArgumentException
     */
    public function add($mValue): self
    {
        if($mValue instanceof Element)
        {
            $this->addElement($mValue);
            return $this;
        }
        elseif($mValue instanceof ElementCollection)
        {
            $this->addCollection($mValue);
            return $this;
        }
        elseif(is_array($mValue) && isset($mValue['type']))
        {
            $this->addElement(new Element($mValue));
            return $this;
        }
        throw new InvalidArgumentException("Only DnsName and strings are valid arguments.");
    }

    public function toArray(): array
    {
        return $this->getValue();
    }

    public function __toString(): string
    {
        $aOut = [];
        foreach ($this as $oElement)
        {
            $aOut[] = "$oElement";
        }
        if(empty($aOut))
        {
            return '';
        }
        return ' ' . join(' ', $aOut);
    }
}
