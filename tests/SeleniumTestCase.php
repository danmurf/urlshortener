<?php
namespace App\Tests;

require_once './vendor/autoload.php';
require_once './.env.php';

use App\Library\Database;

abstract class SeleniumTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected function tearDown() {
        $database = new Database;
        $database->query("TRUNCATE TABLE urls;");
    }
}
