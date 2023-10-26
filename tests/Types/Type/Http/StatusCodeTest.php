<?php

namespace Test\Hurah\Types\Type\Http;

use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\Http\StatusCode;
use PHPUnit\Framework\TestCase;

class StatusCodeTest extends TestCase
{

	public function test__construct()
	{
		$this->expectException(RuntimeException::class);
		new StatusCode();
	}

    public function testGetMessage()
    {
		$sExpected = '200 OK';
		$sActual = (new StatusCode(200))->getMessage();
		$this->assertEquals($sActual, $sExpected);
    }


	/**
	 * @throws RuntimeException
	 */
	public function testGetHeader()
    {
        $oStatusCode = new StatusCode(301);
        $this->assertEquals('HTTP/1.1 301', $oStatusCode->getHeader());
    }

	/**
	 * @throws RuntimeException
	 */
	public function testIsError()
    {
        $oStatusCode = new StatusCode(501);
        $this->assertTrue($oStatusCode->isError());
        $oStatusCode = new StatusCode(401);
        $this->assertTrue($oStatusCode->isError());
        $oStatusCode = new StatusCode(301);
        $this->assertFalse($oStatusCode->isError());
    }

    public function testCanHaveBody()
    {
        $oStatusCode = new StatusCode(StatusCode::HTTP_OK);
        $this->assertTrue($oStatusCode->canHaveBody());

        $oStatusCode = new StatusCode(StatusCode::HTTP_FOUND);
        $this->assertTrue($oStatusCode->canHaveBody());

        $oStatusCode = new StatusCode(StatusCode::HTTP_NO_CONTENT);
        $this->assertFalse($oStatusCode->canHaveBody());
    }
}
