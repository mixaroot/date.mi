<?php

namespace lib;

/**
 * Interface LogsInterface
 */
interface LogsInterface
{
    /**
     * @param \PDO $connection
     */
    function __construct(\PDO $connection);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function addParamForLog($name, $value);

    /**
     * @return mixed
     */
    public function write();
}