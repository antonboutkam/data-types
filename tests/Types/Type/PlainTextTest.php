<?php


namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Regex;
use Hurah\Types\Type\RegexCollection;
use Hurah\Types\Type\Tag;
use Hurah\Types\Type\TagCollection;
use PHPUnit\Framework\TestCase;

class PlainTextTest extends TestCase
{

    public function testMatchesRegex()
    {
        $oRegex = new Regex('/^[0-9]+mg$/');
        $oPlainText = new PlainText("10mg");

        $this->assertTrue($oPlainText->matches($oRegex));

        $oTag = new Tag('wtf');
        $oPlainText = new PlainText("En toen dacht ik #wtf");
        $oPlainText->matches($oTag);
    }
    public function testMatchesTag()
    {
        $oTag = new Tag('wtf');
        $oPlainText = new PlainText("En toen dacht ik #wtf");
        $this->assertTrue($oPlainText->matches($oTag));

        $oTag = new Tag('wtf');
        $oPlainText2 = new PlainText("En toen dacht ik ohnee");
        $this->assertFalse($oPlainText2->matches($oTag));
    }

    public function testMatchesTagCollection()
    {
        $oTagCollection = TagCollection::fromTags();
        $oTag = new Tag('wtf');
        $oPlainText = new PlainText("En toen dacht ik #wtf");
        $this->assertTrue($oPlainText->matches($oTag));

        $oTag = new Tag('wtf');
        $oPlainText2 = new PlainText("En toen dacht ik ohnee");
        $this->assertFalse($oPlainText2->matches($oTag));
    }

    public function testLower()
    {
        $hello = (new PlainText("Hello"))->lowercase();
        $this->assertTrue("$hello" == 'hello');
    }

    public function testUpper()
    {
        $hello = (new PlainText("Hello"))->uppercase();
        $this->assertTrue("$hello" == 'HELLO');
    }


    public function testEquals()
    {
        $this->assertTrue((new PlainText("Hello"))->equals("Hello"));
        $this->assertTrue((new PlainText("Hello"))->equals(new PlainText("Hello")));

        $this->assertFalse((new PlainText("Hello"))->equals("hello"));
        $this->assertFalse((new PlainText("Hello"))->equals(new PlainText("hello")));
    }

    public function testEqualsIgnoreCase()
    {
        $this->assertTrue((new PlainText("Hello"))->equalsIgnoreCase("HELLO"));
        $this->assertTrue((new PlainText("HELLO"))->equalsIgnoreCase(new PlainText("hello")));

        $this->assertFalse((new PlainText("Hello"))->equalsIgnoreCase("hello!"));
        $this->assertFalse((new PlainText("Hello"))->equalsIgnoreCase(new PlainText("hello!")));
    }

    public function testMatchesNot()
    {
        $oRegex = new Regex('/^[0-9]+mg$/');
        $oPlainText = new PlainText(" x10mg ");

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

        $oRegexCollection = RegexCollection::create(
            new Regex('/mg$/'),
            new Regex('/geen/'));


        $oSubject = new PlainText("20mg is geen 10mg");
        $oReplaced = $oSubject->replace($oRegexCollection, new PlainText("kg"));

        $oExpected = new PlainText("20mg is kg 10kg");
        $this->assertEquals($oExpected, $oReplaced, (string)$oReplaced);

    }
}
