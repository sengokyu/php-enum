# php-enum

## Abstract

This is a Java like enum class emulation.


## Usage

```php
<?php

use Sengokyu\Lang\PHPEnum;

class Day extends PHPEnum
{
    /* override static function. */
    /* register enum constants as given name. */
    protected static function initialize()
    {
        self::register('SUNDAY');
        self::register('MONDAY');
        self::register('TUESDAY');
        self::register('WEDNESDAY');
        self::register('THURSDAY');
        self::register('FRIDAY');
        self::register('SATURDAY');
    }
}

function dayEnumTest(Day $day)
{
   switch($day) {
     case Day::MONDAY():
       echo 'Mondays are bad.';
       break;
     case Day::SATURDAY():
     case Day::SUNDAY():
       echo 'Weekends are best.';
       break;
     default:
       echo 'Midweek days are so-so.';
   }
}

dayEnumTest(Day::MONDAY());   // -: Mondays are bad.
dayEnumTest(Day::SATURDAY()); // -: Weekends are best.
dayEnuMTest(Day::SUNDAY());   // -: Weekends are best.
```
