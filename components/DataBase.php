<?php

namespace components;

use lib\Configuration;

/**
 * Class DataBase
 * @package components
 */
class DataBase
{
    /**
     * @var
     */
    private static $connect;

    /**
     * @return \PDO
     * @throws \Exception
     */
    public static function getConnection()
    {
        if (!empty(self::$connect)) {
            return self::$connect;
        }
        $config = Configuration::getConfig();
        self::validationConfig($config);
        try {
            self::$connect = new \PDO('mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['dbname'],
                $config['mysql']['username'], $config['mysql']['password']);
        } catch (\PDOException $e) {
            throw new \Exception($e);
        }
        return self::$connect;
    }

    /**
     * @param $config
     * @throws \Exception
     */
    protected static function validationConfig($config)
    {
        if (empty($config['mysql'])) {
            throw new \Exception('Please add mysql config to ini file');
        }
        if (empty($config['mysql']['host'])) {
            throw new \Exception('Please add mysql host to ini file');
        }
        if (empty($config['mysql']['dbname'])) {
            throw new \Exception('Please add mysql dbname to ini file');
        }
        if (empty($config['mysql']['username'])) {
            throw new \Exception('Please add mysql username to ini file');
        }
        if (!isset($config['mysql']['password'])) {
            throw new \Exception('Please add mysql password to ini file');
        }
    }
}