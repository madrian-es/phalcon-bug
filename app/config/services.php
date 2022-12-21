<?php
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Stream as MetaData;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Flash\Session as Flash;
use Phalcon\Session\Manager;
use Phalcon\Session\Bag;
use Phalcon\Html\Escaper;
use Phalcon\Config\Adapter\Php;
use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream as LoggerStream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Db\Dialect\MysqlExtended;
use Phalcon\Tag;

/**
 * Register the global configuration as config
*/
$di->setShared('config', function () {

    $config = new Php(APP_PATH . 'app/config/config.php');
    return $config;
});

$di->set('dispatcher', function() {
    $eventsManager = new EventsManager;
    
    $dispatcher = new Dispatcher;
    $dispatcher->setEventsManager($eventsManager);
    $dispatcher->setDefaultNamespace('App\Controllers');

    return $dispatcher;
});

$di->set('router', function () {
    $config = $this->get('config');

    return require APP_PATH . 'app/config/routes.php';
});

$di->set('url', function() {
    $config = $this->getConfig();

    $url = new UrlProvider();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

$di->set('view', function(){
    $config = $this->getConfig();

    $view = new View();

    $view->setViewsDir(APP_PATH . $config->application->viewsDir);
 
    $view->registerEngines([
        ".phtml" => function($view) {
           
            $config = $this->getConfig();
            $volt   = new VoltEngine($view, $this);
            $volt->setOptions([
                'path' => APP_PATH . $config->application->cacheDir . 'volt' . DIRECTORY_SEPARATOR
            ]);

            return $volt;
        }
    ]);

    return $view;
}, true);
