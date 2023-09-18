<?php

namespace Hurah\Types\Type;


use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\ArrayUtils;
use Hurah\Types\Util\JsonUtils;
use ReturnTypeWillChange;

/**
 * Manages the lookups (<option>) of a select / dropdown menu.
 */
class LookupCollection extends AbstractCollectionDataType implements IComplexDataType
{
    /**
     * @param ...$data,
     *
     * @return LookupCollection
     */
    public static function create(...$data):LookupCollection
    {
        $oSelf = new self();
        foreach ($data as $item)
        {
            if($item instanceof Lookup)
            {
                $oSelf->add($item);
            }
            elseif(is_array($item) && ArrayUtils::isAssociative($item))
            {
                $oSelf->add(Lookup::createMixed($item));
            }
            elseif(is_array($item) && ArrayUtils::isSequential($item))
            {
                foreach ($item as $child)
                {
                    $oSelf = $oSelf->merge(self::create($child));
                }

            }
            elseif($item instanceof KeyValueCollection)
            {
                foreach($item as $oKeyValue)
                {
                    $oSelf->add(Lookup::createMixed($oKeyValue));
                }
            }
        }
        return $oSelf;
    }
    public function setSelected(string $sValue, bool $bDeselectOthers):self
    {
        if($bDeselectOthers)
        {
            $this->deselectAll();
        }
        foreach ($this as $item)
        {
            if($item->getValue() == $sValue)
            {
                $item->setSelected();
            }

        }
        return $this;
    }
    public function deselectAll():self
    {
        foreach ($this as $item)
        {
            $item->setSelected(false);
        }
        return $this;
    }
    public function merge(LookupCollection $oLookupCollection):self
    {
        $oClone = clone $this;
        foreach ($oLookupCollection as $oLookup)
        {
            $oClone->add($oLookup);
        }
        return $oClone;
    }
    public function add(Lookup $lookup):void
    {
        $this->array[] = $lookup;
    }
    #[ReturnTypeWillChange] public function current():Lookup
    {
        return $this->array[$this->position];
    }
    public function __toString():string
    {
        $aOut = [];
        foreach($this as $lookup)
        {
            $aOut[] = (string) $lookup;
        }
        return join(PHP_EOL, $aOut);
    }
}
