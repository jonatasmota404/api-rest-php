<?php
require_once "../vendor/autoload.php";


try {
    $uri = $_GET['uri']??"/";

    if (isset($uri)){
        router($uri);
    }

} catch (Exception $e) {
    echo json_encode(['error'=>['message'=>$e->getMessage(), 'code' => 404]]);
}