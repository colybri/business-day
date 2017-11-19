<?php

namespace Colybri\BusinessDay\MovableHolidays;

trait Catholic
{
    public function ashWednesday()
    {
        return $this->easterSunday()->subDays(46);
    }

    public function palmSunday()
    {
        return $this->easterSunday()->subDays(7);
    }

    public function maundyThursday()
    {
        return $this->easterSunday()->subDays(3);
    }

    public function goodFriday()
    {
        return $this->easterSunday()->subDays(2);
    }

    public function easterSunday()
    {
        $gold = ($this->year % 19) + 1;

        if ($this->year  <= 1752) {
            $dominical = ($this->year + ($this->year / 4) + 5) % 7;
            $fullMoon = (3 - (11 * $gold) - 7) % 30;
        } else {
            $dominical = ($this->year + ($this->year / 4) - ($this->year / 100) + ($this->year / 400)) % 7;
            $solar = ($this->year - 1600) / 100 - ($this->year - 1600) / 400;
            $lunar = ((($this->year - 1400) / 100) * 8) / 25;
            $fullMoon = (3 - 11 * $gold + $solar - $lunar) % 30;
        }

        while ($dominical < 0) {
            $dominical += 7;
        }

        while ($fullMoon < 0) {
            $fullMoon += 30;
        }

        if ($fullMoon == 29 || ($fullMoon == 28 && $gold > 11)) {
            $fullMoon--;
        }

        $difference = (4 - $fullMoon - $dominical) % 7;

        if ($difference < 0) {
            $difference += 7;
        }

        $easter = $fullMoon + $difference + 1;

        if ($easter < 11) {
            $easter = new static(($easter + 21)."-03-".$this->year);
        } else {
            $easter = $easter - 10;
            $easter = $easter < 10 ? "0".$easter : $easter;
            $easter = new static($easter."-04-".$this->year);
        }

        return $easter;
    }

    public function easterMonday()
    {
        return $this->easterSunday()->addDays(1);
    }

    public function ascensionDay()
    {
        return $this->easterSunday()->addDays(39);
    }

    public function pentecostSunday()
    {
        return $this->easterSunday()->addDays(49);
    }

    public function pentecostMonday()
    {
        return $this->easterSunday()->addDays(50);
    }
}
