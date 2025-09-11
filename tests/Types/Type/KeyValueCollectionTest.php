<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\KeyValueCollection;
use PHPUnit\Framework\TestCase;

class KeyValueCollectionTest extends TestCase
{
    private KeyValueCollection $oKeyValueCollection;

    protected function setUp(): void
    {
        $this->oKeyValueCollection = new KeyValueCollection();
        $this->oKeyValueCollection->addKeyValue('Content-type', 'text/html');
        $this->oKeyValueCollection->addKeyValue('color', 'Gray');
        $this->oKeyValueCollection->addKeyValue('Color', 'Black');

    }

    public function testRemoveByKey()
    {
        $this->oKeyValueCollection->removeByKey('Color');
        $this->assertEquals(2, $this->oKeyValueCollection->length());
    }

    public function testGetByKey()
    {
        $oKeyValue = $this->oKeyValueCollection->getByKey('Color');
        $this->assertEquals('Black', $oKeyValue->getValue());
    }


}