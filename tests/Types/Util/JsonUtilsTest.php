<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Json;
use Hurah\Types\Util\JsonUtils;
use PHPUnit\Framework\TestCase;

class JsonUtilsTest extends TestCase {

    public function testDecodeInvalidInput() {
        $this->expectException(InvalidArgumentException::class);
        JsonUtils::decode('{"invalid", yes}');
    }

    public function testDecodeValidInput() {

        $aDecoded = JsonUtils::decode('{"valid" : true}', true);
        $this->assertTrue($aDecoded['valid'] === true);

        $aDecoded = JsonUtils::decode('{"valid" : "true"}', true);
        $this->assertTrue($aDecoded['valid'] === "true");
    }

    public function testEncode() {
        $oJson = JsonUtils::encode(["valid" => true]);

        $this->assertTrue($oJson instanceof Json);
        $sAsJsonString = preg_replace('/\s/', '', $oJson);
        $this->assertTrue( $sAsJsonString === '{"valid":true}', $sAsJsonString);
    }

    public function testIsValidJson()
    {
        $bShouldBeTrue = JsonUtils::isValidJson('{"valid" : "json"}');
        $this->assertTrue($bShouldBeTrue);

        $bShouldBeFalse = JsonUtils::isValidJson('asdfasfdas');
        $this->assertFalse($bShouldBeFalse);
    }
}
