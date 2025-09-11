<?php

namespace Hurah\Types\Type\Physical\Person\Name;

use Hurah\Types\Type\AbstractDataType;

/**
 *
 */
class NamePrefix extends AbstractDataType
{


	/**
	 * NamePrefix::__construct()
	 *
	 * @param null $sValue*/
	public function __construct($sValue = null) {
		parent::__construct($sValue);
	}

	/**
	 * NamePrefix::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function make(string $sNamePrefix): self {
		return new self($sNamePrefix);
	}

	public function __toString():string
	{
		return $this->getValue();
	}
}
