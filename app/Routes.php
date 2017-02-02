<?php

$router->get('/', 'App\Controllers\HomeController', 'index');
$router->post('/', 'App\Controllers\HomeController', 'store');

$router->get('/{param}', 'App\Controllers\RedirectController', 'redirect');
