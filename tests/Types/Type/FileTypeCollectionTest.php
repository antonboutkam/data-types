<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\FileType;
use Hurah\Types\Type\FileTypeCollection;
use PHPUnit\Framework\TestCase;

class FileTypeCollectionTest extends TestCase
{

    /**
     * @throws InvalidArgumentException
     */
    public function testMerge()
    {
        $oFileType = FileType::fromExtension('png');
        $oFileTypeCollection = FileTypeCollection::fromFileTypes($oFileType, $oFileType, $oFileType);
        $this->assertEquals(1, $oFileTypeCollection->length());

        $oFileType1 = FileType::fromExtension('jpg');
        $oFileType2 = FileType::fromExtension('gif');
        $oFileType3 = FileType::fromExtension('bmp');
        $oFileTypeCollection = FileTypeCollection::fromFileTypes($oFileType1, $oFileType2, $oFileType3);
        $this->assertEquals(3, $oFileTypeCollection->length());
    }

    public function testToArray()
    {
        $oFileType1 = FileType::fromExtension('jpg');
        $oFileType2 = FileType::fromExtension('gif');
        $oFileType3 = FileType::fromExtension('bmp');
        $oFileTypeCollection = FileTypeCollection::fromFileTypes($oFileType1, $oFileType2, $oFileType3);
        foreach($oFileTypeCollection->toArray() as $fileType)
        {
            $this->assertInstanceOf(FileType::class, $fileType);
        }

    }

    public function testReverse()
    {
        $oFileType1 = FileType::fromExtension('jpg');
        $oFileType2 = FileType::fromExtension('gif');
        $oFileType3 = FileType::fromExtension('bmp');
        $oFileTypeCollection = FileTypeCollection::fromFileTypes($oFileType1, $oFileType2, $oFileType3);
        $aReverse = $oFileTypeCollection->reverse()->toArray();
        $this->assertEquals('bmp', $aReverse[0]->getName());
        $this->assertEquals('gif', $aReverse[1]->getName());
        $aReverse = $oFileTypeCollection->toArray();
        $this->assertEquals('jpg', $aReverse[0]->getName());
    }

    public function testFromFileTypeCollections()
    {
        $oFileType1 = FileType::fromExtension('jpg');
        $oFileType2 = FileType::fromExtension('gif');
        $oFileType3 = FileType::fromExtension('bmp');
        $oFileTypeCollection = FileTypeCollection::fromFileTypes($oFileType1, $oFileType2, $oFileType3);
        $oFileTypeCollection2 = clone $oFileTypeCollection;
        $oFileType4 = FileType::fromExtension('png');
        $oFileTypeCollection2->add($oFileType4);
        $oCombined = FileTypeCollection::fromFileTypeCollections($oFileTypeCollection, $oFileTypeCollection2);
        $this->assertEquals(4, $oCombined->length());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testAdd()
    {
        $oCollection = new FileTypeCollection();
        $oCollection->add(FileType::fromExtension('jpg'));
        $oCollection->add(FileType::fromExtension('png'));
        $oCollection->add(FileType::fromExtension('bmp'));

        $aTests = ['jpg', 'png', 'bmp'];
        foreach ($oCollection as $oFileType)
        {
            $test = array_shift($aTests);
            $this->assertEquals($test, $oFileType->getName());
        }
    }


    /**
     * @throws InvalidArgumentException
     */
    public function testAppendCollections()
    {
        $oCollection = new FileTypeCollection();
        $oCollection->add(FileType::fromExtension('jpg'));
        $oCollection->add(FileType::fromExtension('png'));
        $oCollection->add(FileType::fromExtension('bmp'));
        $oCollection->add(FileType::fromExtension('xls'));

        $oCollection2 = new FileTypeCollection();
        $oCollection2->add(FileType::fromExtension('xls'));
        $oCollection2->add(FileType::fromExtension('xlsx'));
        $oCollection2->add(FileType::fromExtension('doc'));

        $oCollection->appendCollections($oCollection2);

        $this->assertEquals(6, $oCollection->length());
    }

    public function test__toString()
    {
        $oCollection = new FileTypeCollection();
        $oCollection->add(FileType::fromExtension('xls'));
        $oCollection->add(FileType::fromExtension('xlsx'));
        $oCollection->add(FileType::fromExtension('doc'));
        $this->assertEquals("xls,xlsx,doc", (string)$oCollection);
    }

    public function testFromFileTypes()
    {
        $col = FileTypeCollection::fromFileTypes(
            FileType::fromExtension('xls'),
            FileType::fromExtension('doc')
        );
        $this->assertEquals(2, $col->length());

    }

    public function testAddCollection()
    {

    }

    public function testTest()
    {
        $col = FileTypeCollection::fromFileTypes(
            FileType::fromExtension('xls'),
            FileType::fromExtension('doc')
        );
        $this->assertTrue($col->test('Financiële situatie .xls'));
        $this->assertTrue($col->test('Financiële situatie.xls'));
        $this->assertTrue($col->test('Algemene vergadering.doc'));
        $this->assertTrue($col->test('algemene-vergadering.doc'));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testFilter()
    {
        $col = FileTypeCollection::fromFileTypes(
            $x = FileType::fromExtension('xls'),
            FileType::fromExtension('doc')
        );
        $cCol2 =  $col->filter($x);
        print_r($cCol2);
    }
}
