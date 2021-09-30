<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PhpNamespaceCollection;
use PHPUnit\Framework\TestCase;
use function var_dump;

class PhpNamespaceCollectionTest extends TestCase
{


    public function testAdd()
    {
        $oPhpNamespaceCollection = new PhpNamespaceCollection();
        $oPhpNamespaceCollection->add($oNs = new PhpNamespace('\\NoneExisting\\Class'));
        $this->assertEquals($oNs, $oPhpNamespaceCollection->current());
    }
    public function testAddString()
    {
        $oPhpNamespaceCollection = new PhpNamespaceCollection();
        $oPhpNamespaceCollection->addString($sNs = '\\NoneExisting\\Class');
        $this->assertEquals(new PhpNamespace($sNs), $oPhpNamespaceCollection->current());
    }
    public function testFindFirstExisting()
    {
        $oPhpNamespaceCollection = new PhpNamespaceCollection();
        $oPhpNamespaceCollection->addString('\\NoneExisting\\Class');
        $oPhpNamespaceCollection->addString('\\AnotherNoneExisting\\Class');
        $oPhpNamespaceCollection->addString('\\AndAnotherNoneExisting\\Class');
        $oPhpNamespaceCollection->add(new PhpNamespace(self::class));

        $this->assertEquals(self::class, $oPhpNamespaceCollection->getFirstExisting());
    }
}