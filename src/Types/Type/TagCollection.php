<?php

namespace Hurah\Types\Type;

class TagCollection extends AbstractCollectionDataType
{
    public function current():Tag
    {
        return $this->array[$this->position];
    }

    public function add(Tag $oTag)
    {
        $this->array[] = $oTag;
    }

    /**
     * Check if tag in list
     * @param Tag $oTag
     *
     * @return bool
     */
    public function has(Tag $oTag):bool
    {
        foreach ($this as $oCompareTag)
        {
            if("$oCompareTag" === "$oTag")
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Creates a new collection that combines the collections that are passed with the current collection.
     * @param TagCollection ...$oTagCollections
     *
     * @return TagCollection
     */
    public function merge(self ...$oTagCollections):TagCollection
    {
        $oNewCollection = clone $this;
        foreach ($oTagCollections as $oTagCollection)
        {
            foreach ($oTagCollection as $oTag)
            {
                $oNewCollection->add($oTag);
            }
        }
        return $oNewCollection;

    }

}
