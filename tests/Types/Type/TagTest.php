<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{


    public function test__toString()
    {
        $oTag = new Tag('#bla');
        $this->assertEquals('#bla', "$oTag");

        $oTag2 = new Tag('bla2');
        $this->assertEquals('#bla2', "$oTag2");

    }
}
