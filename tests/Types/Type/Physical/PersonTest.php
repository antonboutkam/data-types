<?php

namespace Test\Hurah\Types\Type\Physical;

use Hurah\Types\Type\Physical\Person;
use Hurah\Types\Type\Physical\Person\FullName;
use Hurah\Types\Type\Physical\Person\Name\FirstName;
use Hurah\Types\Type\Physical\Person\Name\FamilyName;

use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
	public function testCreate() {
		$fullName = FullName::create(FirstName::make('Anton'),$expected =  FamilyName::make('Boutkam'));
		$person = Person::create($fullName);
		$this->assertEquals($person->getFullName()->getFamilyName(), $expected);
	}
}
