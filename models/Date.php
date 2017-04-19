<?php

namespace models;

use lib\LogsInterface;

/**
 * Class Date
 * @package models
 */
class Date
{
    const REGEXP_PARSE_DATE = '#^([0-9./]+)([\+\-]{1})(\d+)$#';

    const DATE_FORMATS_INPUT = [
        "Y/m/d",
        "m.d.Y"
    ];

    const DATE_FORMAT_OUTPUT = 'd.m.Y';
    /**
     * @var
     */
    private $date;
    /**
     * @var
     */
    private $sign;
    /**
     * @var
     */
    private $number;
    /**
     * @var array
     */
    private $errors = [];
    /**
     * @var array
     */
    private $parsedDate = [];
    /**
     * @var
     */
    private $resultDate;

    /**
     * @param $dateData
     * @return null
     */
    public function getDate($dateData)
    {
        $dateData = trim($dateData);
        if ($this->parseString($dateData) === false) {
            return null;
        }
        if ($this->parseDateString() === false) {
            return null;
        }
        $this->addDays();
        return $this->resultDate;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getOriginalDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $dateData
     * @return bool
     */
    protected function parseString($dateData)
    {
        if (preg_match(static::REGEXP_PARSE_DATE, $dateData, $match)) {
            $this->date = $match[1];
            $this->sign = $match[2];
            $this->number = $match[3];
            return true;
        }
        $this->errors[] = 'Incorrect input format';
        return false;
    }

    /**
     * @return bool
     */
    protected function parseDateString()
    {
        $errors = [];
        foreach (static::DATE_FORMATS_INPUT as $format) {
            $this->parsedDate = \DateTime::createFromFormat($format, $this->date);
            if ($this->parsedDate === false) {
                $errors = array_merge($errors, $this->getErrorsFromDateTime($format));
                continue;
            }
            return true;
            break;
        }
        $this->errors = array_merge($this->errors, $errors);
        return false;
    }

    /**
     * @param $format
     * @return array
     */
    protected function getErrorsFromDateTime($format)
    {
        $errorsResult = [];
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0) {
            foreach ($errors['errors'] as $error) {
                $errorsResult[] = "Format $format: " . $error;
            }
        }
        return $errorsResult;
    }

    /**
     *
     */
    protected function addDays()
    {
        $this->parsedDate->modify("$this->sign$this->number day");
        $this->resultDate = $this->parsedDate->format(static::DATE_FORMAT_OUTPUT);
    }
}