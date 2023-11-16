<?php

namespace Hurah\Types\Type;

use DateTime as PhpNativeDateTime;
use Hurah\Types\Exception\InvalidArgumentException;

class DateTime extends AbstractDataType implements IGenericDataType
{

	private ?PhpNativeDateTime $innerValue;

	/**
	 * @throws InvalidArgumentException
	 */
	public function setValue($sValue)
	{
		if($sValue instanceof \DateTime)
		{
			$this->innerValue = $sValue;
		}
		else if(is_int($sValue))
		{
			$oValue = new PhpNativeDateTime();
			$oValue->setTimestamp($sValue);
			$this->innerValue = $oValue;
		}
		else if($sValue === null)
		{
			$this->innerValue = null;
		}
		else
		{
			throw new InvalidArgumentException("Class DateTime expects a unix timestamp, a php DateTime object or null");
		}


		parent::setValue($sValue);
	}

	public function getValue(): ?PhpNativeDateTime
	{
		return $this->innerValue;
	}
	public function __construct($sValue = null)
    {
     	$this->setValue($sValue);
        parent::__construct($sValue);
    }
    public function getHour24():int
    {
        return (int) $this->toDateTime()->format('G');
    }
    public function getMinute():int
    {
        return (int) $this->toDateTime()->format('i');
    }
    public function setTimestamp(int $iTimestamp):self
    {

        $this->toDateTime()->setTimestamp($iTimestamp);
        return $this;
    }
	public function toTimestamp():int
	{
		return $this->toDateTime()->getTimestamp();
	}

    /**
     * @throws InvalidArgumentException
     */
    public function getTime():Time
    {
        $oDateTime = $this->getValue();
        if(!$oDateTime instanceof PhpNativeDateTime)
        {
            return new Time($oDateTime->format('H:i'));
        }
        return new Time($oDateTime->format('H:i'));
    }

    public function isBetween(PhpNativeDateTime $oStartTime, PhpNativeDateTime $oEndTime):bool
    {
        if($this->toDateTime() > $oStartTime && $this->toDateTime() < $oEndTime)
        {
            return true;
        }
        return false;
    }

    /**
     * Returns a Php \DateTime object
     * @return \Hurah\Types\Type\DateTime
     */
    public function toDateTime():PhpNativeDateTime
    {
        if($this->getValue() === null)
        {
            $this->setValue(new PhpNativeDateTime());
        }
        return $this->getValue();
    }

    public function __toString():string
    {
        $oCurrentValue = $this->getValue();

        if(is_int($oCurrentValue) && $oCurrentValue > 0)
        {
            $oNativeDateTime = new PhpNativeDateTime();
            $oNativeDateTime->setTimestamp($oCurrentValue);
            $oCurrentValue = $oNativeDateTime;
        }

        if($oCurrentValue instanceof PhpNativeDateTime)
        {
            return $oCurrentValue->format('Y-m-d H:i:s');
        }

        return '';
    }

}
