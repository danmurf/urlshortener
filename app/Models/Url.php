<?php
namespace App\Models;

class Url
{
    public function isValid($url) {
        return is_string(filter_var($url, FILTER_VALIDATE_URL)) ? true : false;
    }

    public function shorten($url) {
        return APP_URL . '/' . $this->generatePath();
    }

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
