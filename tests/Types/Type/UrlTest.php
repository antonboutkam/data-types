<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Http\Response;
use Hurah\Types\Type\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{

    function testCreate()
    {
        $oUrl = new Url();
        $this->assertTrue($oUrl instanceof Url);
    }

    function testGet()
    {
        $oUrl = new Url('https://antonboutkam.nl');
        $oResponse = $oUrl->get();
        $this->assertInstanceOf(Response::class, $oResponse);

        $this->assertTrue(strpos("{$oResponse->getBody()}", '<!DOCTYPE html>') === 0, "{$oResponse->getBody()}");

    }

    function testAddPath()
    {
        $oUrl = new Url('/this/is');
        $oUrl->addPath('a', 'test');


        $this->assertTrue("{$oUrl}" == "/this/is/a/test");
    }


    function testAddQuery()
    {
        $oUrl = new Url('/this/is');
        $oUrl->addQuery(['a' => 'test']);
        $this->assertTrue("{$oUrl}" == "/this/is?a=test");
        $oUrl->addQuery(['a' => 'test', 'b' => 'test']);
        $this->assertTrue("{$oUrl}" == "/this/is?a=test&b=test", "{$oUrl}");
    }


    function testAddPathWithQuery()
    {
        $oUrl = new Url('/this/is?works=yes');
        $oUrl->addPath('a', 'test');


        $this->assertTrue("{$oUrl}" == "/this/is/a/test?works=yes");
    }

    function testAddPathFull()
    {
        $oUrl = new Url('http://www.google.com/this/is?works=yes');
        $oUrl->addPath('a', 'test');
        $this->assertTrue("{$oUrl}" == "http://www.google.com/this/is/a/test?works=yes", "{$oUrl}");
    }

    function testSetPathFull()
    {
        $oUrl = new Url('http://www.google.com/this/is?works=yes');
        $oUrl->setPath(null);
        $this->assertTrue("{$oUrl}" == "http://www.google.com?works=yes", "{$oUrl}");
    }
}
