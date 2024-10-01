<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase {

    public function testIsValid() {

        $oEmail = new Email('anton@nui-blabla.com');
        $this->assertTrue($oEmail->isValid());

        $oEmail = new Email('anton@nui-blabla.com-');
        $this->assertFalse($oEmail->isValid());

        $oEmail = new Email('@nui-blabla.com-');
        $this->assertFalse($oEmail->isValid());

        $oEmail = new Email('we@nui-blabla.com-');
        $this->assertTrue($oEmail->isValid());
    }
}
