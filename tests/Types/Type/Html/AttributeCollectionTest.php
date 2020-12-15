<?php

namespace Test\Hurah\Types\Type\Html;

use Hurah\Types\Type\Html\Attribute;
use Hurah\Types\Type\Html\AttributeCollection;
use PHPUnit\Framework\TestCase;

class AttributeCollectionTest extends TestCase {

    function testCreateCollection()
    {
        $oAttributeCollection = new AttributeCollection();
        $oAttributeCollection->addAttribute(Attribute::create('href', '/this-is/a/test'));
        $oAttributeCollection->addAttribute(Attribute::create('class', 'fa-edit fa'));
        $this->assertEquals(' href="/this-is/a/test" class="fa-edit fa"', "$oAttributeCollection");
    }

    function testAddCollectionToCollection()
    {
        $oAttributeCollectionOne = new AttributeCollection();
        $oAttributeCollectionOne->addAttribute(Attribute::create('one', '1'));
        $oAttributeCollectionOne->addAttribute(Attribute::create('two', '2'));

        $oAttributeCollectionTwo = new AttributeCollection();
        $oAttributeCollectionTwo->addCollection($oAttributeCollectionOne);
        $oAttributeCollectionTwo->addAttribute(Attribute::create('three', '3'));

        $this->assertEquals(' one="1" two="2" three="3"', "$oAttributeCollectionTwo");
    }
}
