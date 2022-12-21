<?php

return [
    'application' => [
        'controllersDir'    => 'app' . DIRECTORY_SEPARATOR. 'controllers' . DIRECTORY_SEPARATOR,
        'apiControllersDir' => 'app' . DIRECTORY_SEPARATOR. 'controllers' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR,
        'libraryDir'        => 'app' . DIRECTORY_SEPARATOR. 'library'     . DIRECTORY_SEPARATOR,
        'viewsDir'          => 'app' . DIRECTORY_SEPARATOR. 'views'       . DIRECTORY_SEPARATOR,
        'cacheDir'          => 'app' . DIRECTORY_SEPARATOR. 'cache'       . DIRECTORY_SEPARATOR,
        'baseUri'           => '/',
    ],
    'jwt' => [
      'signer' => 'my-secret-string'
    ]
];