<?php

function matchUriInRoutesArray($uri, $routes): array
{
    if (array_key_exists($uri, $routes)){
        return [$uri => $routes[$uri]];
    }
    return [];
}

function regexMatchArrayRoutes($uri, $routes): array
{
    return array_filter($routes, static function ($key) use ($uri){
        $regex = str_replace('/', '\/', ltrim($key,'/'));
        return preg_match("/^$regex$/", ltrim($uri,'/'));
    }, ARRAY_FILTER_USE_KEY);
}

/**
 * @param $uri
 * @param $matchedUri
 * @return array
 */
function params($uri , $matchedUri): array
{
    if (!empty($matchedUri)) {
        $matchedParams = array_keys($matchedUri)[0];
        return array_diff(
            $uri,
            explode("/", ltrim($matchedParams, '/'))
        );
    }
    return [];
}

function formatParams($uri, $params): array
{
    $paramsData = [];

    foreach ($params as $index => $param) {
        $paramsData[$uri[$index - 1]] = $param;
    }

    return $paramsData;
}

/**
 * @param string|null $uri
 * @throws Exception
 */
function router(?string $uri = null) :void
{
    if (is_null($uri)){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    $routes = ROUTES;
    $params = null;
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $matchedUri = matchUriInRoutesArray($uri, $routes[$requestMethod]);

    if (empty($matchedUri)){
        $matchedUri = regexMatchArrayRoutes($uri, $routes[$requestMethod]);
        $uri = explode("/", ltrim($uri, '/'));
        $params = params($uri, $matchedUri);
        $params = formatParams($uri, $params);
    }

    if (!empty($matchedUri)){
        //core
        loadController($matchedUri, $params);
        return;
    }

    throw new Exception(json_encode(['error'=>['message'=>"Uri não encontrada", 'code' => 404]]));
}