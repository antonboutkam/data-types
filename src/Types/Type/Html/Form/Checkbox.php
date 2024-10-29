<?php

namespace Hurah\Types\Type\Html\Form;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Html\AttributeCollection;
use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\IElementizable;
use Hurah\Types\Type\LookupCollection;

class Checkbox extends AbstractDataType implements IElementizable
{
    private ?string $sName = null;
    private bool $bReadOnly = false;
	private bool $bIsChecked = false;
	private mixed $sFieldValue = 1;

	/**
     * @param mixed $mName can be an array in the form of ['data', 'first_name'] which renders to data[first_name] or
     *     just a string.
     * @param LookupCollection $data
     * @param array $aOptions, currently only read_only is a valid option.
     *
     * @return self
     */
    public static function create(string $mName, LookupCollection $data, array $aOptions = []):self
    {
        $oSelf = new self();
        $oSelf->setName(...$mName);

		if(isset($aOptions['read_only']))
        {
            $oSelf->bReadOnly = (bool) $aOptions['read_only'];
        }
		if(isset($aOptions['checked']))
		{
			$oSelf->bIsChecked = (bool) $aOptions['checked'];
		}
        return $oSelf;
    }
	public function setFieldValue(mixed $sFieldValue):self
	{
		$this->sFieldValue = $sFieldValue;
		return $this;
	}
	public function getFieldValue():self
	{
		return $this->sFieldValue;
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
	public function setChecked(bool $bChecked = true):self
	{
		$this->bIsChecked = $bChecked;
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

    public function getReadOnly():bool
    {
        return $this->bReadOnly;
    }
	public function getChecked():bool
	{
		return $this->bReadOnly;
	}

    public function toElement(): Element
    {
        return new Element((string) $this);
    }

    public function __toString():string
    {
        $aAttributes = [];

        if($this->bReadOnly) {
			$aAttributes['readonly'] = "readonly";
        }
		if ($this->bIsChecked) {
			$aAttributes['checked'] = 'checked';
		}
		if ($this->sName) {
			$aAttributes['name'] = $this->sName;
		}
		if ($this->getValue()) {
			$aAttributes['value'] = $this->getValue();
		}
		$aAttributes['type'] = 'checkbox';


		$oAttributeCollection = AttributeCollection::fromArray($aAttributes);
		$sOutput =  Element::create('input', $oAttributeCollection);
		return str_replace('"></input>', '" />', $sOutput);
    }
}
