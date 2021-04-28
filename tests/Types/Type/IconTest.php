<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase {

    public function testToElement() {

        $oIcon = new Icon('edit');
        $this->assertEquals('<span class="fa fa-edit"></span>', "{$oIcon->toElement()}");
    }
}
