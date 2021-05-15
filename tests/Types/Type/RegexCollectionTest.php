<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Regex;
use Hurah\Types\Type\RegexCollection;
use PHPUnit\Framework\TestCase;

class RegexCollectionTest extends TestCase {

    private RegexCollection $oRegexCollection;

    protected function setUp(): void
    {
        $this->oRegexCollection = new RegexCollection();

        $this->oRegexCollection->add(new Regex('/11/'));
        $this->oRegexCollection->add(new Regex('/313/'));
        $this->oRegexCollection->add(new Regex('/^12/'));
    }

    public function testHasMatch(){

        $this->assertTrue($this->oRegexCollection->hasMatch(new PlainText('123')));
        $this->assertTrue($this->oRegexCollection->hasMatch(new PlainText('111313111')));
        $this->assertTrue($this->oRegexCollection->hasMatch(new PlainText('333311133333')));
        $this->assertFalse($this->oRegexCollection->hasMatch(new PlainText('33351315333')));
    }
    public function testReplaceAll(){

        $oResult = $this->oRegexCollection->replaceAll(new PlainText('313111232123'), new PlainText('a'));
        $this->assertTrue("$oResult" === "aa1232123", "Actual $oResult");
        $oResult = $this->oRegexCollection->replaceAll(new PlainText('123333'));
        $this->assertTrue("$oResult" === "3333");
    }
    public function testRemoveAll(){
        $oResult = $this->oRegexCollection->replaceAll(new PlainText('313111232123'));
        $this->assertTrue("$oResult" === "32123", "Actual $oResult");
        $oResult = $this->oRegexCollection->replaceAll(new PlainText('123333'));
        $this->assertTrue("$oResult" === "3333");
    }
    public function testGetAllMatches(){
        $aResult = $this->oRegexCollection->getAllMatches(new PlainText('31141131313111232123'));
        $this->assertTrue($aResult === ["11", "313"], "Actual: " . print_r($aResult, true));
        $aResult = $this->oRegexCollection->getAllMatches(new PlainText('12333313'));
        $this->assertTrue($aResult === ["313", "12"], "Actual: " . print_r($aResult, true));

    }


}

