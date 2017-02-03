<?php
namespace App\Library;

use App\Library\Router;

/**
 * Pull in the environment variables
 */
require_once '../.env.php';

/**
 * Make sure errors aren't shown in production
 */
if (ENVIRONMENT == 'production') {
    error_reporting(0);
    //@todo Make sure errors are being logged elsewhere
}

/**
 * Fire up the router
 */
$router = new Router();

/**
 * Load the specified routes
 */
require_once '../app/Routes.php';

/**
 * Dispatch the routes to their specified tasks
 */
$router->dispatch();
