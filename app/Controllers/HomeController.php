<?php
namespace App\Controllers;

Class HomeController
{
    public function index() {
        include '../resources/views/home.php';
    }

    public function store() {
        echo 'storing';
    }
}
