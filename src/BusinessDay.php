<?php

namespace Colybri\BusinessDay;

use Jenssegers\Date\Date as Jenssenger;
use Colybri\BusinessDay\MovableHolidays\Catholic;

class BusinessDay extends Jenssenger
{
    use Catholic;

    public function isBusinessDay(): bool
    {
        return !$this->isRestDay()
            & !$this->isHoliday($this->getConfig(Configuration::HOLIDAYS))
            & !$this->isSaturdayAndRestDay();
    }

    private function isRestDay(): bool
    {
        return $this->dayOfWeek === $this->getConfig(Configuration::REST_DAY);
    }

    private function isSaturdayAndRestDay()
    {
        return $this->isSaturday() ? !$this->isSaturdayBusinessDay() : false;
    }

    private function isSaturdayBusinessDay(): bool
    {
        return $this->getConfig(Configuration::SATURDAY_IS_BUSINESS_DAY);
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
            $date = $date->subDay();
        } while (!$date->isBusinessDay());

        return $date;
    }

    private function isHoliday(array $holidays)
    {
        foreach ($holidays as $date) {
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
        return $date . "-" . $this->year == $this->format("d-m-Y");
    }

    private function onHolidayPeriod($dates): bool
    {
        return $this->between(
            (new static($dates[0] . "-" . $this->year))->subDay(),
            (new static($dates[1] . "-" . $this->year))->addDay()
        );
    }

    protected function getConfig($config)
    {
        $config = config('business-day.' . $config);
        return $config;
    }

    public function config()
    {
        return $this->format(Configuration::CONF_DATE_FORMAT);
    }
}