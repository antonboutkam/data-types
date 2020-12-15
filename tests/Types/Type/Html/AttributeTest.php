<?php

namespace Test\Hurah\Types\Type\Html;

use Hurah\Types\Type\Html\Attribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase {

    public function testCreate() {

        $oAttribute = Attribute::create('href', '/this/is-a-test');
        $this->assertInstanceOf(Attribute::class, $oAttribute);

    }

    public function test__toString() {


        $oAttribute = Attribute::create('href', '/this/is-a-test');

        $this->assertEquals("{$oAttribute}",'href="/this/is-a-test"', "{$oAttribute}");
    }
}
