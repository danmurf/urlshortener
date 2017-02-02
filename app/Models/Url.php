<?php
namespace App\Models;

class Url
{
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
        return APP_URL . '/' . $this->generatePath();
    }

    /**
     * Generates a random string for the shortened version of a URLc
     * @method generatePath
     * @return [type]       [description]
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
}
