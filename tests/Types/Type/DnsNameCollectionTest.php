<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\DnsName;
use Hurah\Types\Type\DnsNameCollection;
use PHPUnit\Framework\TestCase;
use Hurah\Types\Exception\InvalidArgumentException;

class DnsNameCollectionTest extends TestCase {


    /**
     * @throws InvalidArgumentException
     */
    public function testIterator() {

        $oDnsNameCollection = new DnsNameCollection();
        $oDnsNameCollection->add($expected1 = 'example.com');
        $oDnsNameCollection->add(new DnsName($expected2 = 'www.example.com'));
        $oDnsNameCollection->add($expected3 = 'example.www.com');

        $oIterator = $oDnsNameCollection->getIterator();

        $this->assertEquals(new DnsName($expected1), $oIterator->current());
        $oIterator->next();
        $this->assertEquals(new DnsName($expected2), $oIterator->current());
        $oIterator->next();
        $this->assertEquals(new DnsName($expected3), $oIterator->current());

    }

    /**
     * @throws InvalidArgumentException
     */
    public function testToArray() {

        $oDnsNameCollection = new DnsNameCollection();
        $oDnsNameCollection->add($expected1 = 'example.com');
        $oDnsNameCollection->add(new DnsName($expected2 = 'www.example.com'));
        $oDnsNameCollection->add($expected3 = 'example.www.com');

        $aDnsNames = $oDnsNameCollection->toArray();

        $this->assertEquals(new DnsName($expected1), $aDnsNames[0]);
        $this->assertEquals(new DnsName($expected2), $aDnsNames[1]);
        $this->assertEquals(new DnsName($expected3), $aDnsNames[2]);

    }


    public function testInvalidDomain() {

        $this->expectException(InvalidArgumentException::class);
        $oDnsNameCollection = new DnsNameCollection();
        $oDnsNameCollection->add($expected1 = 'example .com');

    }
}
