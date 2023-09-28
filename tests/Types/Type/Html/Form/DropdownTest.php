<?php

namespace Test\Hurah\Types\Type\Html\Form;

use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\Form\Dropdown;
use Hurah\Types\Type\Lookup;
use Hurah\Types\Type\LookupCollection;
use PHPUnit\Framework\TestCase;

class DropdownTest extends TestCase
{

    public function test__toString()
    {
        $oDropDown = new Dropdown();
        $oDropDown->setName('test');
        $oDropDown->setValue(2);
        $oDropDown->setLookups($this->getLookups());

        $this->assertEquals($this->toStringExpected(), (string) $oDropDown, (string) $oDropDown);
    }
    private function toStringExpected():string
    {
        $expected = <<<END
<select name="test">
<option selected="selected" value="1">Nederland</option>
<option value="2">Duitsland</option>
</select>
END;
        return $expected;
    }

    private function getExpectedLookups():array
    {
        $aOut = [];
        $aOut[] = '<option selected="selected" value="1">Nederland</option>';
        $aOut[] = '<option value="2">Duitsland</option>';
        return $aOut;
    }
    private function getExpectedDropdown(bool $bReadOnly = false, string $sName = ''):array
    {
        $aOut = [];
        $sReadOnly ='';
        if($bReadOnly)
        {
            $sReadOnly = 'readonly="readonly" ';
        }
        $aOut[] = '<select ' . $sReadOnly . 'name="' . $sName . '">';
        foreach($this->getExpectedLookups() as $lookup)
        {
            $aOut[] = $lookup;
        }
        $aOut[] = '</select>';
        return $aOut;
    }

    private function getLookups():LookupCollection
    {
        $oLookups = new LookupCollection();
        $oLookups->add(Lookup::create('Nederland', true, 1));
        $oLookups->add(Lookup::create('Duitsland', false, 2));

        return $oLookups;
    }

    public function testSetLookups()
    {
        $oLookups = $this->getLookups();

        $oDropdown = new Dropdown();
        $oDropdown->setLookups($oLookups);
        $this->assertEquals(join(PHP_EOL, $this->getExpectedDropdown()), (string) $oDropdown);
    }

    public function testSetReadOnly()
    {
        $oLookups = $this->getLookups();
        $oDropdown = new Dropdown();
        $oDropdown->setLookups($oLookups);
        $oDropdown->setReadOnly();
        $this->assertEquals(join(PHP_EOL, $this->getExpectedDropdown(true)), (string) $oDropdown);
    }

    public function testCreate()
    {
        $oDropdown = Dropdown::create(['data', 'last_name'], $this->getLookups());

        $this->assertInstanceOf(Dropdown::class, $oDropdown);
    }

    public function testToElement()
    {
        $oLookups = $this->getLookups();
        $oDropdown = new Dropdown();
        $oDropdown->setLookups($oLookups);
        $oDropdown->setReadOnly();
        $this->assertInstanceOf(Element::class, $oDropdown->toElement());
    }

    public function testToString()
    {
        $oLookups = $this->getLookups();
        $oDropdown = new Dropdown();
        $oDropdown->setLookups($oLookups);
        $oDropdown->setReadOnly();
        $oDropdown->setName('data', 'only', 'crap');
        $this->assertEquals(join(PHP_EOL, $this->getExpectedDropdown(true, 'data[only][crap]')), (string) $oDropdown);

    }
    public function testSetName()
    {
        $oLookups = $this->getLookups();
        $oDropdown = new Dropdown();
        $oDropdown->setName('data', 'first_name');

        $this->assertEquals('data[first_name]', $oDropdown->getName());
    }

}
