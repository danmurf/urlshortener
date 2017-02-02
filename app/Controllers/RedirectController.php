<?php
namespace App\Controllers;

use App\Models\Url;

Class RedirectController
{
    public function redirect($shortenedUrl) {
        $url = new Url;
        echo 'redirecting to ' . $url->fetchFullUrl($shortenedUrl);
    }
}
