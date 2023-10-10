<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\KeyValue;
use Hurah\Types\Type\KeyValueCollection;
use Hurah\Types\Type\Lookup;
use Hurah\Types\Type\LookupCollection;
use PHPUnit\Framework\TestCase;

class LookupCollectionTest extends TestCase
{

    private function getCountryLookups(): LookupCollection
    {
        return LookupCollection::create([
            Lookup::create('Frankrijk', false, 1),
            Lookup::create('Zweden', false, 2),
            Lookup::create('Finland', true, 3),
        ]);
    }

    private function getCountryLookupsExtra(): LookupCollection
    {
        return LookupCollection::create([
            Lookup::create('Noorwegen', false, 23)
        ]);
    }

    public function testCreate()
    {
        $oLookupCollection = LookupCollection::create([Lookup::create('xx', false, '1')]);
        $this->assertEquals('<option value="1">xx</option>', (string)$oLookupCollection);

        $oKeyValueCollection = new KeyValueCollection();
        $oKeyValueCollection->add(new KeyValue(['key' => 12, 'value' => 'Nederland']));

        $oLookupCollection = $this->getCountryLookups();
        $aExpected = $this->getCountryLookupExpected();
        $this->assertEquals(join(PHP_EOL, $aExpected), (string)$oLookupCollection);

    }


    public function testCreate2()
    {
        $colors = [
            ['primary', 'Neutraal'],
            ['secondary', 'Onopvallend'],
            ['success', 'Positief'],
            ['danger', 'Gevaarlijk'],
            ['warning', 'Opvallend'],
            ['info', 'Info'] ,
        ];
        $lookupCollection = LookupCollection::create($colors);
        $lookups = (string) $lookupCollection;
        $this->assertEquals($this->getCreate2ExpectedResult(), $lookups);
    }

    private function getCreate2ExpectedResult():string{
        return <<<OUT
<option value="primary">Neutraal</option>
<option value="secondary">Onopvallend</option>
<option value="success">Positief</option>
<option value="danger">Gevaarlijk</option>
<option value="warning">Opvallend</option>
<option value="info">Info</option>
OUT;

    }

    public function testAsLookupArray()
    {
        $aArray = $this->getCountryLookups()->asLookupArray();
        $this->assertEquals('Frankrijk', $aArray[0]['label']);
        $this->assertEquals(1, $aArray[0]['id']);

        $aArray = $this->getCountryLookups()->asLookupArray('x','y');
        $this->assertEquals('Frankrijk', $aArray[0]['y']);
        $this->assertEquals(1, $aArray[0]['x']);
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
