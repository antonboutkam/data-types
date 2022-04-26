<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\ControlForeach;
use Hurah\Types\Type\Helper\Loop;
use Hurah\Types\Type\LiteralCallable;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PathCollection;
use PHPUnit\Framework\TestCase;
use Test\Hurah\Types\Type\Helper\LoopTest;
use function print_r;

class ControlForeachTest extends TestCase
{

    static array $aItems = [];
    function setUp(): void
    {
        self::$aItems = [];
    }

    public function testLoop()
    {
        $oPathCollection = new PathCollection();
        $oPathCollection->add(Path::make('var', 'log'));
        $oPathCollection->add(Path::make('home'));
        $oPathCollection->add(Path::make('etc'));

        $oControlForeach = new ControlForeach($oPathCollection);


        $oControlForeach->loop(LiteralCallable::create(function (Path $oPath, Loop $loop) {
            self::$aItems[] = ['path' => $oPath, 'loop' => clone $loop];
        }));

        $this->assertInstanceOf(Path::class, self::$aItems[0]['path']);
        $this->assertTrue(self::$aItems[0]['loop']->isFirst());

        $this->assertInstanceOf(Path::class, self::$aItems[2]['path']);
        $this->assertTrue(self::$aItems[2]['loop']->isLast());

    }

    /*
    public function testFromCollection()
    {

    }

    public function test__toString()
    {

    }

    public function testFromArray()
    {

    }

    public function testLoop()
    {

    }

    public function testGetValue()
    {

    }

    public function test__construct()
    {

    }

    public function testSetValue()
    {

    }
    */
}
