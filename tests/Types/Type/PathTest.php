<?php

namespace Test\Hurah\Types\Type;

use DirectoryIterator;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\Path;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\FileSystem;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use function var_dump;

class PathTest extends TestCase {

    private Path $oTestFile;
    private string $sTestFileBaseName = 'path-write-test.txt';

    private function getTestFile(): Path {
        return DirectoryStructure::getTmpDir()->extend('tests', $this->sTestFileBaseName);
    }
    protected function setUp(): void {
        $this->oTestFile = $this->getTestFile();
        $this->oTestFile->dirname()->makeDir();
        $this->oTestFile->write('x');
    }

    /**
     * @throws NullPointerException
     */
    public function tearDown(): void {
        $this->oTestFile = $this->getTestFile();
        if($this->oTestFile->isFile())
        {
            $this->oTestFile->unlink();
        }
        $this->oTestFile->dirname()->unlink();
    }
    public function testUnlinkRecursive()
    {
        $oSomePath = Path::make(__DIR__)->dirname(2)->extend('data');
        $oSomePath->makeDir();
        for($x = 0; $x < 10; $x++)
        {
            $oTestDirectoryX = $oSomePath->extend("test-directory-{$x}")->makeDir();
            $this->assertTrue($oSomePath->extend("test-directory-$x")->isDir());
            for($y = 0; $y < 10; $y++)
            {
                $oTestDirectoryX->extend("test-file-{$y}")->write("test-$y");
                $this->assertTrue($oSomePath->extend("test-directory-$x", "test-file-$y")->exists());
                $this->assertTrue($oSomePath->extend("test-directory-$x", "test-file-$y")->isFile());

            }
        }

        $oTestDir1 = $oSomePath->extend("test-directory-1");
        $oTestDir1->unlinkRecursive();
        $this->assertFalse($oTestDir1->isDir());
        $this->assertFalse($oTestDir1->exists());

        $oTestRoot = $oTestDir1->dirname();
        $this->assertTrue($oTestRoot->exists());
        $oTestRoot->unlinkRecursive();
        $this->assertFalse($oTestRoot->exists());

    }

    public function testTreeUp() {
        $oTestPath = Path::make('home', 'anton', 'Documents');
        $oPathCollection = $oTestPath->treeUp();

        $this->assertEquals($oPathCollection->current(), Path::make('home', 'anton', 'Documents'), "{$oPathCollection}");
        $oPathCollection->next();
        $this->assertEquals($oPathCollection->current(), Path::make('home', 'anton'), "{$oPathCollection}");
        $oPathCollection->next();
        $this->assertEquals($oPathCollection->current(), Path::make('home'), "{$oPathCollection}");

    }
    public function testWrite() {
        $oTestFile = DirectoryStructure::getTmpDir()->extend('tests', $this->sTestFileBaseName);
        $oTestFile->write($sExpected = 'this is a test');
        $this->assertTrue(trim(file_get_contents($oTestFile->getValue())) == $sExpected);
    }

    public function testAppend() {
        $this->oTestFile->append('xxx');
        $this->assertTrue(preg_match('/xxx$/', (string)$this->oTestFile) === 1, __METHOD__ . ':' . __LINE__ . ' ' . (string)$this->oTestFile);
    }

    public function testContents() {

        file_put_contents((string)$this->oTestFile, $sExpected = 'this is expected');
        $this->assertTrue("{$this->oTestFile->contents()}" === "{$sExpected}");
    }

    public function testExists() {

        if($this->oTestFile->exists())
        {
            $this->oTestFile->unlink();
        }
        $this->assertFalse($this->oTestFile->exists());
        $this->oTestFile->write('x');
        $this->assertTrue($this->oTestFile->exists());
    }

    public function testExtend() {
        $oPath1 = FileSystem::makePath('this', 'is', 'a');
        $oPath3 = $oPath1->extend('test');
        $oPath2 = FileSystem::makePath('this', 'is', 'a', 'test');
        $this->assertTrue((string)$oPath2 === (string)$oPath3, "(string){$oPath2} === (string) {$oPath3}");
    }

    public function testDirname() {
        $oPath1 = FileSystem::makePath('this', 'is', 'a', 'test');

        $oPath2 = FileSystem::makePath('this', 'is', 'a');
        $oPath3 = $oPath1->dirname();

        $this->assertTrue("{$oPath2}" === "{$oPath3}", "$oPath2 === $oPath3");
    }

    public function testIsFile() {
        if($this->oTestFile->exists())
        {
            $this->oTestFile->unlink();
        }
        $this->assertFalse($this->oTestFile->isFile());
        $this->oTestFile->write('x');
        $this->assertTrue($this->oTestFile->isFile());
    }

    public function testMakeDir() {
        $oPath = FileSystem::makePath($this->oTestFile->dirname()->extend('test-dir1'));
        $this->assertFalse($oPath->isDir());
        $oPath->makeDir();
        $this->assertTrue($oPath->isDir());
        $oPath->unlink();
        $this->assertFalse($oPath->isDir());
    }

    public function testGetFile() {
        $sResult = $this->oTestFile->write($sExpected = '1232142312')->contents();
        $this->assertTrue("$sResult" === "$sExpected", "$sResult" . ' === ' . "$sExpected");
    }

    public function testGetDirectoryIterator() {
        $oDirectoryIterator = ($oCreatedDir = $this->oTestFile->dirname()->extend('x')->makeDir())->getDirectoryIterator();
        $this->assertInstanceOf(DirectoryIterator::class, $oDirectoryIterator);
        $oCreatedDir->unlink();

        $this->expectException(UnexpectedValueException::class);
        $oCreatedDir->getDirectoryIterator();
    }
    public function testIsDir() {
        $oPath = FileSystem::makePath($this->oTestFile->dirname()->extend('test-dir2'));
        $this->assertFalse($oPath->isDir());
        $oPath->makeDir();
        $this->assertTrue($oPath->isDir());
        $oPath->unlink();
        $this->assertFalse($oPath->isDir());

    }

    public function testUnlink() {
        $this->oTestFile->write('xyz');
        $this->assertTrue($this->oTestFile->isFile());
        $this->oTestFile->unlink();
        $this->assertFalse($this->oTestFile->isFile());
    }
    public function testBasename() {
        $this->assertTrue($this->oTestFile->basename() == $this->sTestFileBaseName, "{$this->oTestFile->basename()} == {$this->sTestFileBaseName}");
    }
    public function testMove() {
        $this->oTestFile->write($sExpected = 'needs-moving');
        $oDestination = DirectoryStructure::getTmpDir()->extend('tests', 'new-location.txt');
        $this->oTestFile->move($oDestination);

        $this->assertTrue((string) $oDestination->contents() === (string) $sExpected, (string) $oDestination->contents() .' == ' . (string) $sExpected . print_r($oDestination->contents(), true) . ' x ' . print_r($sExpected, true));
        $this->assertTrue("$this->oTestFile" ===  "$oDestination");

        $oNewTestFile = $this->getTestFile();
        $this->assertFalse($oNewTestFile->exists());

        $oDestination->unlink();
    }
}
