<?php


namespace App\Core;


use Exception;

class Router
{
    private static ?string $uri;
    //private static array $routes = ROUTES;
    private static array $routes = [];
    private static string $requestMethod;

    private static function matchUriInRoutesArray() : array
    {
        if (array_key_exists(self::$uri, self::$routes)){
            return [self::$uri => self::$routes];
        }
        return [];
    }

    /**
     * verifica se a chave(rota) do array de rotas é compatível com a uri, utilizando regex
     * @return array
     */
    private static function pregMatchRoutesInArray(): array
    {
        return array_filter(self::$routes[self::$requestMethod], static function ($key){
            $regex = str_replace('/', '\/', ltrim($key,'/'));
            return preg_match("/^$regex$/", ltrim(self::$uri,'/'));
        }, ARRAY_FILTER_USE_KEY);
    }

    private static function getParams(array $matchedUri): array
    {
        if (!empty($matchedUri)) {
            $matchedParams = array_key_first($matchedUri);
            $argvUri = explode("/", ltrim(self::$uri, '/'));
            $argvMathedUri = explode("/", ltrim($matchedParams, '/'));
            $paramsData = [];

            //retorna a posição e o valor que difere
            $params = array_diff(
                $argvUri,
                $argvMathedUri
            );
            foreach ($params as $index => $param) {
                $paramsData[$argvUri[$index - 1]] = $param;
            }

            return $paramsData;

        }
        return [];
    }

    /**
     * @param string $requestMethod
     * @param array $controllerRoute
     * @example $controllerRoute = ['/user/[0-9]+' => 'UserController@index']
     * $controllerRoute key é a rota.
     * $controllerRoute value é separado em controller e método por @ respetivamente
     */
    public static function add(array $controllerRoute, string $requestMethod): void
    {
        self::$routes[strtolower($requestMethod)] = $controllerRoute;
    }
    /**
     * @throws Exception
     */
    public static function startRouting(?string $uri = null): void
    {
        self::$uri = $uri;

        self::$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $params = null;

        if (is_null(self::$uri)){
            self::$uri = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        $matchedUri = self::matchUriInRoutesArray();

        if (empty($matchedUri)){
            $matchedUri = self::pregMatchRoutesInArray();
            $params = self::getParams($matchedUri);
        }

        if (!empty($matchedUri)){
            LoadController::loadController($matchedUri, $params);
            return;
        }

        throw new Exception("Uri não encontrada", 404);
    }
}