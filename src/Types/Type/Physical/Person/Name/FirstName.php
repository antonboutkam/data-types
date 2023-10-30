<?php

namespace Hurah\Types\Type\Physical\Person\Name;

use Hurah\Types\Type\AbstractDataType;

/**
 *
 */
class FirstName extends AbstractDataType
{

	/**
	 * FirstName::__construct()
	 *
	 * @param null $sValue*/
	public function __construct($sValue = null) {
		parent::__construct($sValue);
	}

	/**
	 * FirstName::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function make(string $name): self {
		return new self($name);
	}
	public function __toString():string
	{
		return $this->getValue();
	}
}
