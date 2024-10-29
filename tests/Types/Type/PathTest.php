<?php

namespace Test\Hurah\Types\Type;

use DirectoryIterator;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\LiteralCallable;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\Regex;
use Hurah\Types\Type\RegexCollection;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\FileSystem;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use function json_encode;
use function var_dump;
use const PHP_EOL;

class PathTest extends TestCase
{

    private Path $oTestFile;
    private string $sTestFileBaseName = 'path-write-test.txt';

    /**
     * @throws NullPointerException
     */
    public function tearDown(): void
    {
        $this->oTestFile = $this->getTestFile();
        if ($this->oTestFile->isFile())
        {
            $this->oTestFile->unlink();
        }
        $this->oTestFile->dirname()->unlink();
    }

    public function testExplode()
    {
        $aExpectedInBothCases = [
            'this',
            'is',
            'a',
            'test'
        ];
        $oPath1 = Path::make('\\this\\is\\a\\test');
        $this->assertEquals($aExpectedInBothCases, $oPath1->explode());

        $oPath2 = Path::make(DIRECTORY_SEPARATOR . 'this' . DIRECTORY_SEPARATOR . 'is' . DIRECTORY_SEPARATOR . 'a' . DIRECTORY_SEPARATOR . 'test');
        $this->assertEquals($aExpectedInBothCases, $oPath2->explode());
    }

    public function testUnlinkRecursive()
    {
        $oSomePath = Path::make(__DIR__)->dirname(2)->extend('data');
        $oSomePath->makeDir();
        for ($x = 0; $x < 10; $x++)
        {
            $oTestDirectoryX = $oSomePath->extend("test-directory-{$x}")->makeDir();
            $this->assertTrue($oSomePath->extend("test-directory-$x")->isDir());
            for ($y = 0; $y < 10; $y++)
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

    public function testIsEmpty()
    {
        $oTestPath = Path::make('');
        $this->assertTrue($oTestPath->isEmpty());

        $oTestPath = Path::make(null);
        $this->assertTrue($oTestPath->isEmpty());

        $oTestPath = Path::make(null, null);
        $this->assertTrue($oTestPath->isEmpty());

        $oTestPath = Path::make();
        $this->assertTrue($oTestPath->isEmpty());

        $oTestPath = Path::make('root');
        $this->assertFalse($oTestPath->isEmpty());

        $oTestPath = Path::make('.');
        $this->assertFalse($oTestPath->isEmpty());

    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testSlice()
    {
        $oSomePath = Path::make('home', 'anton', 'Documents', 'sites', 'hurah', 'whatever', 'bla', 'template.twig');
        $this->assertEquals(Path::make('hurah', 'whatever'), $oSomePath->slice(4, 2));
        $this->assertEquals(Path::make('template.twig'), $oSomePath->slice(-1, 2));
        $this->assertEquals(Path::make('template.twig'), $oSomePath->slice(-1));
        $this->assertEquals(Path::make('bla/template.twig'), $oSomePath->slice(-2));
        $oExpected = Path::make('anton', 'Documents', 'sites', 'hurah', 'whatever', 'bla', 'template.twig');
        $this->assertEquals($oExpected, $oSomePath->slice(1));
        $this->assertEquals(Path::make('home'), $oSomePath->slice(0, 1));

        $oSomePath = Path::make('Login/login.twig');
        $oSomeDir = $oSomePath->slice(0, 1);
        $this->assertEquals(Path::make('Login'), $oSomeDir);

    }

    public function testReplace()
    {
        $oBasePath1 = Path::make('/this/is/a/path');
        $oBasePath2 = Path::make('/some/other/root');
        $oSomeSubPath1 = Path::make('with/one/components/added');
        $oSomeSubPath2 = Path::make('with/two/components/added');

        $oFullPath1 = $oBasePath1->extend($oSomeSubPath1);
        $oFullPath2 = $oBasePath1->extend($oSomeSubPath2);
        $oFullPath3 = $oFullPath1->replace($oSomeSubPath1, $oSomeSubPath2);
        $oFullPath4 = $oFullPath1->replace($oBasePath1, $oBasePath2);
        $oFullPath5 = $oBasePath2->extend($oSomeSubPath1);

        $this->assertEquals($oFullPath2, $oFullPath3);
        $this->assertEquals($oFullPath5, $oFullPath4);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testRemove()
    {
        $oExpected = Path::make('/this/is/a/path');
        $oSomeSubPath = Path::make('with/components/added');

        $oExpectedExtended = $oExpected->extend($oSomeSubPath);
        $this->assertEquals(Path::make('/this', 'is', 'a', 'path', 'with', 'components', 'added'), $oExpectedExtended);

        $oBackToExpected = $oExpectedExtended->remove(new PlainText("/{$oSomeSubPath}"));


        $oRegexResult = $oExpectedExtended->remove(new Regex("/(\/this\/|is|\/a\/)/"));
        $this->assertEquals(Path::make('path/with/components/added'), $oRegexResult);

        $oRegexCollection = new RegexCollection();
        $oRegexCollection->add(new Regex('/\/this/'));
        $oRegexCollection->add(new Regex('/\/added/'));
        $oRegexCollectionResult = $oExpectedExtended->remove($oRegexCollection);
        $this->assertEquals(Path::make('/is/a/path/with/components'), $oRegexCollectionResult, $oRegexCollectionResult);



        $this->assertEquals($oExpected, $oBackToExpected, json_encode($oSomeSubPath));
    }



    public function testIsRelative()
    {
        $oTestPath = Path::make('home', 'anton', 'Documents');
        $this->assertTrue($oTestPath->isRelative());

        $oTestPath = Path::make('/home/anton/Documents');
        $this->assertFalse($oTestPath->isRelative());
    }

    public function testHasFileExtension()
    {
        $aTestPaths = [
            [
                'ext' => 'twig',
                'path' => [
                    'home',
                    'anton',
                    'Documents',
                    'file.twig'
                ],
                'expected' => true
            ],
            [
                'ext' => 'twig',
                'path' => ['/home/anton/Documents/file.twig'],
                'expected' => true
            ],
            [
                'ext' => 'twig',
                'path' => ['file.twig'],
                'expected' => true
            ],
            [
                'ext' => 'twig',
                'path' => ['valid/template/path.twig'],
                'expected' => true
            ],
            [
                'ext' => 'twig',
                'path' => ['/home/anton/Documents/file/twig'],
                'expected' => false
            ],
            [
                'ext' => 'twig',
                'path' => [
                    '/home/anton/Documents/file',
                    'twig'
                ],
                'expected' => false
            ],
            [
                'ext' => 'twig',
                'path' => [
                    '/home/anton/Documents/file',
                    '.twig'
                ],
                'expected' => false
            ],
        ];
        foreach ($aTestPaths as $aTestPath)
        {
            $oTest = Path::make($aTestPath['path']);
            if ($aTestPath['expected'] === true)
            {
                $this->assertTrue($oTest->hasExtension($aTestPath['ext']), json_encode($aTestPath['path']));
            }
            else
            {
                $this->assertFalse($oTest->hasExtension($aTestPath['ext']), json_encode($aTestPath['path']));
            }

        }
    }

    public function testIsAbsolute()
    {
        $oTestPath = Path::make('home', 'anton', 'Documents');
        $this->assertFalse($oTestPath->isAbsolute());

        $oTestPath = Path::make('/home/anton/Documents');
        $this->assertTrue($oTestPath->isAbsolute());
    }

    public function testTreeUp()
    {
        $oTestPath = Path::make('home', 'anton', 'Documents');
        $oPathCollection = $oTestPath->treeUp();

        $this->assertEquals($oPathCollection->current(), Path::make('home', 'anton', 'Documents'), "{$oPathCollection}");
        $oPathCollection->next();
        $this->assertEquals($oPathCollection->current(), Path::make('home', 'anton'), "{$oPathCollection}");
        $oPathCollection->next();
        $this->assertEquals($oPathCollection->current(), Path::make('home'), "{$oPathCollection}");

    }

    public function testWrite()
    {
        $oTestFile = DirectoryStructure::getTmpDir()->extend('tests', $this->sTestFileBaseName);
        $oTestFile->write($sExpected = 'this is a test');
        $this->assertTrue(trim(file_get_contents($oTestFile->getValue())) == $sExpected);
    }
    public function testMatches()
    {
        $oPath = Path::make('/home/anton/hurah/Crud/SomeModule/Whatever/Field');
        $this->assertTrue($oPath->matches(new Regex('/\/Crud\//')));
        $this->assertTrue($oPath->matches(new LiteralCallable(function (Path $path){
            return $path->isAbsolute();
        })));

    }

    public function testAppend()
    {
        $this->oTestFile->append('xxx');
        $this->assertTrue(preg_match('/xxx$/', (string)$this->oTestFile) === 1, __METHOD__ . ':' . __LINE__ . ' ' . (string)$this->oTestFile);
    }

    public function testContents()
    {

        file_put_contents((string)$this->oTestFile, $sExpected = 'this is expected');
        $this->assertTrue("{$this->oTestFile->contents()}" === "{$sExpected}");
    }

    public function testExists()
    {

        if ($this->oTestFile->exists())
        {
            $this->oTestFile->unlink();
        }
        $this->assertFalse($this->oTestFile->exists());
        $this->oTestFile->write('x');
        $this->assertTrue($this->oTestFile->exists());
    }

    public function testExtend()
    {
        $oPath1 = FileSystem::makePath('this', 'is', 'a');
        $oPath3 = $oPath1->extend('test');
        $oPath2 = FileSystem::makePath('this', 'is', 'a', 'test');
        $this->assertTrue((string)$oPath2 === (string)$oPath3, "(string){$oPath2} === (string) {$oPath3}");

        $sPath3 = $oPath3->extend('/');
        $this->assertTrue("{$oPath2}/" === (string) $sPath3, "(string){$oPath2} === (string) {$oPath3}");
    }

    public function testDirname()
    {
        $oPath1 = FileSystem::makePath('this', 'is', 'a', 'test');

        $oPath2 = FileSystem::makePath('this', 'is', 'a');
        $oPath3 = $oPath1->dirname();

        $this->assertTrue("{$oPath2}" === "{$oPath3}", "$oPath2 === $oPath3");
    }

    public function testIsFile()
    {
        if ($this->oTestFile->exists())
        {
            $this->oTestFile->unlink();
        }
        $this->assertFalse($this->oTestFile->isFile());
        $this->oTestFile->write('x');
        $this->assertTrue($this->oTestFile->isFile());
    }

    public function testMakeDir()
    {
        $oPath = FileSystem::makePath($this->oTestFile->dirname()->extend('test-dir1'));
        $this->assertFalse($oPath->isDir());
        $oPath->makeDir();
        $this->assertTrue($oPath->isDir());
        $oPath->unlink();
        $this->assertFalse($oPath->isDir());
    }

    public function testGetFile()
    {
        $sResult = $this->oTestFile->write($sExpected = '1232142312')->contents();
        $this->assertTrue("$sResult" === "$sExpected", "$sResult" . ' === ' . "$sExpected");
    }

    public function testGetDirectoryIterator()
    {
        $oDirectoryIterator = ($oCreatedDir = $this->oTestFile->dirname()->extend('x')->makeDir())->getDirectoryIterator();
        $this->assertInstanceOf(DirectoryIterator::class, $oDirectoryIterator);
        $oCreatedDir->unlink();

        $this->expectException(UnexpectedValueException::class);
        $oCreatedDir->getDirectoryIterator();
    }

    public function testIsDir()
    {
        $oPath = FileSystem::makePath($this->oTestFile->dirname()->extend('test-dir2'));
        $this->assertFalse($oPath->isDir());
        $oPath->makeDir();
        $this->assertTrue($oPath->isDir());
        $oPath->unlink();
        $this->assertFalse($oPath->isDir());

    }

    public function testUnlink()
    {
        $this->oTestFile->write('xyz');
        $this->assertTrue($this->oTestFile->isFile());
        $this->oTestFile->unlink();
        $this->assertFalse($this->oTestFile->isFile());
    }

    public function testBasename()
    {
        $this->assertTrue($this->oTestFile->basename() == $this->sTestFileBaseName, "{$this->oTestFile->basename()} == {$this->sTestFileBaseName}");
    }

    public function testMove()
    {
        $this->oTestFile->write($sExpected = 'needs-moving');
        $oDestination = DirectoryStructure::getTmpDir()->extend('tests', 'new-location.txt');
        $this->oTestFile->move($oDestination);

        $this->assertTrue((string)$oDestination->contents() === (string)$sExpected, (string)$oDestination->contents() . ' == ' . (string)$sExpected . print_r($oDestination->contents(), true) . ' x ' . print_r($sExpected, true));
        $this->assertTrue("$this->oTestFile" === "$oDestination");

        $oNewTestFile = $this->getTestFile();
        $this->assertFalse($oNewTestFile->exists());

        $oDestination->unlink();
    }

    protected function setUp(): void
    {
        $this->oTestFile = $this->getTestFile();
        $this->oTestFile->dirname()->makeDir();
        $this->oTestFile->write('x');
    }

    private function getTestFile(): Path
    {
        return DirectoryStructure::getTmpDir()->extend('tests', $this->sTestFileBaseName);
    }
}
