<?php

ini_set('error_log', realpath('..') . DIRECTORY_SEPARATOR . 'logs'. DIRECTORY_SEPARATOR . 'error.log'); 

use \Phalcon\DI\FactoryDefault;
use \Phalcon\Mvc\Application;

try {
    
    define('APP_PATH', realpath('..') . DIRECTORY_SEPARATOR);
  
    $di = new \Phalcon\DI\FactoryDefault();

    require APP_PATH . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'services.php';
    
    $config = $di->getConfig();
    
    include APP_PATH . 'app/config/loader.php';
   
    $application = new Application($di);
    
    $di['app'] = $application;
    
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (Exception $e){
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
