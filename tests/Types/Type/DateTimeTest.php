<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\DateTime;
use Hurah\Types\Type\Email;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase {

    public function testConstructString() {

        $this->expectException(InvalidArgumentException::class);
        $oDateTime = new DateTime("12312");
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
