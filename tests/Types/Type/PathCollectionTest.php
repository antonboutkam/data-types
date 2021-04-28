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
    public function testForeach() {

        $oPathCollection = new PathCollection();
        $oPathCollection->add($expected1 = 'example.com');
        $oPathCollection->add(new Path($expected2 = 'www.example.com'));
        $oPathCollection->add('example.www.com');
        $oPathCollection->add('examp3le.www.com');
        $oPathCollection->add('ex3ample.www.com');
        $oPathCollection->add('exaemple.www.com');

        $i = 0;
        foreach($oPathCollection as $path)
        {
            $i++;
            $this->assertInstanceOf(Path::class, $path);
        }
        $this->assertGreaterThan(1, $i);

    }




    /**
     * @throws InvalidArgumentException
     */
    public function testIterator() {

        $oPathCollection = new PathCollection();
        $oPathCollection->add($expected1 = 'example.com');
        $oPathCollection->add(new Path($expected2 = 'www.example.com'));
        $oPathCollection->add($expected3 = 'example.www.com');



        $this->assertEquals(new Path($expected1), $oPathCollection->current());
        $oPathCollection->next();
        $this->assertEquals(new Path($expected2), $oPathCollection->current());
        $oPathCollection->next();
        $this->assertEquals(new Path($expected3), $oPathCollection->current());

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
