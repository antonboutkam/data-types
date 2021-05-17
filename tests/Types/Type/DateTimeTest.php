<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase {

    public function testConstructString() {

        $this->expectException(InvalidArgumentException::class);
        new DateTime("12312");
    }
    public function testConstructDateTime()
    {
        $oDateTime = new DateTime(new \DateTime());
        $this->assertInstanceOf(DateTime::class, $oDateTime);
    }
    public function testConstructInt()
    {
        $oDateTime = new DateTime(time());
        $this->assertInstanceOf(DateTime::class, $oDateTime);
    }
}
