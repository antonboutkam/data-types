<?php

namespace Hurah\Types\Type\Physical\Person\Name;

use Hurah\Types\Type\AbstractDataType;

/**
 *
 */
class MiddleName extends AbstractDataType
{


	/**
	 * MiddleName::__construct()
	 *
	 * @param null $sValue*/
	public function __construct($sValue = null) {
		parent::__construct($sValue);
	}

	/**
	 * MiddleName::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function make(string $sMiddleName): self {
		return new self($sMiddleName);
	}
	public function __toString():string
	{
		return $this->getValue();
	}
}
