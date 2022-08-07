<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Util\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{

    public function testIsAssociative()
    {
        $this->assertTrue(ArrayUtils::isAssociative([
            'een' => 'x',
            'twee' => 'y',
            'drie' => 'z',
        ]));
        $this->assertFalse(ArrayUtils::isAssociative([
            0 => 'x',
            1 => 'y',
            2 => 'z',
        ]));
        $this->assertFalse(ArrayUtils::isAssociative([]));
    }

    public function testIsSequential()
    {
        $this->assertTrue(ArrayUtils::isAssociative([
            1 => 'x',
            2 => 'y',
            3 => 'z',
        ]));
    }
}
