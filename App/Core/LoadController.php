<?php


namespace App\Core;


use Exception;

class LoadController
{
    /**
     * @var string
     */
    private static string $controller_namespace = 'App\\Controllers\\';
    /**
     * @param array $matchedUri
     * @param array|null $params
     * @throws Exception
     */
    public static function loadController(array $matchedUri, ?array $params): void
    {
        [$controller, $method] = explode("@",array_values($matchedUri)[0]);
        $controllerWithNameSpace = self::$controller_namespace.$controller;

        if (!class_exists($controllerWithNameSpace)){
            throw new Exception("Controller $controller inexistente",404);
        }

        $controllerInstance = new $controllerWithNameSpace;
        if (!method_exists($controllerInstance, $method)){
            throw new Exception("Method $method não existe no controller $controller", 404);
        }
        $controllerInstance->$method($params);
    }
}