<?php

namespace Test\Hurah\Types\Type\Physical\Person;

use DateTime;
use Hurah\Types\Type\Date;
use Hurah\Types\Type\Physical\Person\DateOfBirth;
use PHPUnit\Framework\TestCase;

class DateOfBirthTest extends TestCase
{

	public function testCreate(): void
	{
		$oDate = Date::createFromVars(2023, 10, 30);
		$oDate2 = DateOfBirth::createFromNative((new DateTime())->setTimestamp(time()));
		$this->assertTrue($oDate->getTimestamp() < $oDate2->getTimestamp());
	}
}
