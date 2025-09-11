<?php

namespace Hurah\Types\Type\Physical;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Physical\Person\DateOfBirth;
use Hurah\Types\Type\Physical\Person\FullName;

/**
 *
 */
class Person extends AbstractDataType
{

	private FullName $fullName;

	private DateOfBirth $dateOfBirth;

	/**
	 * Person::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function create(FullName $fullName): self {
		$self = new self($fullName);
		$self->setFullName($fullName);
		return $self;
	}

	public function setDateOfBirth(DateOfBirth $dateOfBirth)
	{
		$this->dateOfBirth = $dateOfBirth;
	}
	public function getDateOfBirth():DateOfBirth
	{
		return $this->dateOfBirth;
	}

	public function getFullName(): FullName
	{
		return $this->fullName;
	}

	public function setFullName(FullName $fullName): void
	{
		$this->fullName = $fullName;
	}
}
