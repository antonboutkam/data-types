<?php

namespace Hurah\Types\Type\Html\Form;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\IElementizable;
use Hurah\Types\Type\LookupCollection;

class Dropdown extends AbstractDataType implements IElementizable
{
    private ?string $sName = null;
    private LookupCollection $data;
    private bool $bReadOnly = false;

    /**
     * @param mixed $mName can be an array in the form of ['data', 'first_name'] which renders to data[first_name] or just a string.
     * @param LookupCollection $data
     * @param array $aOptions, currently only read_only is a valid option.
     *
     * @return self
     */
    public static function create($mName, LookupCollection $data, array $aOptions = []):self
    {
        $oSelf = new self();
        $oSelf->setName(...$mName);

        $oSelf->data = $data;
        if(isset($aOptions['read_only']))
        {
            $oSelf->bReadOnly = $aOptions['read_only'];
        }
        return $oSelf;
    }
    public function setName(...$sName):self
    {
        if(count($sName) === 0)
        {
            $this->sName = $sName;
        }
        else
        {
            $sCurrentName = array_shift($sName);
            foreach($sName as $sNamePart)
            {
                $sCurrentName = $sCurrentName  . '[' . $sNamePart . ']';
            }
            $this->sName = $sCurrentName;
        }

        return $this;
    }
    public function setLookups(LookupCollection $oLookups):self
    {
        $this->data = $oLookups;
        return $this;
    }
    public function setReadOnly(bool $bReadOnly = true):self
    {
        $this->bReadOnly = $bReadOnly;
        return $this;
    }
    public function getName():string
    {
        return $this->sName;
    }
    public function getLookups():LookupCollection
    {
        return $this->data;
    }
    public function getReadOnly():bool
    {
        return $this->bReadOnly;
    }
    public function toElement(): Element
    {
        return new Element((string) $this);
    }
    public function __toString():string
    {
        $aOut = [];
        $sReadonly = '';
        if($this->bReadOnly)
        {
            $sReadonly = 'readonly="readonly" ';
        }
        $aOut[] = "<select {$sReadonly}name=\"$this->sName\">";
        $aOut[] = (string) $this->data;
        $aOut[] = "</select>";

        return join(PHP_EOL, $aOut);
    }
}