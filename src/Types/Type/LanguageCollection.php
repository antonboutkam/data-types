<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

use Symfony\Component\Finder\Finder;
use function is_array;
use function is_string;
use function strlen;

class LanguageCollection extends AbstractCollectionDataType implements IGenericDataType {

    public static function combine(self ...$aCollections):self
    {
        $oCombined = new self();
        foreach($aCollections as $oCollection)
        {
            if($oCollection->isEmpty())
            {
                continue;
            }
            foreach($oCollection as $oLanguage)
            {
                $oCombined->add($oLanguage);
            }
        }
        return $oCombined;
    }
    public function merge(self ...$aCollections):self
    {
        foreach($aCollections as $oCollection)
        {
            if($oCollection->isEmpty())
            {
                continue;
            }
            foreach($oCollection as $oLanguage)
            {
                $this->add($oLanguage);
            }
        }
        return $this;
    }

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     */
    public function __construct($mValues = null) {

        if($mValues instanceof Language)
        {
            $this->add($mValues);
        }
        elseif($mValues instanceof LanguageCollection)
        {
            $this->merge($mValues);
        }

        parent::__construct([]);
    }
    public function addFromIso(string $sLanguageCode):self
    {
        $this->add(Language::fromIso($sLanguageCode));
        return $this;
    }
    public function addFromName(string $sLanguageName):self
    {
        $this->add(new Language($sLanguageName));
        return $this;
    }
    public function add(Language $oLanguage):self
    {
        $this->array[] = $oLanguage;
        return $this;
    }
     public function current():Language
    {
        return $this->array[$this->position];
    }
    public function contains(Language $oLanguage): bool
    {
        foreach($this as $oTestLanguage)
        {
            if($oTestLanguage->toIso3() === $oLanguage->toIso3())
            {
                return true;
            }
        }
        return false;
    }
}
