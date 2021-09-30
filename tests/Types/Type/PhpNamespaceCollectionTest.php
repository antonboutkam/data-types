<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\PhpNamespaceCollection;
use PHPUnit\Framework\TestCase;

class PhpNamespaceCollectionTest extends TestCase
{

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