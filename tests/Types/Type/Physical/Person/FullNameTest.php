<?php

namespace Test\Hurah\Types\Type\Physical\Person;

use Hurah\Types\Type\Physical\Person\FullName;
use Hurah\Types\Type\Physical\Person\Name\FamilyName;
use Hurah\Types\Type\Physical\Person\Name\FirstName;
use Hurah\Types\Type\Physical\Person\Name\MiddleName;
use PHPUnit\Framework\TestCase;

class FullNameTest extends TestCase
{

	public function testCreateString() {
		$me = FullName::createString('Anton', 'Boutkam');
		$expected = 'Anton Boutkam';
		$this->assertEquals($expected, "{$me}");

	}

	public function test__toString() {
		$me = FullName::createString('Anton', 'Boutkam');

		$expected1 = 'Anton Boutkam';
		$this->assertEquals($expected1, "{$me}");

	//	$me->setMiddleName(new MiddleName('van de'));
	// $expected2 = 'Anton van de Boutkam';
	//	$this->assertEquals($expected2, "{$me}");
	}


	public function testCreate() {
		$me1 = FullName::createString('Anton', 'Boutkam');
		$expected = 'Anton';
		$this->assertEquals($expected, "{$me1->getFirstName()}");

	}
}
