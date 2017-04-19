<?php

namespace lib;

/**
 * Class Controller
 * @package lib
 */
abstract class Controller
{
    const VIEW_FOLDER = 'views';

    /**
     * @return mixed
     */
    abstract public function init();

    /**
     * @param $file
     * @param array $params
     * @return string
     */
    protected function renderView($file, $params = [], $returnValue = false)
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($this->getViewPath() . $file);
        if ($returnValue) {
            return ob_get_clean();
        } else {
            echo ob_get_clean();;
        }
    }

    /**
     * @return string
     */
    protected function getViewPath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . static::VIEW_FOLDER . DIRECTORY_SEPARATOR;
    }

    /**
     * @return bool
     */
    protected function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    protected function getClientIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}