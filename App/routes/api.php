<?php

use App\Core\Router;

Router::add(['/user/[0-9]+' => 'UserController@index'], 'get');

Router::add(['/user/create' => 'UserController@create'], 'post');