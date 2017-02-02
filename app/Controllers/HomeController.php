<?php
namespace App\Controllers;

use App\Models\Url;

Class HomeController
{
    public function index() {
        include '../resources/views/home.php';
    }

    public function store() {
        $url = new Url;

        if (!strlen($_POST['url']) > 0) {
            $error = "The URL field is required";
        }
        elseif (!$url->isValid($url->addScheme($_POST['url']))) {
            $error = "Please enter a valid URL";
        }
        else {
            $shortenedUrl = $url->shorten($_POST['url']);
        }
        include '../resources/views/home.php';
    }
}
