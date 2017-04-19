<?php

namespace lib;

/**
 * Class Configuration
 * @package lib
 */
class Configuration
{
    /**
     * @var
     */
    private static $config = [];

    /**
     * @param $iniFile
     * @return array
     */
    public static function set($iniFile)
    {
        if (!empty(static::$config)) {
            return static::$config;
        }
        static::$config = parse_ini_file($iniFile, true);
    }

    /**
     * @return array
     */
    public static function getConfig()
    {
        return static::$config;
    }
}