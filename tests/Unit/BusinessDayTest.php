<?php

namespace BusinessDayTests\Unit\BusinessDayTest;

use PHPUnit\Framework\TestCase;
use Colybri\BusinessDay\BusinessDay;

class BusinessDayTest extends TestCase
{

    /**
     * @test
     */
    public function given_valid_date_then_check_maunday_thursday()
    {
        $date = BusinessDay::createFromFormat('Y', '2019');
        $this->assertSame('2019-04-18', $date->maundyThursday()->format('Y-m-d'));
    }
}