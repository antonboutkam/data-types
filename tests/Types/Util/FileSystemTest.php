<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Type\Path;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\FileSystem;
use PHPUnit\Framework\TestCase;
use function dirname;
use function getcwd;
use function var_dump;

class FileSystemTest extends TestCase {

    public function testMakeDir() {
        $oTempDir = DirectoryStructure::getTmpDir()->extend('tests', time() . rand(0, 99));
        $this->assertFalse($oTempDir->isDir(), "Temp directory {$oTempDir} already existsed");
        $oTempDir->makeDir();
        $this->assertTrue($oTempDir->isDir(), "Create directory {$oTempDir} failed.");
        $this->assertTrue(rmdir($oTempDir), "Could not remove just created directory {$oTempDir}.");
    }
    public function testTreeIsWritable()
    {
        $sDataDir = dirname(__DIR__, 3);

        $this->assertFalse(FileSystem::treeIsWritable('/'));
        $this->assertFalse(FileSystem::treeIsWritable('/test.xml'));
        $this->assertFalse(FileSystem::treeIsWritable('/bla/test.xml'));


        $this->assertTrue(FileSystem::treeIsWritable($sDataDir));
        $this->assertTrue(FileSystem::treeIsWritable($sDataDir . '/test.xml'));
        $this->assertTrue(FileSystem::treeIsWritable($sDataDir . '/data/test.xml'));

    }

    public function testMakePath() {
        $oPath = FileSystem::makePath('This', 'is', 'a', new Path('test'), ['to', 'see'], ['if', new Path('it'), new Path('works')]);
        $sResult = join(' ', explode(DIRECTORY_SEPARATOR, (string) $oPath));
        $this->assertTrue((string) $sResult === 'This is a test to see if it works');
    }
}
