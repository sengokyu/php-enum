<?php

namespace Sengokyu\Lang;

use PHPUnit\Framework\TestCase;

class Day extends PHPEnum
{
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



class PHPEnumTests extends TestCase
{
    public function testOrdinal()
    {
        $this->assertEquals(0, Day::SUNDAY()->ordinal());
        $this->assertEquals(1, Day::MONDAY()->ordinal());
        $this->assertEquals(2, Day::TUESDAY()->ordinal());
        $this->assertEquals(3, Day::WEDNESDAY()->ordinal());
        $this->assertEquals(4, Day::THURSDAY()->ordinal());
        $this->assertEquals(5, Day::FRIDAY()->ordinal());
        $this->assertEquals(6, Day::SATURDAY()->ordinal());
    }

    public function testName()
    {
        $this->assertEquals('SUNDAY', Day::SUNDAY()->name());
        $this->assertEquals('MONDAY', Day::MONDAY()->name());
        $this->assertEquals('TUESDAY', Day::TUESDAY()->name());
        $this->assertEquals('WEDNESDAY', Day::WEDNESDAY()->name());
        $this->assertEquals('THURSDAY', Day::THURSDAY()->name());
        $this->assertEquals('FRIDAY', Day::FRIDAY()->name());
        $this->assertEquals('SATURDAY', Day::SATURDAY()->name());
    }

    public function testValues()
    {
        $actual = Day::values();

        $this->assertCount(7, $actual);
        $this->assertContainsOnlyInstancesOf(Day::class, $actual);
    }

    public function testValueOfByString()
    {
        $actual = Day::valueOf('SUNDAY');

        $this->assertEquals(Day::SUNDAY(), $actual);
    }

    public function testValueOfByInteger_1()
    {
        $actual = Day::valueOf(0);
        $this->assertEquals(Day::SUNDAY(), $actual);
    }

    public function testValueOfByInteger_2()
    {
        $actual = Day::valueOf(1);
        $this->assertEquals(Day::MONDAY(), $actual);
    }

    public function testSwitchCaseCapable()
    {
        $thursday = Day::THURSDAY();

        switch($thursday) {
            case Day::SUNDAY():
              throw new Exception('SwitchCase test failed.');
            case Day::MONDAY():
              throw new Exception('SwitchCase test failed.');
            case Day::TUESDAY():
              throw new Exception('SwitchCase test failed.');
            case Day::WEDNESDAY():
              throw new Exception('SwitchCase test failed.');
            case Day::THURSDAY():
              $this->assertEquals($thursday, Day::THURSDAY());
              break;
            case Day::FRIDAY():
              throw new Exception('SwitchCase test failed.');
            case Day::SATURDAY():
              throw new Exception('SwitchCase test failed.');
        }
    }

    public function testToString()
    {
        $this->assertEquals('SUNDAY', Day::SUNDAY());
        $this->assertEquals('MONDAY', Day::MONDAY());
        $this->assertEquals('TUESDAY', Day::TUESDAY());
        $this->assertEquals('WEDNESDAY', Day::WEDNESDAY());
        $this->assertEquals('THURSDAY', Day::THURSDAY());
        $this->assertEquals('FRIDAY', Day::FRIDAY());
        $this->assertEquals('SATURDAY', Day::SATURDAY());
    }
}
