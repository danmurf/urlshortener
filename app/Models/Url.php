<?php
namespace App\Models;

use App\Library\Database;

class Url
{
    /**
     * Database connection instance
     * @var object
     */
    private $database;

    /**
     * The original, full length URL
     * @var string
     */
    private $originalUrl;

    /**
     * The path for the redirect
     * @var string
     */
    private $shortenedUrlPath;

    /**
     * Checks whether the specified URL is valid
     * @method isValid
     * @param  string  $url A URL
     * @return boolean
     */
    public function isValid($url) {
        return is_string(filter_var($url, FILTER_VALIDATE_URL)) ? true : false;
    }

    /**
     * Shortens and saves a URL
     * @method shorten
     * @param  string  $url A URL
     * @return string The shortened URL
     */
    public function shorten($url) {
        $this->originalUrl = $url;
        $this->shortenedUrlPath = $this->generatePath();
        if ($this->saveToDatabase()) {
            return $this->getShortenedUrl();
        }
        else {
            return false;
        }
    }

    /**
     * Generates a random string for the shortened version of a URLc
     * @method generatePath
     * @return string   A random path string
     */
    private function generatePath() {
        $path = '';

        $characters = array_merge(  range('A', 'Z'),
                                    range('a', 'z'),
                                    range('0', '9'));

        for ($i = 0; $i < SHORTENED_URL_PATH_LENGTH; $i++) {
            $path .= $characters[rand(0, sizeof($characters) - 1)];
        }

        return $path;
    }

    /**
     * Save the current state to the database
     * @method saveToDatabase
     * @return boolean
     */
    private function saveToDatabase() {
        if (strlen($this->originalUrl) > 0 &&
            strlen($this->shortenedUrlPath) > 0) {
                $this->database = new Database;
                $this->database->query("INSERT INTO urls (url, path) VALUES (?, ?);", [$this->originalUrl, $this->shortenedUrlPath]);
                return $this->database->affectedRows() == 1 ? : false;
            }
            else {
                return false;
            }
    }

    /**
     * Get the full, shortened URL
     * @method getShortenedUrl
     * @return string A short URL
     */
    public function getShortenedUrl() {
        if (strlen($this->shortenedUrlPath) > 0) {
            return APP_URL . '/' . $this->shortenedUrlPath;
        }
    }
}
