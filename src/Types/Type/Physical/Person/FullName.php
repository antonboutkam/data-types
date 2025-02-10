<?php

namespace Hurah\Types\Type\Physical\Person;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Physical\Person\Name\FamilyName;
use Hurah\Types\Type\Physical\Person\Name\FirstName;
use Hurah\Types\Type\Physical\Person\Name\MiddleName;
use Hurah\Types\Type\Physical\Person\Name\NamePrefix;

/**
 *
 */
class FullName extends AbstractDataType
{

	private ?NamePrefix $namePrefix = null;
	private ?FirstName $firstName = null;
	private ?MiddleName $middleName = null;

	private ?FamilyName $familyName = null;


	/**
	 * FullName::__construct()
	 *
	 * @param null $sValue
	 **/
	public function __construct($sValue = null) {
		parent::__construct($sValue);
	}

	/**
	 * FullName::create()
	 * @generate [properties, getters, setters, adders, createFromArray, toArray]
	 *
	 * @return static
	 */
	public static function create(FirstName $firstName, FamilyName $familyName): self {
		$self = new self();
		$self->setFirstName($firstName);
		$self->setFamilyName($familyName);
		return $self;
	}

	public static function createString(string $firstName, string $familyName):self{
		return self::create(
			FirstName::make($firstName),
			FamilyName::make($familyName)
		);
	}

	public function getFirstName(): FirstName
	{
		return $this->firstName;
	}

	public function setFirstName(FirstName $firstName): void
	{
		$this->firstName = $firstName;
	}

	public function getFamilyName(): FamilyName
	{
		return $this->familyName;
	}

	public function setFamilyName(FamilyName $familyName): void
	{
		$this->familyName = $familyName;
	}

	public function getNamePrefix(): ?NamePrefix
	{
		return $this->namePrefix;
	}

	public function setNamePrefix(NamePrefix $namePrefix): void
	{
		$this->namePrefix = $namePrefix;
	}

	public function getMiddleName(): ?MiddleName
	{
		return $this->middleName;
	}

	public function setMiddleName(MiddleName $middleName): void
	{
		$this->middleName = $middleName;
	}
	public function __toString():string
	{
		$aParts = [
			"{$this->getNamePrefix()}",
			"{$this->getFirstName()}",
			"{$this->getMiddleName()}",
			"{$this->getFamilyName()}"
		];
		return join(" ", array_filter($aParts));
	}

}
