<?php

namespace Hurah\Types\Type;

use function is_iterable;

class SequentialCollection extends AbstractCollectionDataType
{
    /**
     * @param mixed $sValue expects null, an array, an instance of LiteralArray or an instance of  AbstractCollectionDataType
     */
    public function __construct($sValue = null)
    {
        if(is_array($sValue))
        {
            $this->addArray($sValue);
        }
        elseif($sValue instanceof LiteralArray)
        {
            $this->addArray($sValue->toArray());
        }
        elseif($sValue instanceof AbstractCollectionDataType)
        {
            $this->addArray($sValue->toArray());
        }
        parent::__construct($sValue);
    }

    public function current(): KeyValue
    {
        return $this->array[$this->position];
    }
    public function addArray(array $aItems):self
    {
        $oSelf = clone($this);
        foreach($aItems as $mItem)
        {
            $oSelf->add($mItem);
        }
        return $oSelf;

    }
    public function add($item)
    {
        $this->array[] = $item;
    }

    public function getUnique(): self
    {
        $aItems = array_unique($this->array);

        $oSelf = (new self())->addArray($aItems);;


        return $oSelf;
    }
}