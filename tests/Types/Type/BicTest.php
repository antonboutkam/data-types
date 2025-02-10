<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Bic;
use Hurah\Types\Type\Swift;
use PHPUnit\Framework\TestCase;

class BicTest extends TestCase
{
	public function testValidation()
	{
		$this->assertInstanceOf(Bic::class, Bic::make('ABNANL2A'));
	}
	public function testValidation2()
	{
		$this->assertInstanceOf(Bic::class, Bic::make('AB NA NL 2A'));
		$this->assertInstanceOf(Bic::class, Swift::make('AB NA NL 2A'));
	}
}
