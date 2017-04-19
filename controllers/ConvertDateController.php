<?php

namespace controllers;

use lib\Controller;
use models\Date;
use components\Logs;
use components\DataBase;

/**
 * Class ConvertDateController
 * @package controllers
 */
class ConvertDateController extends Controller
{
    /**
     * Start controller
     */
    public function init()
    {
        if (!empty($_POST["date-post-button"])) {
            $model = new Date();
            $dateResult = $model->getDate($_POST["date"]);
            $errors = $model->getErrors();

            $logs = $this->getLogs();
            $logs->addParamForLog('ip', $this->getClientIp());
            $logs->addParamForLog('date', $model->getOriginalDate());
            $logs->addParamForLog('days', $model->getNumber());
            $logs->addParamForLog('date_result', $dateResult);
        }
        if ($this->isAjax()) {
            echo json_encode([
                'date' => isset($dateResult) ? $dateResult : '',
                'errors' => isset($errors) ? $errors : [],
            ]);
        } else {
            $this->renderView('dateForm.php', [
                'date' => isset($_POST["date"]) ? $_POST["date"] : '',
                'dateResult' => isset($dateResult) ? $dateResult : '',
                'errors' => isset($errors) ? $errors : [],
            ]);
        }
        if (isset($logs)) {
            $logs->write();
        }
    }

    /**
     * @return Logs
     */
    protected function getLogs()
    {
        return new Logs($this->getConnection());
    }

    /**
     * @return \PDO
     * @throws \Exception
     */
    protected function getConnection()
    {
        return DataBase::getConnection();
    }
}