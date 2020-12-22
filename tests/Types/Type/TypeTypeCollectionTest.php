<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\TypeTypeCollection;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class TypeTypeCollectionTest extends TestCase {

    public function test__construct() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $this->assertInstanceOf(TypeTypeCollection::class, $oTypeTypeCollection);
    }

    /**
     * @throws InvalidArgumentException
     * @depends test__construct
     */
    public function testCurrent() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addObject(new PlainText());
        $this->assertInstanceOf(PhpNamespace::class, $oTypeTypeCollection->current());
    }

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     */
    public function testAddObject() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addObject(new PlainText());
        $this->assertInstanceOf(PhpNamespace::class, $oTypeTypeCollection->current());
    }

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testAddString() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addString(PlainText::class);
        $this->assertInstanceOf(PhpNamespace::class, $oTypeTypeCollection->current());
    }

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testAddString2() {
        $this->expectException(InvalidArgumentException::class);
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addString(new PlainText());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @depends testAddString
     * @depends testAddObject
     */
    public function testAdd() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $this->assertInstanceOf(PhpNamespace::class, $oTypeTypeCollection->current());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @depends testAddString
     * @depends testAddObject
     */
    public function testAdd2() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(self::class);
        $oTypeTypeCollection->add(PlainText::class);
        $this->assertInstanceOf(PhpNamespace::class, $oTypeTypeCollection->current());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @depends testAddString
     * @depends testAddObject
     */
    public function testCount() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $this->assertEquals(2, $oTypeTypeCollection->count());
    }

    /**
     * @depends testAddString
     * @depends testAddObject
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testToArray() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $aExpected = [

        ];
        $this->assertEquals($aExpected, $oTypeTypeCollection->toArray(), json_encode($oTypeTypeCollection->toArray()));
    }

    /**
     * @depends testAddString
     * @depends testAddObject
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function test__toString() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $aExpected = [

        ];
        $this->assertEquals($aExpected, $oTypeTypeCollection->toArray(), json_encode($oTypeTypeCollection->toArray()));
    }
}
