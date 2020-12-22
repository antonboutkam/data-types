<?php

namespace Test\Hurah\Types\Type\Html;

use Hurah\Types\Type\Html\Element;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase {

    public function testCreate() {

        $oElement = Element::create('span');
        $this->assertInstanceOf(Element::class, $oElement);
    }

    public function test__toString() {
        $oElement = Element::create('span');
        $oElement->addClass('bla');
        $this->assertEquals('<span class="bla"></span>', "{$oElement}", "{$oElement}");

    }


}
