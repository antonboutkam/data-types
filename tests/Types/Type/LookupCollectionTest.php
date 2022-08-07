<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\KeyValue;
use Hurah\Types\Type\KeyValueCollection;
use Hurah\Types\Type\Lookup;
use Hurah\Types\Type\LookupCollection;
use PHPUnit\Framework\TestCase;

class LookupCollectionTest extends TestCase
{

    private function getCountryLookups():LookupCollection
    {
        return LookupCollection::create([
            Lookup::create('Frankrijk', false, 1),
            Lookup::create('Zweden', false, 2),
            Lookup::create('Finland', true, 3),
        ]);
    }
    private function getCountryLookupsExtra():LookupCollection
    {
        return LookupCollection::create([
            Lookup::create('Noorwegen', false, 23)
        ]);
    }
    public function testCreate()
    {
        $oLookupCollection = LookupCollection::create([Lookup::create('xx', false, '1')]);
        $this->assertEquals('<option value="1">xx</option>', (string) $oLookupCollection);

        $oKeyValueCollection = new KeyValueCollection();
        $oKeyValueCollection->add(new KeyValue(['key' => 12, 'value' => 'Nederland']));

        $oLookupCollection = $this->getCountryLookups();
        $aExpected = $this->getCountryLookupExpected();
        $this->assertEquals(join(PHP_EOL, $aExpected), (string) $oLookupCollection);

    }


    public function testMerge()
    {
        $oLookupCollection = $this->getCountryLookups();
        $oMergedLookupCollection = $oLookupCollection->merge($this->getCountryLookupsExtra());

        $aExpected = $this->getCountryLookupExpected();
        $aExpected[] = '<option value="23">Noorwegen</option>';

        $this->assertEquals(join(PHP_EOL, $aExpected), (string) $oMergedLookupCollection);
    }

    public function testCurrent()
    {
        foreach($this->getCountryLookups() as $oLookup)
        {
            $this->assertInstanceOf(Lookup::class, $oLookup);
        }

    }


    private function getCountryLookupExpected():array
    {
        return [
            '<option value="1">Frankrijk</option>',
            '<option value="2">Zweden</option>',
            '<option selected="selected" value="3">Finland</option>'
        ];
    }
}
