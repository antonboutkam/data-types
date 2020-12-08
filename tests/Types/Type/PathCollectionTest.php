<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Path;
use Hurah\Types\Type\PathCollection;
use PHPUnit\Framework\TestCase;
use Hurah\Types\Exception\InvalidArgumentException;

class PathCollectionTest extends TestCase {


    /**
     * @throws InvalidArgumentException
     */
    public function testIterator() {

        $oPathCollection = new PathCollection();
        $oPathCollection->add($expected1 = 'example.com');
        $oPathCollection->add(new Path($expected2 = 'www.example.com'));
        $oPathCollection->add($expected3 = 'example.www.com');

        $oIterator = $oPathCollection->getIterator();

        $this->assertEquals(new Path($expected1), $oIterator->current());
        $oIterator->next();
        $this->assertEquals(new Path($expected2), $oIterator->current());
        $oIterator->next();
        $this->assertEquals(new Path($expected3), $oIterator->current());

    }

    /**
     * @throws InvalidArgumentException
     */
    public function testToArray() {

        $oPathCollection = new PathCollection();
        $oPathCollection->add($expected1 = 'example.com');
        $oPathCollection->add(new Path($expected2 = 'www.example.com'));
        $oPathCollection->add($expected3 = 'example.www.com');

        $aPaths = $oPathCollection->toArray();

        $this->assertEquals(new Path($expected1), $aPaths[0]);
        $this->assertEquals(new Path($expected2), $aPaths[1]);
        $this->assertEquals(new Path($expected3), $aPaths[2]);

    }

}
