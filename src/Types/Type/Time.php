<?php
namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

use function explode;
use function str_pad;
use const STR_PAD_LEFT;

class Time extends AbstractDataType implements IGenericDataType
{
    private int $iHour;
    private int $iMinute;
    private ?int $iSeconds = null;

    /**
     * @param string|null $sValue time in human-readable notation, example '06:00' or '06:00:10'
     *
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {
        $aParts = explode(':', $sValue);
        if(count($aParts) == 2)
        {
            list($iHours, $iMinutes) = $aParts;
        }
        elseif(count($aParts) === 3)
        {
            list($iHours, $iMinutes, $iSeconds) = $aParts;
        }


        $this->iHour = (int)$iHours;
        $this->iMinute = (int)$iMinutes;
        if(isset($iSeconds))
        {
            $this->iSeconds = (int) $iSeconds;
        }


        $this->timeValidCheck();
        parent::__construct($sValue);
    }

    public function addMinutes(int $iMinutes): Time
    {
        $oNewTime = new Time("{$this}");
        for ($i = 0; $i < $iMinutes; $i++)
        {
            $oNewTime->addMinute();
        }
        return $oNewTime;
    }

    public function addHours(int $iHours): Time
    {
        $oNewTime = new Time("{$this}");
        for ($i = 0; $i < $iHours; $i++)
        {
            $oNewTime->addHour();
        }
        return $oNewTime;
    }

    public function getHour(): int
    {
        return $this->iHour;
    }

    public function getMinute(): int
    {
        return $this->iMinute;
    }

    public function __toString(): string
    {
        $sZeroFilledHour = str_pad($this->iHour, 2, "0", STR_PAD_LEFT);
        $sZeroFilledMinute = str_pad($this->iMinute, 2, "0", STR_PAD_LEFT);

        if($this->iSeconds === null)
        {
            return "$sZeroFilledHour:$sZeroFilledMinute";
        }
        $sZeroFilledSeconds = str_pad($this->iSeconds, 2, "0", STR_PAD_LEFT);
        return "$sZeroFilledHour:$sZeroFilledMinute:$sZeroFilledSeconds";

    }

    private function addMinute(): void
    {
        if ($this->iMinute + 1 > 59)
        {
            $this->addHour();
            $this->iMinute = 0;
        }
        else
        {
            ++$this->iMinute;
        }
    }

    private function addHour(): void
    {
        $this->iHour = ($this->iHour + 1 > 23) ? 0 : $this->iHour + 1;
    }

    private function timeValidCheck(): void
    {
        if ($this->iHour > 23)
        {
            throw new InvalidArgumentException("Hour cannot exceed 24");
        }
        elseif ($this->iHour < 0)
        {
            throw new InvalidArgumentException("Hour cannot go below 0");
        }
        if ($this->iMinute > 59)
        {
            throw new InvalidArgumentException("Minute cannot exceed 59");
        }
        elseif ($this->iMinute < 0)
        {
            throw new InvalidArgumentException("Minute cannot go below 0");
        }
    }
}