<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Primitive\PrimitiveBool;
use Hurah\Types\Type\TypeType;
use PHPUnit\Framework\TestCase;

class TypeTypeTest extends TestCase {

    public function testNonPrimitiveToString() {
        $oTypeType = new TypeType(PlainText::class);
        $this->assertInstanceOf(TypeType::class, $oTypeType);
    }
    public function testPrimitiveToString() {
        $oTypeType = new TypeType(PrimitiveBool::class);
        $this->assertEquals('bool', "{$oTypeType}", "{$oTypeType}");
    }

    public function testIsPrimitive1() {
        $oTypeType = new TypeType(PrimitiveBool::class);
        $this->assertTrue($oTypeType->isPrimitive());
    }

    public function testIsPrimitive2() {
        $oTypeType = new TypeType(PlainText::class);
        $this->assertFalse($oTypeType->isPrimitive());
    }

    public function test__construct2() {

        $oTypeType = new TypeType(new PhpNamespace(PlainText::class));
        $this->assertInstanceOf(TypeType::class, $oTypeType);
    }

    public function test__construct3() {

        $oTypeType = new TypeType(PlainText::class);
        $this->assertInstanceOf(TypeType::class, $oTypeType);

    }

    public function test__construct4() {

        $oTypeType = new TypeType(new PlainText());
        $this->assertInstanceOf(TypeType::class, $oTypeType);

    }
}
