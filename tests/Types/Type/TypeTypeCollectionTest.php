<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\IGenericDataType;
use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Tag;
use Hurah\Types\Type\TagCollection;
use Hurah\Types\Type\TypeType;
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
     * @throws RuntimeException
     * @depends test__construct
     */
    public function testCurrent() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addObject(new PlainText());
        $this->assertInstanceOf(TypeType::class, $oTypeTypeCollection->current(), get_class($oTypeTypeCollection->current()));
    }

	public function testFromPlainText() {
		$oPlainText = new PlainText('Lieve #vera dit was met #boaz');
		$oTagCollection = TagCollection::fromPlainText($oPlainText);
		$this->assertInstanceOf(TagCollection::class, $oTagCollection);
		$this->assertEquals([new Tag('vera'), new Tag('boaz')], $oTagCollection->toArray());
	}

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testAddObject() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addObject(new PlainText());
        $this->assertInstanceOf(TypeType::class, $oTypeTypeCollection->current());
    }

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function testAddString() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addString(PlainText::class);
        $this->assertInstanceOf(TypeType::class, $oTypeTypeCollection->current());
    }

    /**
     * @depends test__construct
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function testAddString2() {
        $this->expectException(ReflectionException::class);
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->addString(new PlainText());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @depends testAddString
     * @depends testAddObject
     */
    public function testAdd() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $sFqn = $oTypeTypeCollection->current()->toPhpNamespace();
        $this->assertTrue($sFqn->implementsInterface(IGenericDataType::class));
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @depends testAddString
     * @depends testAddObject
     */
    public function testAdd2() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(PlainText::class);
        $oTypeTypeCollection->add($oTypeTypeCollection);
        $this->assertInstanceOf(TypeType::class, $oTypeTypeCollection->current());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
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
     * @throws RuntimeException
     */
    public function testToArray() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $aExpected = ["Hurah\\Types\\Type\\PlainText","Hurah\\Types\\Type\\PlainText"];

        $this->assertEquals($aExpected, $oTypeTypeCollection->toArray(), json_encode($oTypeTypeCollection->toArray()));
    }

    /**
     * @depends testAddString
     * @depends testAddObject
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function test__toString() {
        $oTypeTypeCollection = new TypeTypeCollection();
        $oTypeTypeCollection->add(new PlainText());
        $oTypeTypeCollection->add(PlainText::class);
        $aExpected = ["Hurah\\Types\\Type\\PlainText","Hurah\\Types\\Type\\PlainText"];
        $this->assertEquals($aExpected, $oTypeTypeCollection->toArray(), json_encode($oTypeTypeCollection->toArray()));
    }
}
