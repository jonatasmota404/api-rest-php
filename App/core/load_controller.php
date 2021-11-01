<?php

/**
 * @throws Exception
 */
function loadController(array $matchedUri, ?array $params){
    [$controller, $method] = explode("@",array_values($matchedUri)[0]);
    $controllerWithNameSpace = CONTROLLER_NAMESPACE.$controller;
    var_dump($controllerWithNameSpace);
    if (!class_exists($controllerWithNameSpace)){
        throw new Exception("Controller $controller inexistente");
    }

    $controllerInstance = new $controllerWithNameSpace;
    if (!method_exists($controllerInstance, $method)){
        throw new Exception("Method $method não existe no controller $controller");
    }
    $controllerInstance->$method($params);
}