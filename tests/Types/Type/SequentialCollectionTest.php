<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\SequentialCollection;
use PHPUnit\Framework\TestCase;

class SequentialCollectionTest extends TestCase
{

    private function expectedArray()
    {
        return [
            'associatieve',
            'array',
            'is',
            'Het resultaat'
        ];
    }
    private function getCollection():SequentialCollection
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray(['een' => 'associatieve', 'twee' => 'array']);
        $oSequentialCollection = $oSequentialCollection->addArray(['vier' => 'is', 'vijf' => 'Het resultaat']);
        return $oSequentialCollection;
    }
    public function testAddArray()
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray(['een' => 'associatieve', 'twee' => 'array']);
        $oSequentialCollection = $oSequentialCollection->addArray(['vier' => 'is', 'vijf' => 'Het resultaat']);
        $this->assertEquals($this->expectedArray(), $oSequentialCollection->toArray());
    }

    public function testGetUnique()
    {
        $oInitialCollection = $this->getCollection();
        $this->assertEquals($this->expectedArray(), $oInitialCollection->toArray());

        $oAddedCollection = $oInitialCollection->addArray(['een' => 'associatieve']);
        $aFirstExpected = $this->expectedArray();
        $aFirstExpected[] = 'associatieve';
        $this->assertEquals($aFirstExpected, $oAddedCollection->toArray());

        $this->assertEquals($aFirstExpected, $oAddedCollection->toArray());
        $this->assertEquals($this->expectedArray(), $oAddedCollection->getUnique()->toArray());
    }

    public function testCurrent()
    {

    }

    public function testAdd()
    {

    }
}
