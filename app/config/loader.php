<?php
use Phalcon\Autoload\Loader;


$loader = new Loader();

$loader->setDirectories([
    APP_PATH . $config->application->pluginsDir,
    APP_PATH . "app/library/Base"
]);

$loader->register();

$loader->setNamespaces([
    'App\Controllers'                 => APP_PATH . $config->application->controllersDir,
    'App\Controllers\Api'             => APP_PATH . $config->application->apiControllersDir,
    'App'                             => APP_PATH . $config->application->libraryDir
]);

$loader->register();