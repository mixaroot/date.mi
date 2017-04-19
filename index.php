<?php
// it is for logs
$timeStart = microtime(true);

// Auto load classes
spl_autoload_register(function ($class) {
    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    include_once $file;
});

// Configuration
\lib\Configuration::set(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.ini');

// Route
(new \lib\Route([
    '/' => '\controllers\ConvertDateController'
]))->start();