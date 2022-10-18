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
    private function getTestSplatArray():array
    {
        return [
            [
                'categories' => [
                    1, 2, 6, 8
                ],
                'name' => 'Nuts'
            ],
            [
                'categories' => [
                    1, 5, 16
                ],
                'name' => 'Bolts'
            ],
            [
                'categories' => [
                    1, 5, 16
                ],
                'name' => 'Screws'
            ]
        ];
    }
    public function testSplat()
    {

        $aTestSplatArray = $this->getTestSplatArray();

        $oLiteralArray = new LiteralArray($aTestSplatArray);
        $oCategoryArray = $oLiteralArray->splat('categories');

        $this->assertEquals([1, 2, 5, 6, 8, 16], $oCategoryArray->toArray());

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
