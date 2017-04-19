<?php

namespace components;

use lib\LogsInterface;
use lib\Configuration;

/**
 * Class Logs
 * @package components
 */
class Logs implements LogsInterface
{
    /**
     * @var \PDO
     */
    private $connection;
    /**
     * @var array
     */
    private $params = [];

    /**
     * @param \PDO $connection
     */
    function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $name
     * @param $value
     */
    public function addParamForLog($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @throws \Exception
     */
    public function write()
    {
        $this->setTimeRequest();
        $table = $this->getTable();
        $fields = $this->getFields($table);
        $bind = implode(', ', array_fill(0, count($this->params), '?'));
        $sql = "INSERT INTO $table ($fields) VALUES ($bind)";
        $stmt = $this->connection->prepare($sql);
        $i = 1;
        foreach ($this->params as &$value) {
            $stmt->bindParam($i, $value);
            $i++;
        }
        unset($value);
        $stmt->execute();
    }

    /**
     * @throws \Exception
     */
    protected function setTimeRequest()
    {
        if (!isset($GLOBALS['timeStart'])) {
            throw new \Exception('Please add `$timeStart = microtime(true);` at the start of script');
        }
        $timeEnd = microtime(true);
        $time = (string)$timeEnd - $GLOBALS['timeStart'];
        $this->addParamForLog('time_request', $time);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getTable()
    {
        $config = Configuration::getConfig();
        if (empty($config['logs']['table'])) {
            throw new \Exception('Please add logs table in ini file');
        }
        $table = (string)$config['logs']['table'];
        return $table;
    }

    /**
     * @param $table
     * @return string
     * @throws \Exception
     */
    protected function getFields($table)
    {
        $columns = $this->getTableColumns($table);
        $paramsNames = array_keys($this->params);
        foreach ($paramsNames as $name) {
            if (!in_array($name, $columns)) {
                throw new \Exception("Have not column $name in table $table");
            }
        }
        return implode(', ', $paramsNames);
    }

    /**
     * @param $table
     * @return array
     * @throws \Exception
     */
    protected function getTableColumns($table)
    {
        $sql = "SHOW COLUMNS FROM $table";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll();
        if (empty($columns)) {
            throw new \Exception('Have not table');
        }
        return array_column($columns, 'Field');
    }
}