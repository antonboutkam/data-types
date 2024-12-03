<?php

namespace Hurah\Types\Type;



class TagCollection extends AbstractCollectionDataType implements ITestable
{
    public static function fromArray(array $aTags):self
    {
        $o = new self();
        foreach($aTags as $oTag)
        {
            $o->addString($oTag);
        }
        return $o;
    }

	/**
	 * Extracts hashtags from a PlainText object and creates a collection based
	 * on the results.
	 * @param PlainText $oPlainText
	 *
	 * @return TagCollection
	 */
	public static function fromPlainText(PlainText $oPlainText): TagCollection
	{
		$matches = [];
		preg_match_all('/#(\w+)/', (string)$oPlainText, $matches);
		return self::fromArray($matches[1] ?? []);
	}

    public static function fromTags(Tag ...$tags):self
    {
        $o = new self();
        foreach($tags as $tag)
        {
            $o->add($tag);
        }
        return $o;
    }

     public function current():Tag
    {
        return $this->array[$this->position];
    }

    public function addString(string $sTag):self
    {
        $this->add(new Tag($sTag));
		return $this;
    }
    public function add(Tag $oTag):self
    {
        $this->array[] = $oTag;
		return $this;
    }

    /**
     * Returns true when one or more of the tags in the collection occur in $sSubject.
     * @param string $sSubject
     *
     * @return bool
     */
    public function test($sSubject):bool
    {
        foreach($this as $oTag)
        {
            if($oTag->test($sSubject))
            {
                return true;
            }
        }
        return false;
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
