<?php

namespace App\Controllers;

class UserController
{
    public function index($params) //get
    {
        var_dump($params);
    }

    public function create() //post
    {
        var_dump($_POST);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}