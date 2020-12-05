<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\File;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\FileSystem;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase {

    public function testGetContents() {
        $oTestFile = DirectoryStructure::getTmpDir()->extend('tests', 'file-test.txt');

        $oTestFile->getFile()->create();

        $this->assertTrue($oTestFile->isFile(), 'File create did not work');

        $oTestFile->write('test');
        $this->assertTrue($oTestFile->contents() === 'test', 'Writing to file failed');

        $oTestFile->write('test');
        $this->assertTrue($oTestFile->contents() === 'test', 'Writing to file failed');

        $this->assertTrue($oTestFile->unlink(), 'File unlink failed');

    }
}
