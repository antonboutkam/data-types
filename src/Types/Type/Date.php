<?php

namespace Hurah\Types\Type;
use \DateTime;

class Date extends AbstractDataType implements IGenericDataType
{

	/**
	 * DateOfBirth::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function create(Date $dob): self {
		return self::create($dob);
	}


	/**
	 * DateOfBirth::createFromNative()
	 *
	 * @return static
	 */
	public static function createFromNative(\DateTime $dob): self {
		$result = new self();
		$result->setValue($dob);
		return $result;
	}
	/**
	 * DateOfBirth::createFromString()
	 *
	 * @return static
	 */
	public static function createFromString(string $dob): self {
		$result = new self();
		$time = strtotime($dob);
		$oDateTime = new DateTime();
		$oDateTime->setTimestamp($time);
		$result->setValue($oDateTime);
		return $result;
	}

	/**
	 * DateOfBirth::createFromVars()
	 *
	 * @return static
	 */
	public static function createFromVars(int $iYear, int $iMonth, int $iDay): self {
		$result = new self();
		$time = mktime(0, 0, 0, $iMonth, $iDay, $iYear);
		$oDateTime = new DateTime();
		$oDateTime->setTimestamp($time);
		$result->setValue($oDateTime);
		return $result;
	}
	public function toNativeDateTime():\DateTime
	{
		return $this->getValue();
	}
	public function getTimestamp():int
	{
		return $this->toNativeDateTime()->getTimestamp();
	}
}
