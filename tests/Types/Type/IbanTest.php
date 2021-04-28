<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Iban;
use PHPUnit\Framework\TestCase;

class IbanTest extends TestCase
{

    public function testConstructor() {

        $oIban = new Iban('ALLGOOD');
        $this->assertEquals("ALLGOOD", "{$oIban}");
    }

    public function testInvalidArgumentException() {

        $this->expectException(InvalidArgumentException::class);
        Iban::fromString('ISBAD');
    }
    public function testFromString() {

        $oIban = Iban::fromString('NL73INGB0666396175');
        $this->assertInstanceOf(Iban::class, $oIban);

        $oIban = Iban::fromString('BE76732014253795');
        $this->assertInstanceOf(Iban::class, $oIban);
    }
}

