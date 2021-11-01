<?php
require_once "../vendor/autoload.php";


try {
    $uri = $_GET['uri'];

    if (isset($uri)){
        router($uri);
    }

} catch (Exception $e) {
    echo $e->getMessage();
}