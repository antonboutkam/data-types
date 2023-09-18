<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\IComplexDataType;
use ReturnTypeWillChange;

class MenuItemCollection extends AbstractCollectionDataType implements IComplexDataType, IElementizable
{
    protected int $position;
    protected array $data;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or Path[], internally will all be converted to Paths.
     * @throws InvalidArgumentException
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

    public function count():int
    {
        return count($this->data);
    }
    public function addCollection(MenuItemCollection $oMenuItemCollection) : void
    {
        foreach ($oMenuItemCollection as $oMenuItem)
        {
            $this->addMenuItem($oMenuItem);
        }
    }
    public function addMenuItem(MenuItem $oMenuItem) : void
    {
        array_push($this->data, $oMenuItem);
    }
    /**
     * @param $mValue
     * @throws InvalidArgumentException
     */
    public function add($mValue): void
    {

        if($mValue instanceof MenuItem)
        {
            $this->addMenuItem($mValue);
            return;
        }
        elseif($mValue instanceof MenuItemCollection)
        {
            $this->addCollection($mValue);
        }
        elseif(is_array($mValue) && isset($mValue['type']))
        {
            $this->addMenuItem(new MenuItem($mValue));
            return;
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
        foreach ($this as $oMenuItem)
        {
            $aOut[] = "$oMenuItem";
        }
        if(empty($aOut))
        {
            return '';
        }
        return ' ' . join(' ', $aOut);
    }

    #[ReturnTypeWillChange] public function current():MenuItem {
        return $this->data[$this->position];
    }

    public function toElement(): Element {
        $oElement = Element::create();

        foreach ($this as $oMenuItem)
        {
            $oElement->addChild($oMenuItem);
        }
        return $oElement;
    }
}
