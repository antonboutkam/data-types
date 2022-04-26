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

    public static function create(string $sKey, string $sValue):self
    {
        return new KeyValue(['key' => $sKey, 'value' => $sValue]);
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