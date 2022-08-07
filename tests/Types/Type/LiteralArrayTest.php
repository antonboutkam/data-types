<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Json;
use Hurah\Types\Type\LiteralArray;
use Hurah\Types\Type\SequentialCollection;
use PHPUnit\Framework\TestCase;

class LiteralArrayTest extends TestCase
{

    public function testCreate()
    {
        $aInput = ['een', 'b' => 'twee', 'drie'];
        $oLiteralArray = new LiteralArray(['een', 'b' => 'twee', 'drie']);
        $this->assertEquals($aInput, $oLiteralArray->toArray());
    }

    public function testToArray()
    {

        $oLiteralArray = new LiteralArray(['een', 'b' => 'twee', 'drie']);
        $this->assertIsArray($oLiteralArray->toArray());
    }

    public function testToJson()
    {
        $oLiteralArray = new LiteralArray(['een', 'b' => 'twee', 'drie']);
        $this->assertInstanceOf(Json::class, $oLiteralArray->toJson());
    }

    public function testToCollection()
    {
        $oLiteralArray = new LiteralArray(['een', 'b' => 'twee', 'drie']);
        $this->assertInstanceOf(SequentialCollection::class, $oLiteralArray->toCollection());
    }
}
