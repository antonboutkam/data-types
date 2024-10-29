<?php

namespace Hurah\Types\Type;

class KeyValue extends AbstractDataType
{
    private string $sKey;
    private $sValue;

    public function __construct($aValue = null)
    {
        if(isset($aValue['key']) && isset($aValue['value']))
        {
            $this->sKey = $aValue['key'];
            $this->sValue = $aValue['value'];

        }
        parent::__construct($aValue);
    }

    public static function create(string $sKey, $sValue):self
    {
        return new KeyValue(['key' => $sKey, 'value' => $sValue]);
    }

    public function setKey(string $sKey): void
	{
        $this->sKey = $sKey;
    }
    public function setValue($sValue): AbstractDataType
	{
        $this->sValue = $sValue;
		return $this;
    }
    public function addValue($sValue):void
    {
        if(isset($this->sValue) && is_array($this->sValue))
        {
            $this->sValue[] = $sValue;
            return;
        }

        $this->sValue  = [$this->sValue, $sValue];
    }

    public function getKey():string
    {
        return $this->sKey;
    }

    public function getValue()
    {
        return $this->sValue;
    }
}
