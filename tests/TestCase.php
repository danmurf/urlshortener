<?php
namespace App\Tests;

require_once './vendor/autoload.php';
require_once './.env.testing.php';

use App\Library\Database;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function tearDown() {
        $database = new Database;
        $database->query("TRUNCATE TABLE urls;");
    }
}
