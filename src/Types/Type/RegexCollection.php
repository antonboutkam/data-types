<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;


/**
 * Represents a regular expression
 * @package Hurah\Type
 */
class RegexCollection extends AbstractCollectionDataType implements ITestable
{
     public function current():Regex
    {
        return $this->array[$this->position];
    }

    /**
     * @param ...$regex Regex
     * @return self
     */
    public static function fromArray($aRegexes):self
    {
        $self = new self();
        foreach($aRegexes as $one)
        {
            $self->add($one);
        }
        return $self;
    }

    /**
     * @param ...$regex Regex
     * @return self
     */
    public static function create(...$regex):self
    {
        $self = new self();
        foreach($regex as $one)
        {
            $self->add($one);
        }
        return $self;
    }

    public function addArray(array $oRegexItems)
    {
        foreach($oRegexItems as $oRegexItem)
        {
            $this->array[] = $oRegexItem;
        }
        return $this;
    }

    public function add(Regex $oRegex)
    {
        $this->array[] = $oRegex;
        return $this;
    }

    /**
     *
     * @return bool
     */
    public function hasMatch(AbstractDataType $oString):bool
    {
        foreach($this as $oRegex)
        {
            if($oRegex->test((string) $oString))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * If one of the Regular expressions is a match this function returns true.
     * @param string $sSubject
     *
     * @return bool
     */
    public function test($sSubject):bool
    {
        foreach($this as $oRegex)
        {
            if($oRegex->test($sSubject))
            {
                return true;
            }
        }
        return false;
    }

    public function replaceAll(PlainText $oSubject, PlainText $oReplacement = null):PlainText
    {
        if($oReplacement === null)
        {
            $oReplacement = new PlainText('');
        }
        foreach($this as $oRegex)
        {
            $oSubject = $oRegex->replace($oSubject, $oReplacement);
        }
        return $oSubject;
    }

    public function removeAll($mSubect):PlainText
    {
        foreach($this as $oRegex)
        {
            $mSubect = $oRegex->remove($mSubect);
        }
        return $mSubect;
    }

    public function getAllMatches(string $sSubject):array
    {
        $aMatches = [];
        foreach($this as $oRegex)
        {
            $aExtraMatches = $oRegex->getMatches($sSubject);
            $aMatches = array_merge($aMatches, $aExtraMatches);
        }
        return $aMatches;
    }

}
