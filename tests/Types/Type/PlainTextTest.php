<?php


namespace Test\Hurah\Types\Type;


use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Regex;
use PHPUnit\Framework\TestCase;

class PlainTextTest extends TestCase
{

    public function testMatches()
    {
        $oRegex = new Regex('/^[0-9]+mg$/');
        $oPlainText = new PlainText("10mg");

        $this->assertTrue($oPlainText->matches($oRegex));
    }

    public function testMatchesNot()
    {
        $oRegex = new Regex('/^[0-9]+mg$/');
        $oPlainText = new PlainText(" 10mg ");

        $this->assertFalse($oPlainText->matches($oRegex));
    }
}