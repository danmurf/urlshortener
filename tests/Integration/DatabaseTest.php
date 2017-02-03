<?php
namespace App\Tests\Integration;

use App\Tests\TestCase;
use App\Library\Database;

//@todo Refactor tests / reduce boilerplate code

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

    /**
     * @test
     */
    public function can_cancel_transation() {
        //Insert someting into the database
        $data = ['http://example.com', 'abcd123'];
        $this->database->startTransaction();
        $this->database->query("INSERT INTO urls (url, path) VALUES (?, ?)", $data);

        //Check that it is there
        $this->database->query("SELECT * FROM urls WHERE url = ? AND path = ?", $data);
        $this->assertEquals(1, $this->database->affectedRows());

        //Now cancel the transaction
        $this->database->cancelTransaction();

        //Make sure it's no longer there
        $this->database->query("SELECT * FROM urls WHERE url = ? AND path = ?", $data);
        $this->assertEquals(0, $this->database->affectedRows());
    }
}
