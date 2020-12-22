<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\TypeType;
use PHPUnit\Framework\TestCase;

class TypeTypeTest extends TestCase {



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
