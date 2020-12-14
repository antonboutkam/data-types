<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\Html\Attribute\Iterator;
use Hurah\Types\Type\IComplexDataType;

class AttributeCollection extends AbstractCollectionDataType implements IComplexDataType
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

    public function addCollection(AttributeCollection $oAttributeCollection) : void
    {
        $oIterator = $oAttributeCollection->getIterator();
        foreach ($oIterator as $oAttribute)
        {
            $this->addAttribute($oAttribute);
        }
    }

    public function addAttribute(Attribute $oAttribute) : void
    {
        array_push($this->data, $oAttribute);
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

    public function getIterator(): Iterator
    {
        return new Iterator($this);
    }

    public function __toString(): string
    {
        $aOut = [];
        $aAttributes = $this->getIterator();
        foreach ($aAttributes as $oAttribute)
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
        return $this->data[$this->position];
    }
}
