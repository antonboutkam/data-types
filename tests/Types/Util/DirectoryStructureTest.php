<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Util\DirectoryStructure;
use PHPUnit\Framework\TestCase;

class DirectoryStructureTest extends TestCase {

    public function testGetSysRoot() {

        $oSysRoot = DirectoryStructure::getSysRoot();

        $this->assertTrue($oSysRoot->extend('src')->exists(), 'Root directory seems off / unexpected');
        $this->assertTrue($oSysRoot->isDir(), 'System dir appears to be missing.');

    }

    public function testGetVendorDir() {

        $oVendorRoot = DirectoryStructure::getVendorDir();

        $this->assertTrue($oVendorRoot->isDir(), 'Vendor dir not found');
        $this->assertTrue((string) $oVendorRoot->basename() == 'vendor', "Vendor root dir incorrect {$oVendorRoot}");
        $this->assertTrue($oVendorRoot->extend('autoload.php')->exists(), 'autoload.php missing');
    }
}
