<?php
namespace App\Controllers;

Class RedirectController
{
    public function redirect($shortenedUrl) {
        echo 'redirecting for ' . $shortenedUrl;
    }
}
