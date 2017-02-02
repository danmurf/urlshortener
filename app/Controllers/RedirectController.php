<?php
namespace App\Controllers;

use App\Models\Url;

Class RedirectController
{
    public function redirect($shortenedUrl) {
        $url = new Url;
        $fullUrl = $url->fetchFullUrl($shortenedUrl);
        if (strlen($fullUrl) > 0) {
            echo 'redirecting to ' . $fullUrl;
        }
        else {
            echo 'page not found';
        }

    }
}
