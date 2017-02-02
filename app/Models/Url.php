<?php
namespace App\Models;

class Url
{
    public function isValid($url) {
        return is_string(filter_var($url, FILTER_VALIDATE_URL)) ? true : false;
    }
}
