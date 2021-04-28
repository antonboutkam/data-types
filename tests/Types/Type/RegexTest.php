<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Email;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Regex;
use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase {

    public function testIsValid() {
        $oRegex = new Regex('/[a-z]+/');
        $this->assertTrue($oRegex->isValid(), "Failed asserting that valid regex is valid");
    }

    public function testIsInvalid() {

        $oRegex = new Regex('/([a-z]+/');
        $this->assertFalse($oRegex->isValid(), "Failed asserting that invalid regex is valid");
    }
    public function testFromPlainText()
    {
        $oRegex = Regex::fromPlainText(new PlainText('/[a-z]/'));
        $this->assertInstanceOf(Regex::class, $oRegex, "Failed creating regex object from PlainText");
    }
}

