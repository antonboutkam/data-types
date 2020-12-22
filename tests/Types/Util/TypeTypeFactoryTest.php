<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\TypeTypeCollection;
use Hurah\Types\Util\TypeTypeFactory;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class TypeTypeFactoryTest extends TestCase {

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testGetAll() {

        $this->assertGreaterThan(50, TypeTypeFactory::getAll()->count());
    }

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testGetAll2() {
        $this->assertInstanceOf(TypeTypeCollection::class, TypeTypeFactory::getAll());
    }
}
