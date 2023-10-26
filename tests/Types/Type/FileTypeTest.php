<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\FileType;
use Hurah\Types\Type\Regex;
use Hurah\Types\Type\RegexCollection;
use PHPUnit\Framework\TestCase;

class FileTypeTest extends TestCase
{

    public function testMake()
    {
        $oPhpFileType = FileType::make('Tekst bestand');
        $this->assertInstanceOf(FileType::class, $oPhpFileType);
    }

    public function testSetFileNamePatterns()
    {
        $oTests = new RegexCollection();
        $oTests->add(new Regex('/[a-zA-Z0-9]+\.php$/'));
        $oPhpFileType = FileType::make('png');
        $oPhpFileType->setFileNamePatterns($oTests);

        $this->assertTrue($oPhpFileType->test('test.php'));

        $this->assertFalse($oPhpFileType->test('test.xphp'));
    }

    public function test__toString()
    {
        $sExpected = 'Tekst bestand';
        $oTekstBestand = FileType::make('Tekst bestand');
        $this->assertEquals($sExpected, (string) $oTekstBestand);
    }

    public function testFromExtension()
    {
        $oTekstBestand = FileType::fromExtension('.jpg');
        $this->assertTrue($oTekstBestand->test('profile.jpg'));

        $oTekstBestand = FileType::fromExtension('jpg');
        $this->assertFalse($oTekstBestand->test('profile.jpgds'));

        $oTekstBestand = FileType::fromExtension('jpg');
        $this->assertFalse($oTekstBestand->test('profi.jpg.le.jpgds'));

        $oTekstBestand = FileType::fromExtension('jpg');
        $this->assertFalse($oTekstBestand->test('profi.jpg '));
    }

    public function testTest()
    {
        $oTekstBestand = FileType::fromExtension('jpg');
        $this->assertTrue($oTekstBestand->test('profile.jpg'));
    }
}
