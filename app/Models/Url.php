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

    public function __construct() {
        $this->database = new Database;
    }

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

        if (!$this->loadShortenedUrl($url)) {
            $this->shortenedUrlPath = $this->generatePath();
            $this->saveToDatabase();
        }

        return $this->getShortenedUrl();
    }

    /**
     * Load the shortened URL from the database, given the full url
     * @method loadShortenedUrl
     * @param  string           $fullurl The full URL
     * @return string|boolean
     */
    private function loadShortenedUrl($fullurl) {
        $this->database->query("SELECT path FROM urls WHERE url = ?", [$fullurl]);
        if ($this->database->affectedRows() > 0) {
            $this->shortenedUrlPath = $this->database->result()[0];
            return $this->getShortenedUrl();
        }
        else {
            //URL doesn't exist in the database
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

    /**
     * Translate a shortened URL back into a full URL
     * @method fetchFullUrl
     * @param string            $shortUrl A shortened URL
     * @return string|boolean   The full URL or false if it doesn't exist
     */
    public function fetchFullUrl($shortUrl) {
        $this->database->query("SELECT url FROM urls WHERE path = ?;", [$this->getPathFromShortUrl($shortUrl)]);
        if ($this->database->affectedRows() > 0) {
            return $this->database->result()[0];
        }
        else {
            return false;
        }
    }

    /**
     * Extract the path portion of a short URL
     * @method getPathFromShortUrl
     * @param  string             $shortUrl A shortened URL
     * @return string
     */
    private function getPathFromShortUrl($shortUrl) {
        $path = parse_url($shortUrl, PHP_URL_PATH);
        //Remove the preceeding slash and return
        return ltrim($path, '/');
    }

    /**
     * Make sure a URL has http:// or equivalent
     * @method addScheme
     * @param  string   $url A URL with or without a scheme
     */
    public function addScheme($url) {
        if ($parts = parse_url($url)) {
           if (!isset($parts["scheme"]))
           {
               $url = 'http://' . $url;
           }
        }
        return $url;
    }
}
