<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PathCollection;
use PHPUnit\Framework\TestCase;
use Hurah\Types\Exception\InvalidArgumentException;

class PathCollectionTest extends TestCase {


    private function getTestPaths():array
    {
        return [
            new Path('example/www/com'),
            'examp3le/www/com',
            new Path('ex3ample/www/com'),
            'exaemple/www/com',
        ];
    }
    private function getTestCollection():PathCollection
    {
        $oPathCollection = new PathCollection();
        $aTestPaths = $this->getTestPaths();

        foreach ($aTestPaths as $mPath)
        {
            $oPathCollection->add($mPath);
        }
        return $oPathCollection;
    }
    /**
     * @throws InvalidArgumentException
     */
    public function testForeach() {

        $oPathCollection = new PathCollection();
        $oPathCollection->add('example/com');
        $oPathCollection->add(new Path('www/example/com'));
        $oPathCollection->add('example/www/com');
        $oPathCollection->add('examp3le/www/com');
        $oPathCollection->add('ex3ample/www/com');
        $oPathCollection->add('exaemple/www/com');

        $i = 0;
        foreach($oPathCollection as $path)
        {
            $i++;
            $this->assertInstanceOf(Path::class, $path);
        }
        $this->assertGreaterThan(1, $i);

    }

    public function testReverse() {
        $oCollection = $this->getTestCollection();
        $oReverseCollection = $oCollection->reverse();
        $sFirstExpected = 'exaemple/www/com';
        $this->assertEquals($oReverseCollection->current(), "{$sFirstExpected}");
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

	public function testFromFinder()
	{
		$oSymfonyFinder = Path::make(__DIR__)->getFinder();
		$oPathCollection = PathCollection::fromFinder($oSymfonyFinder);

		$this->assertGreaterThan(20, $oPathCollection->length());

		foreach($oPathCollection as $oPath)
		{
			if($oPath->hasExtension('php'))
			{
				$this->assertTrue(true);
			}
		}
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
