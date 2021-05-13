<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Represents a regular expression
 * @package Hurah\Type
 */
class RegexCollection extends AbstractCollectionDataType
{
    public function current():Regex
    {
        return $this->array[$this->position];
    }

    public function add(Regex $oRegex)
    {
        $this->array[] = $oRegex;
    }

    /**
     *
     * @return bool
     */
    public function hasMatch(PlainText $oString):bool
    {
        foreach($this as $oRegex)
        {
            if($oRegex->test($oString))
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

    public function removeAll(PlainText $oSubject):PlainText
    {
        foreach($this as $oRegex)
        {
            $oSubject = $oRegex->remove($oSubject);
        }
        return $oSubject;
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
