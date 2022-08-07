<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\KeyValue;
use Hurah\Types\Type\Lookup;
use Hurah\Types\Type\PlainText;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase
{


    public function testCreateFromDataType()
    {
        $oLookup = Lookup::createFromDataType(new KeyValue(['key' => 1, 'value' => 'Nederland']));
        $this->assertEquals('<option value="1">Nederland</option>', (string) $oLookup);

        $oLookup = Lookup::createFromDataType(new PlainText('Nederland'));
        $this->assertEquals('<option value="Nederland">Nederland</option>', (string) $oLookup);
    }

    public function testCreateMixed()
    {
        $oLookup = Lookup::createMixed('Nederland', true, 1);
        $this->assertEquals('<option selected="selected" value="1">Nederland</option>', (string) $oLookup);
        $oLookup = Lookup::createMixed('Nederland', false, 1);
        $this->assertEquals('<option value="1">Nederland</option>', (string) $oLookup);


    }

    public function testCreate()
    {
        $oLookup = Lookup::create("Nederland", false, 5);
        $this->assertEquals('<option value="5">Nederland</option>', (string) $oLookup);

        $oLookup = Lookup::create("Nederland", true, 6);
        $this->assertEquals('<option selected="selected" value="6">Nederland</option>', (string) $oLookup);

        $oLookup = Lookup::create("Nederland", true);
        $this->assertEquals('<option selected="selected" value="Nederland">Nederland</option>', (string) $oLookup);
    }

}
