<?php
namespace App\Controllers;

use App\Models\Url;

Class RedirectController
{
    public function redirect($shortenedUrl) {
        $url = new Url;
        $fullUrl = $url->fetchFullUrl($shortenedUrl);
        if (strlen($fullUrl) > 0) {
            header('Location:' . $fullUrl);
        }
        else {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            include '../resources/views/404.php';
        }

    }
}
