<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\PhpClassName;
use PHPUnit\Framework\TestCase;

class PhpClassNameTest extends TestCase {

    public function test1__construct() {
        $this->expectException(InvalidArgumentException::class);

        $sClassName = "123Test";

        new PhpClassName($sClassName);
    }

    public function test2__construct() {

        $sClassName = "Test";

        $this->assertInstanceOf(PhpClassName::class, new PhpClassName($sClassName));
    }

    public function test3__construct() {
        $this->expectException(InvalidArgumentException::class);

        $sClassName = "Custom\\Test";

        $this->assertInstanceOf(PhpClassName::class, new PhpClassName($sClassName));
    }
}
