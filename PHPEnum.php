<?php

namespace Sengokyu\Lang;

/** 
 * Simple PHP enum class
 */
abstract class PHPEnum
{
    private static $internals = [];
    private $ordinal;
    private $name;
    
    /** 
     * Returns the ordinal of this enumeration constant
     */
    public function ordinal()
    {
        return $this->ordinal;
    }

    /** 
     * Returns the name of this enumeration constant
     */
    public function name()
    {
        return $this->name;
    }

    /** 
     * Returns the name of this enumeration constant
     */
    public function __toString()
    {
        return $this->name;
    }

    public static function values()
    {
        self::callInitialize();

        return self::getInternal(get_called_class())->values();
    }

    public static function valueOf($nameOrOrdinal) : PHPEnum
    {
        self::callInitialize();

        return self::getInternal(get_called_class())->valueOf($nameOrOrdinal);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::valueOf($name);
    }

    protected static function register($name, PHPEnum $instance = null, $ordinal = null)
    {
        $instance = $instance ?? self::createInstance();
        $ordinal = $ordinal ?? self::getOrdinal();

        $instance->name = $name;
        $instance->ordinal = $ordinal;

        self::getInternal(get_called_class())->register($name, $instance, $ordinal);
    }

    abstract protected static function initialize();

    private static function getInternal($clazz)
    {
        if (!array_key_exists($clazz, self::$internals)) {
            self::$internals[$clazz] = new PHPEnumInternal();
        }

        return self::$internals[$clazz];
    }

    private static function createInstance()
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->newInstance();
    }

    private static function getOrdinal()
    {
        $values = self::getInternal(get_called_class())->values();

        if (0 === sizeof($values)) {
            return 0;
        }
        else {
            $keys = array_keys($values);
            end($keys);
            return current($keys) + 1;
        }
    }

    private static function isInitialized()
    {
        return array_key_exists(get_called_class(), self::$internals);
    }

    private static function callInitialize()
    {
        if (!self::isInitialized()) {
            static::initialize();
        }
    }
}


class PHPEnumInternal
{
    private $ordinalToInstance = [];
    private $nameToInstance = [];

    public function register($name, PHPEnum $instance, $ordinal)
    {
        $this->ordinalToInstance[$ordinal] = $instance;
        $this->nameToInstance[$name] = $instance;
    }

    public function values()
    {
        return $this->ordinalToInstance;
    }

    public function valueOf($nameOrOrdinal)
    {
        $test = is_string($nameOrOrdinal) ?
          $this->nameToInstance : $this->ordinalToInstance;

        if (!array_key_exists($nameOrOrdinal, $test)) {
            throw new \InvalidArgumentException("There are no enum constant that name/ordinal ${nameOrOrdinal}");
        }

        return $test[$nameOrOrdinal];
    }
}

