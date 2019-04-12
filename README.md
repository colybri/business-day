Business Day
====



This date library extends [Date](https://github.com/jenssegers/date) which in turn extends [Carbon](https://github.com/briannesbitt/Carbon) library. So all functionality of these libraries is also avaible. This library allows you to set a calendar of holidays in your Laravel application in a simple way.

Install using composer:

```bash
composer require colybri/business-day
```

Laravel 5
-------
For Laravel 5.5 or lower you must use version 1 of this library.
 
### Laravel version Compatibility

 Laravel  | Package
:---------|:----------
 5.0.x    | 1.0.x
 5.1.x    | 1.0.x
 5.2.x    | 1.0.x
 5.3.x    | 1.0.x
 5.4.x    | 1.0.x
 5.5.x    | 1.0.x
 5.6.x    | 2.0.x
 5.7.x    | 2.0.x
 
In Laravel 5.6 or higher, this package will be automatically discovered and you can safely skip the following two steps.
Add the following to the providers array in `config/app.php`:

```php
Colybri\BusinessDay\BusinessDayServiceProvider::class,
```

You can also add it as a Facade in `config/app.php`:

```php
'BusinessDay' => Colybri\BusinessDay\BusinessDay::class,
```

Configuration
-----
First of all you must configure the options of your holidays  calendar in `config/business-day.php` file. In order to edit the default configuration for this package you may execute:

```
php artisan vendor:publish --provider="Colybri\BusinessDay\BusinessDayServiceProvider"
```

```php
use Colybri\BusinessDay\BusinessDay;

$date = BusinessDay::now();

return [
 /*
  |--------------------------------------------------------------------------
  | Holidays calendar
  |--------------------------------------------------------------------------
  |
  */
  'restDay' => 0, //Sunday
  'saturdayIsBusinessDay' => "false",
  'holidays' => [
      "01-01",
      $date->easterSunday()->addDay()->config(),
      $date->goodFriday()->config(),
      "06-01",
      //vacational periods
      [
          "01-08", "31-08"
      ],
      [
          "24-12", "27-12"
      ],
      ...
  ],
];
```
The option `restDay` set to 0 establish Sunday as holiday. If you don't want this behavior by default set the field to "false". All literal dates must be indicate whit format "d-m". If you want to use available methods of this library for mobile holidays you must to call after to config method. You can also indicates vacational periods with start and end date.

Usage
-----

List of methods of the BusinessDay class:

```php
use Colybri\BusinessDay\BusinessDay;

$date = BusinessDay::now();
$date->isBusinessDay(); //return true or false
$date->nextBusinessDay();
$date->previousBusinessDay();
```

Methods such as `nextBusinessDay` and `previousBusinessDay` return a BusinessDay object with all functionality of Date and Carbon libraries.


### Catholic holidays

Available methods for Catholic mobile holidays:

```php
$date = new BusinessDay('2000-01-31', 'Europe/Brussels');
$date->ashWednesday();
$date->palmSunday();
$date->maundyThursday();
$date->goodFriday();
$date->easterSunday();
$date->easterMonday();
$date->ascensionDay();
$date->pentecostSunday();
$date->pentecostMonday();
```

All this methods return a BusinessDay object with all functionality of Date and Carbon libraries.




**NOTE!** In Next versions i will try to include other religious mobile holidays.

## License

Laravel BusinessDay is licensed under [The MIT License (MIT)](LICENSE).
