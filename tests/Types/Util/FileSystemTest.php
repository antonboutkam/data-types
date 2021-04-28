<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Type\Path;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\FileSystem;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase {

    public function testMakeDir() {
        $oTempDir = DirectoryStructure::getTmpDir()->extend('tests', time() . rand(0, 99));
        $this->assertFalse($oTempDir->isDir(), "Temp directory {$oTempDir} already existsed");
        $oTempDir->makeDir();
        $this->assertTrue($oTempDir->isDir(), "Create directory {$oTempDir} failed.");
        $this->assertTrue(rmdir($oTempDir), "Could not remove just created directory {$oTempDir}.");
    }

    public function testMakePath() {

        $oPath = FileSystem::makePath('This', 'is', 'a', new Path('test'), ['to', 'see'], ['if', new Path('it'), new Path('works')]);
        $sResult = join(' ', explode(DIRECTORY_SEPARATOR, (string) $oPath));
        $this->assertTrue((string) $sResult === 'This is a test to see if it works');







    }
}
