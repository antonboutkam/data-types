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

    public function testRemove()
    {
        $oRegex = new Regex('/mg$/');
        $oPlainText = new PlainText("10mg");
        $oQuantity = $oPlainText->remove($oRegex);

        $this->assertEquals("10", "{$oQuantity}");
    }

    public function testReplace()
    {
        $oRegex = new Regex('/mg$/');
        $oPlainText = new PlainText("10mg");
        $oQuantity = $oPlainText->replace($oRegex, new PlainText("kg"));

        $this->assertEquals("10kg", "{$oQuantity}");
    }
}