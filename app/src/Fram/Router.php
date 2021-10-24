<?php

namespace App\Fram;

use App\Controller\ErrorController;
use App\Fram\HTTPFoundation\HTTPRequest;

class Router
{
    private HTTPRequest $HTTPRequest;

    public function __construct()
    {
        $this->HTTPRequest = new HTTPRequest();
    }

    public function getController()
    {
        $xml = new \DOMDocument();
        $xml->load(__DIR__ . '/../../config/routes.xml');
        $routes = $xml->getElementsByTagName('route');

        $requestPath = $this->HTTPRequest->getQuery('p');

        isset($requestPath) ? $path = htmlspecialchars($requestPath) : $path = "/";

        foreach ($routes as $route) {
            if ($path === $route->getAttribute('path')) {
                $controllerClass = 'App\\Controller\\' . $route->getAttribute('controller');
                $action = $route->getAttribute('action');
                $params = [];
                if ($route->hasAttribute('params')) {
                    $keys = explode(',', $route->getAttribute('params'));
                    foreach ($keys as $key) {
                        $params[$key] = $this->HTTPRequest->getQuery($key);
                    }
                }
                return new $controllerClass($action, $params);
            }
        }

        return new ErrorController('noRoute');
    }
}