<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Integer;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{

    public function testConstructor() {

        $oInteger = new Integer(1);
        $this->assertInstanceOf(Integer::class, $oInteger);
    }

    public function testFromFloatString() {
        $this->expectException(InvalidArgumentException::class);
        Integer::fromString("1.2");
    }
    public function testFromIntString() {
        $oInteger = Integer::fromString("100");
        $this->assertInstanceOf(Integer::class, $oInteger);
    }
    public function testFromTextString() {
        $this->expectException(InvalidArgumentException::class);
        Integer::fromString("A1");
    }


}

