<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class UserController
{
    public function __construct()
    {
        //conecta ao banco
        User::connect();
    }

    public function index($params): void //get
    {
        try {
            $users = User::getUser($params['user']);
            echo json_encode($users);
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
        User::destroy();
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