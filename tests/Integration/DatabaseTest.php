<?php
namespace App\Tests\Integration;

use App\Tests\TestCase;
use App\Library\Database;

class DatabaseTest extends TestCase
{
    private $database;

    protected function setUp() {
        $this->database = new Database;
    }

    /**
     * @test
     */
    public function can_run_a_query() {
        $this->assertEquals(1, array_key_exists('version()', $this->database->query("select version();")->result()));
    }

    /**
     * @test
     */
    public function can_insert_into_database() {
        $originalUrl = 'http://example.com';
        $shortenedUrlPath = 'abcd123';

        $this->database->query("INSERT INTO urls (url, path) VALUES (?, ?)", [$originalUrl, $shortenedUrlPath]);
        $this->assertEquals(1, $this->database->affectedRows());

        $this->database->query("SELECT * FROM urls WHERE url = '".$originalUrl."' AND path = '".$shortenedUrlPath."'");
        $this->assertEquals(1, $this->database->affectedRows());
    }
}
