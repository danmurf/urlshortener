<?php
namespace App\Tests\Integration;

use App\Tests\TestCase;
use App\Library\Database;

class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function can_run_a_query() {
        $database = new Database;
        $this->assertEquals(1, array_key_exists('version()', $database->query("select version();")->result()));
    }
}
