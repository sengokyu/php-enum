<?php

namespace Sengokyu\Lang;

/** 
 * Simple PHP enum class
 */
abstract class PHPEnum
{
    private static $ordinalToInstance = [];
    private static $nameToInstance = [];
    
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

        return self::$ordinalToInstance;
    }

    public static function valueOf($nameOrOrdinal) : PHPEnum
    {
        self::callInitialize();

        $test = is_string($nameOrOrdinal) ? self::$nameToInstance : self::$ordinalToInstance;

        if (!array_key_exists($nameOrOrdinal, $test)) {
            throw new \InvalidArgumentException("There are no enum constant that name/ordinal ${nameOrOrdinal}");
        }

        return $test[$nameOrOrdinal];
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

        self::$nameToInstance[$name] = $instance;
        self::$ordinalToInstance[$ordinal] = $instance;
    }

    abstract protected static function initialize();

    private static function createInstance()
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->newInstance();
    }

    private static function getOrdinal()
    {
        if (0 === sizeof(self::$ordinalToInstance)) {
            return 0;
        }
        else {
            $keys = array_keys(self::$ordinalToInstance);
            end($keys);
            return key($keys) + 1;
        }
    }

    private static function isInitialized()
    {
        return !empty(self::$ordinalToInstance);
    }

    private static function callInitialize()
    {
        if (!self::isInitialized()) {
            static::initialize();
        }
    }
}

