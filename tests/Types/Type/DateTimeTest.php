<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase {

    public function testConstructString() {

        $this->expectException(InvalidArgumentException::class);
        new DateTime("12312");
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testConstructDateTime()
    {
        $oDateTime = new DateTime(new \DateTime());
        $this->assertInstanceOf(DateTime::class, $oDateTime);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testConstructInt()
    {
        $oDateTime = new DateTime(time());
        $this->assertInstanceOf(DateTime::class, $oDateTime);
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public function testToTimestamp()
	{
		$iTime = time();
		$oDateTime = new DateTime(time());
		$this->assertEquals($iTime, $oDateTime->toTimestamp(), '.');

	}


    public function testGetMinute()
    {
        $oDateTime = new DateTime();
        $oDateTime->setTimestamp(1650961608);
        $this->assertEquals(26, $oDateTime->getMinute(), "Asserting " . time() . " is minute 26");
    }
    public function testGetHour24()
    {
        $oDateTime = new DateTime();
        $oDateTime->setTimestamp(1650961608);
        $this->assertEquals(8, $oDateTime->getHour24(), "Asserting " . time() . " is hour 10");
    }
}
