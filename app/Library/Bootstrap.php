<?php
namespace App\Library;

use App\Library\Router;

/**
 * Pull in the environment variables
 */
require_once '../.env.php';

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
