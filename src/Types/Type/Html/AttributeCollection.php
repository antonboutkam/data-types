<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\IComplexDataType;

class AttributeCollection extends AbstractCollectionDataType implements IComplexDataType
{
    protected int $position = 0;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An Attribute or an Attributes[]
     * @throws InvalidArgumentException
     */
    public function __construct($mValues = null)
    {
        parent::__construct([]);

        $this->position = 0;
        $this->array = [];


        if (is_iterable($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    public function addCollection(AttributeCollection $oAttributeCollection) : void
    {
        foreach ($oAttributeCollection as $oAttribute)
        {
            $this->addAttribute($oAttribute);
        }
    }

    public function addAttribute(Attribute $oAttribute) : void
    {
        array_push($this->array, $oAttribute);
    }

    /**
     * Possible usages:
     *
     * $oCollection->add($sType, $sValue);
     * $oCollection->add($sType, $sValue);
     * $oCollection->add($sType);
     * $oCollection->add(Attribute);
     * $oCollection->add(AttributeCollection);
     * $oCollection->add(['type' => $sType, 'value' => $sValue]);
     * $oCollection->add(['type' => $sType]);
     *
     * @param $mValue
     * @return AttributeCollection
     * @throws InvalidArgumentException
     */
    public function add(...$mValue): AttributeCollection
    {
        if($mValue[0] instanceof Attribute)
        {
            $this->addAttribute($mValue[0]);
            return $this;
        }
        elseif($mValue[0] instanceof AttributeCollection)
        {
            $this->addCollection($mValue[0]);
            return $this;
        }
        elseif(is_array($mValue[0]) && isset($mValue[0]['type']))
        {
            $this->addAttribute(new Attribute($mValue[0]));
            return $this;
        }
        elseif(is_string($mValue[0]) && is_string($mValue[1]))
        {
            $this->addAttribute(new Attribute(['type' => $mValue[0], 'value' => $mValue[1]]));
            return $this;
        }
        elseif(is_string($mValue[0]))
        {
            $this->addAttribute(new Attribute(['type' => $mValue[0]]));
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
        foreach ($this->array as $oAttribute)
        {
            $aOut[] = "$oAttribute";
        }
        if(empty($aOut))
        {
            return '';
        }
        return ' ' . join(' ', $aOut);
    }

    public function current(): Attribute
    {
        return $this->array[$this->position];
    }
}
