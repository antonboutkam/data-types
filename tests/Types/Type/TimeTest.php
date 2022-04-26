<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    private Time $oMorning;
    private Time $oNoon;
    private Time $oEvening;
    private Time $oNight;
    private Time $oMorningWithSeconds;
    private Time $oEveningWithSeconds;
    private Time $oNightWithSeconds;

    public function setUp():void
    {
        $this->oMorning = new Time('09:00');
        $this->oNoon = new Time('12:00');
        $this->oEvening = new Time('19:46');
        $this->oNight = new Time('23:10');
        $this->oMorningWithSeconds = new Time('23:10:10');
        $this->oEveningWithSeconds = new Time('23:10:04');
        $this->oNightWithSeconds = new Time('23:10:40');
        parent::setUp();
    }

    public function testToString()
    {
        $this->assertEquals('23:10:10', (string) $this->oMorningWithSeconds);
    }
    public function testAddHours()
    {
        $this->assertEquals($this->oMorning, $this->oMorning->addHours(48));
        $this->assertEquals($this->oNoon, $this->oNoon->addHours(72));
        $this->assertEquals('00:46', $this->oEvening->addHours(5));
        $this->assertEquals('05:10', $this->oNight->addHours(6));
    }

    public function testAddMinutes()
    {
        $this->assertEquals('10:10', $this->oMorning->addMinutes(70));
        $this->assertEquals('12:15', $this->oNoon->addMinutes(15));
        $this->assertEquals('20:02', $this->oEvening->addMinutes(16));
        $this->assertEquals('00:20', $this->oNight->addMinutes(70));
    }

}
