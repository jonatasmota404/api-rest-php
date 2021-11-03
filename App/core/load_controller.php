<?php

/**
 * @param array $matchedUri
 * @param array|null $params
 * @throws Exception
 */
function loadController(array $matchedUri, ?array $params){
    [$controller, $method] = explode("@",array_values($matchedUri)[0]);
    $controllerWithNameSpace = CONTROLLER_NAMESPACE.$controller;

    if (!class_exists($controllerWithNameSpace)){
        throw new Exception(json_encode(['error'=>['message'=>"Controller $controller inexistente", 'code' => 404]]));
    }

    $controllerInstance = new $controllerWithNameSpace;
    if (!method_exists($controllerInstance, $method)){
        throw new Exception(json_encode(['error'=>['message'=>"Method $method não existe no controller $controller", 'code' => 404]]));
    }
    $controllerInstance->$method($params);
}