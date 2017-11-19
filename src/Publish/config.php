<?php

use Colybri\BusinessDay\BusinessDay;

$date = BusinessDay::now();

return [
 /*
  |--------------------------------------------------------------------------
  | Curiers credentials for authentificate services
  |--------------------------------------------------------------------------
  |
  */

  'restDay' => 0,
  'saturdayIsBusinessDay' => "false",
  'holidays' => [

  ],


];
