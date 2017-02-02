<?php
namespace App\Interfaces;

interface DatabaseInterface
{
    public function query($sql, $parameters = array());

    public function result();

    public function affectedRows();
}
