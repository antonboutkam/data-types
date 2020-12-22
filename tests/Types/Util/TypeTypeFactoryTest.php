<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\DnsName;
use Hurah\Types\Type\File;
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

    public function testTypes() {

        $aAllTypes = TypeTypeFactory::getAll();
        $bDnsTypeFound = false;
        $bFileTypeFound = false;
        foreach ($aAllTypes as $oType)
        {
            if("{$oType}" === DnsName::class)
            {
                $bDnsTypeFound = true;
            }
            if("{$oType}" === File::class)
            {
                $bFileTypeFound = true;
            }
        }
        $this->assertTrue($bDnsTypeFound, 'Dns type type is missing');
        $this->assertTrue($bFileTypeFound, 'File type is missing');
    }
}
