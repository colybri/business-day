<?php

namespace Colybri\BusinessDay;

use Jenssegers\Date\Date as Jenssenger;
use Colybri\BusinessDay\MovableHolidays\Catholic;

class BusinessDay extends Jenssenger
{
    use Catholic;

    private static $configFormat = "d-m";


    public function isBusinessDay()
    {
        return $this->dayOfWeek === config('business-day.restDay') | (config('business-day.saturdayIsBusinessDay') && $this->dayOfWeek == 6) | $this->isHoliday() ? false : true;
    }

    public function nextBusinessDay()
    {
        $date = $this;
        do {
            $date = $date->addDay();
        } while (!$date->isBusinessDay());

        return $date;
    }

    public function previousBusinessDay()
    {
        $date = $this;
        do {
            $date =  $date->subDay();
        } while (!$date->isBusinessDay());

        return $date;
    }

    private function isHoliday()
    {
        foreach (config('business-day.holidays') as $date) {
            if (is_array($date)) {
                if ($this->inHolidayPeriod($date)) {
                    return true;
                }
            } else {
                if ($date."-".$this->year == $this->format("d-m-Y")) {
                    return true;
                }
            }
        }
        return false;
    }

    private function inHolidayPeriod($dates)
    {
        $start = new static($dates[0]."-".$this->year);
        $finish = new static($dates[1]."-".$this->year);
        return $this->between($start->subDay(), $finish->addDay());
    }

    public function config()
    {
        return  $this->format(self::$configFormat);
    }
}
