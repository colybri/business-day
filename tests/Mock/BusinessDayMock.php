<?php

namespace BusinessDayTests\Mock;

use Colybri\BusinessDay\BusinessDay;

class BusinessDayMock extends BusinessDay
{
    private $config;

    public function setup(array $config)
    {
        $this->config = $config;
    }

    public function getConfig($key)
    {
        return $this->config[$key];
    }
}