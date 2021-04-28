<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\DnsName;
use PHPUnit\Framework\TestCase;

class DnsNameTest extends TestCase {

    public function testCreateSubdomain() {

        $oDnsName = new DnsName('example.com');
        $oSubDomain = $oDnsName->createSubdomain('test');

        $this->assertTrue($oSubDomain->getValue() == 'test.example.com');
    }
}
