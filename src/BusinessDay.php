<?php

namespace Colybri\BusinessDay;

use Jenssegers\Date\Date as Jenssenger;
use Colybri\BusinessDay\MovableHolidays\Catholic;

class BusinessDay extends Jenssenger
{
    use Catholic;

    const CONF_FORMAT = "d-m";

    const SATURDAY = 6;

    public function isBusinessDay(): bool
    {
        return !$this->isRestDay() && !$this->isHoliday() && $this->isSaturdayBusinessDay();
    }

    public function isRestDay(): bool
    {
        return $this->dayOfWeek === config('business-day.restDay');
    }

    public function isSaturdayBusinessDay(): bool
    {
        return config('business-day.saturdayIsBusinessDay') && $this->dayOfWeek == self::SATURDAY;
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
                if ($this->onHolidayPeriod($date)) {
                    return true;
                }
            } else {
                if ($this->onHoliday($date)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function onHoliday($date): bool
    {
        return $date."-".$this->year == $this->format("d-m-Y");
    }

    private function onHolidayPeriod($dates): bool
    {
        return $this->between(
            (new static($dates[0]."-".$this->year))->subDay(),
            (new static($dates[1]."-".$this->year))->addDay()
        );
    }

    public function config()
    {
        return  $this->format(self::CONF_FORMAT);
    }
}
