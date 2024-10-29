<?php

namespace Test\Hurah\Types\Type\Html\Form;

use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\Form\Checkbox;
use Hurah\Types\Type\Html\Form\Dropdown;
use Hurah\Types\Type\Lookup;
use Hurah\Types\Type\LookupCollection;
use PHPUnit\Framework\TestCase;

class CheckboxTest extends TestCase
{

    public function testMakeCheckbox1()
    {
        $oCheckbox = new Checkbox();
		$oCheckbox->setName('halloween');
		$oCheckbox->setValue(2);
		$oCheckbox->setReadOnly(true);
		$oCheckbox->setChecked();

		$sExpected = '<input name="halloween" type="checkbox" value="2" readonly="readonly" checked="checked" />';
		$this->assertEquals($sExpected, (string) $oCheckbox);


        // $this->assertEquals($this->toStringExpected(), (string) $oDropDown, (string) $oDropDown);
    }

	public function testMakeCheckbox2()
	{
		$oCheckbox = new Checkbox();
		$oCheckbox->setName('data', 'halloween');
		$oCheckbox->setValue(22);

		$sExpected = '<input name="data[halloween]" type="checkbox" value="22" />';
		$this->assertEquals($sExpected, (string) $oCheckbox);


		// $this->assertEquals($this->toStringExpected(), (string) $oDropDown, (string) $oDropDown);
	}


	public function testMakeCheckedArray()
	{
		$aChecked =  Checkbox::makeCheckedArray([1,2,7]);
		$this->assertEquals(' checked="checked"', $aChecked[1]);
		$this->assertNull($aChecked[3] ?? null);
	}
}
