<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\PhpNamespace;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class PhpNamespaceTest extends TestCase {

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testExtend()
    {

        $oNamespace = new PhpNamespace('Test');

        $this->assertEquals(
            'Test\\Testing',
            $oNamespace->extend('Testing'),
            'Namespace extend not working'
        );
    }
    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testGetFqn()
    {
        $oNamespace = PhpNamespace::make('This', 'Is', 'A', 'Test');
        $this->assertEquals('\\This\\Is\A\\Test', "{$oNamespace->getFqn()}");
    }
    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testGetNameSpaceName()
    {
        $oNamespace = PhpNamespace::make('This', 'Is', 'A', 'Test');
        $oClassName = $oNamespace->extend('SomeClass');
        $this->assertEquals($oNamespace, $oClassName->getNamespaceName());
        $this->assertEquals('This\\Is\A', "{$oNamespace->getNamespaceName()}");
    }
    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @depends testMake
     */
    public function testReduce()
    {
        $oNamespace = PhpNamespace::make('Test', 'Testing', 'One', 'Two', 'Three');
        $oNamespace->extend('Testing');
        $this->assertEquals(
            'Test\\Testing\\One\\Two\\Three',
            "{$oNamespace}",
            'Namespace extend not working'
        );

        $oNamespaceReducedOne = $oNamespace->reduce(1);
        $this->assertEquals(
            'Test\\Testing\\One\\Two',
            "{$oNamespaceReducedOne}",
            "{$oNamespaceReducedOne}"
        );

        $oNamespaceReducedTwo = $oNamespace->reduce(2);
        $this->assertEquals(
            'Test\\Testing\\One',
            "{$oNamespaceReducedTwo}",
            "{$oNamespaceReducedTwo}"
        );

        $oNamespaceReducedThree = $oNamespace->reduce(4);
        $sExpected = 'Test';
        $this->assertEquals(
            $sExpected,
            "{$oNamespaceReducedThree}",
            "{$oNamespaceReducedThree}"
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @depends testMake
     */
    public function testGetShortName()
    {
        $oNamespace = PhpNamespace::make('Test', 'Testing', 'One', 'Two', 'Three');
        $this->assertEquals('Three', $oNamespace->getShortName());
    }

    public function testMake()
    {
        $oNamespace = PhpNamespace::make('Test', 'Testing', 'One');
        $this->assertEquals('Test\\Testing\\One', "{$oNamespace}");
    }

}
