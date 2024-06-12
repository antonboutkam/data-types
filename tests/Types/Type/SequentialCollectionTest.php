<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\LiteralArray;
use Hurah\Types\Type\SequentialCollection;
use PHPUnit\Framework\TestCase;

class SequentialCollectionTest extends TestCase
{

    private function expectedArray(): array
    {
        return [
            'associatieve',
            'array',
            'is',
            'Het resultaat',
        ];
    }
	private function getArrayOne():array
	{
		return ['een' => 'associatieve', 'twee' => 'array'];
	}
	private function getArrayTwo():array
	{
		return ['vier' => 'is', 'vijf' => 'Het resultaat'];
	}
    private function getCollection():SequentialCollection
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray($this->getArrayOne());
		return $oSequentialCollection->addArray($this->getArrayTwo());
    }
    public function testAddArray()
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray($this->getArrayOne());
        $oSequentialCollection = $oSequentialCollection->addArray($this->getArrayTwo());
        $this->assertEquals($this->expectedArray(), $oSequentialCollection->toArray());

		$oSequentialCollection = new SequentialCollection();
		$oSequentialCollection = $oSequentialCollection->addArray($this->expectedArray());

		$this->assertEquals($this->expectedArray(), $oSequentialCollection->toArray());
    }

    public function testGetUnique()
    {
        $oInitialCollection = $this->getCollection();

        $this->assertEquals($this->expectedArray(), $oInitialCollection->toArray());

        $oAddedCollection = $oInitialCollection->addArray(['een' => 'associatieve']);


        // $aFirstExpected = $this->expectedArray();
        // $aFirstExpected[] = 'associatieve';
        // $this->assertEquals($aFirstExpected, $oAddedCollection->toArray());


        // $this->assertEquals($this->expectedArray(), $oAddedCollection->getUnique()->toArray());
    }

    public function testCurrent()
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray(['een' => 'associatieve', 'twee' => 'array', 'drie' => ['xx', 'yy']]);

        $this->assertEquals('associatieve', $oSequentialCollection->current());
        $this->assertEquals('associatieve', $oSequentialCollection->current());
        $oSequentialCollection->next();
        $this->assertEquals('array', $oSequentialCollection->current());
        $oSequentialCollection->next();
        $this->assertEquals(new LiteralArray(['xx', 'yy']), $oSequentialCollection->current());
    }

    public function testAdd()
    {
        $oSequentialCollection = new SequentialCollection();
        $oSequentialCollection = $oSequentialCollection->addArray(['een' => 'associatieve', 'twee' => 'array']);
        $oSequentialCollection2 = clone $oSequentialCollection;
        $oSequentialCollection2->addAny(['drie' => ['wat', 'anders']]);
        $this->assertNotEquals($oSequentialCollection, $oSequentialCollection2, 'Zouden af moeten wijken');

        $expected = [
            0 => 'associatieve',
            1 => 'array',
            2 => [
                    'drie' => [

                            0 => 'wat',
                            1 => 'anders',
                    ],
                ],
        ];
        $this->assertEquals($oSequentialCollection2->toArray(), $expected);

    }
}
