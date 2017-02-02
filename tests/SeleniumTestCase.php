<?php
namespace App\Tests;

require_once './vendor/autoload.php';
require_once './.env.testing.php';

abstract class SeleniumTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{
}
