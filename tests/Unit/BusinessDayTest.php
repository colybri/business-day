<?php

namespace BusinessDayTests\Unit\BusinessDayTest;

use BusinessDayTests\Mock\BusinessDayMock;
use PHPUnit\Framework\TestCase;
use Colybri\BusinessDay\BusinessDay;

class BusinessDayTest extends TestCase
{


    public function maundayThursdayProvider()
    {
        return [
            ['1956', '03-29'],
            ['2019', '04-18'],
            ['2377', '03-24'],
            ['2499', '03-26']
        ];
    }

    /**
     * @test
     * @dataProvider maundayThursdayProvider
     */
    public function given_valid_date_then_check_maunday_thursday($year, $mundayThuesday)
    {
        $date = BusinessDay::createFromFormat('Y', $year);
        $this->assertSame($mundayThuesday, $date->maundyThursday()->format('m-d'));
    }

    /**
     * @test
     */
    public function given_saturday_config_true_then_is_business_day()
    {
        $mock = BusinessDayMock::create(2014, 5, 30)->nthOfMonth(2, BusinessDayMock::SATURDAY);
        $mock->setup([
            'saturdayIsBusinessDay' => true,
            'restDay' => 0,
            'holidays' => []
        ]);
        $this->assertSame(true, $mock->isBusinessDay());
    }

    /**
     * @test
     */
    public function given_saturday_config_false_then_is_not_business_day()
    {
        $mock = BusinessDayMock::create(2014, 5, 30)->nthOfMonth(2, BusinessDayMock::SATURDAY);
        $mock->setup([
            'saturdayIsBusinessDay' => false,
            'restDay' => 0,
            'holidays' => []
        ]);
        $this->assertSame(false, $mock->isBusinessDay());
    }

    public function holidaysProvider()
    {
        return [
            ['01', '03', '1967'],
            ['22', '04', '1967'],
            ['15', '05', '1967'],
            ['31', '01', '2025']
        ];
    }

    /**
     * @test
     * @dataProvider holidaysProvider
     */
    public function given_date_on_holiday_period_then_is_not_business_day($day, $month, $year)
    {
        $mock = BusinessDayMock::create($year, $month, $day);
        $mock->setup([
            'saturdayIsBusinessDay' => true,
            'restDay' => 0,
            'holidays' => [
                ['01-03', '15-05'],
                ['30-01', '31-01']
            ]
        ]);
        $this->assertSame(false, $mock->isBusinessDay());
    }

    /**
     * @test
     */
    public function given_monday_config_rest_day_then_sunday_is_business_day()
    {
        $mock = BusinessDayMock::create(2014, 5, 30)->nthOfMonth(2, BusinessDayMock::SUNDAY);

        $mock->setup([
            'saturdayIsBusinessDay' => false,
            'restDay' => 1,
            'holidays' => [
                ['01-03', '15-04'],
                ['30-01', '31-01']
            ]
        ]);
        $this->assertSame(true, $mock->isBusinessDay());
    }
}