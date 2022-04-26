<?php

namespace Test\Hurah\Types\Type\Helper;

use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\Helper\Loop;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PathCollection;
use PHPUnit\Framework\TestCase;
use function var_dump;

class LoopTest extends TestCase
{

    public function testLoop()
    {
        $oPathCollection = new PathCollection();
        $oPathCollection->add(Path::make('var', 'log'));
        $oPathCollection->add(Path::make('var', 'www'));
        $oPathCollection->add(Path::make('etc'));
        $oPathCollection->add(Path::make('home'));

        $oLoop = new Loop($oPathCollection);

        $this->assertTrue($oLoop->next()->isFirst());
        $this->assertFalse($oLoop->next()->isFirst());
        $this->assertFalse($oLoop->next()->isLast());
        $oLastLoop = $oLoop->next();
        $this->assertTrue($oLastLoop->isLast());
        $this->assertEquals(4, $oLastLoop->index());
        $this->assertEquals(3, $oLastLoop->index0());
        $this->assertFalse($oLastLoop->isFirst());

    }
}