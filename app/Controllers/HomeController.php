<?php
namespace App\Controllers;

use App\Models\Url;

Class HomeController
{
    /**
     * Show the home page
     */
    public function index() {
        include '../resources/views/home.php';
    }

    /**
     * Process the form
     */
    public function store() {
        $url = new Url;

        //Validate the form
        if (!strlen($_POST['url']) > 0) {
            $error = "The URL field is required";
        }
        elseif (!$url->isValid($url->addScheme($_POST['url']))) {
            $error = "Please enter a valid URL";
        }
        else {
            //Form is valid - shorten the url
            if (!$url->isValid($_POST['url'])) {
                //Url is missing the scheme, so add it...
                $originalUrl = $url->addScheme($_POST['url']);
            }
            else {
                $originalUrl = $_POST['url'];
            }

            //Add to the database and get the new, shortened url...
            $shortenedUrl = $url->shorten($originalUrl);
        }

        include '../resources/views/home.php';
    }
}
