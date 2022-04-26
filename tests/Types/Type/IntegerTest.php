<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\LiteralInteger;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{

    public function testConstructor() {

        $oInteger = new LiteralInteger(1);
        $this->assertInstanceOf(LiteralInteger::class, $oInteger);
    }

    public function testFromFloatString() {
        $this->expectException(InvalidArgumentException::class);
        LiteralInteger::fromString("1.2");
    }
    public function testFromIntString() {
        $oInteger = LiteralInteger::fromString("100");
        $this->assertInstanceOf(LiteralInteger::class, $oInteger);
    }
    public function testFromTextString() {
        $this->expectException(InvalidArgumentException::class);
        LiteralInteger::fromString("A1");
    }


}

