<?php

use App\Core\Router;

require_once "../vendor/autoload.php";


try {
    $uri = $_GET['uri'] ?? "/";

    Router::startRouting($uri);

} catch (Exception $e) {
    echo $e->getMessage();
}