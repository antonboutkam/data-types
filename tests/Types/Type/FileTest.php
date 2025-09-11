<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\File;
use Hurah\Types\Type\FileExtension;
use Hurah\Types\Type\Path;
use Hurah\Types\Util\DirectoryStructure;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase {

    private function getTestPath(): Path {
        return DirectoryStructure::getTmpDir()->extend('tests', 'file-test.txt');
    }
    private function getTestImagePath(): Path {
        return DirectoryStructure::getTmpDir()->extend('tests', 'file-test.png');
    }

    protected function setUp(): void {
        $this->getTestPath()->dirname()->makeDir();
    }

	/**
	 * @throws InvalidArgumentException
	 */
	protected function tearDown(): void {
        $this->getTestPath()->unlink();
        $this->getTestPath()->dirname()->unlink();
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public function testGetContents() {
        $oTestPath = $this->getTestPath();

        $oTestPath->dirname()->makeDir();
        $oTestPath->getFile()->create();

        $this->assertTrue($oTestPath->isFile(), 'File create did not work');

        $oTestPath->write($sExpected1 = 'test1');
        $this->assertTrue("{$oTestPath->getFile()->contents()}" === "{$sExpected1}", 'Writing to file failed' . $oTestPath->getFile()->contents() . $sExpected1);

        $oTestPath->write($sExpected2 = 'test2');
        $this->assertTrue("{$oTestPath->getFile()->contents()}" === "{$sExpected2}", 'Writing to file failed');
    }
    public function testFileType()
    {
        $oTestPath = $this->getTestPath();
        $oTestFile = $oTestPath->getFile();
        static::assertInstanceOf(FileExtension::class, $oTestFile->getExtensionType());
        static::assertInstanceOf(File::class, $oTestFile->replaceExtension(FileExtension::fromString('png')));

    }

}
