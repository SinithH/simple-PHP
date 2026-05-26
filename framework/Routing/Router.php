<?php

namespace Codex\Framework\Routing;

use Codex\Framework\Http\HttpException;
use Codex\Framework\Http\HttpMethodNotAllowedException;
use Codex\Framework\Http\Request;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        $routeInfo = $this->extractRouteInfo($request);

        [$handler, $vars] = $routeInfo;

        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $handler = [new $controller, $method];
        }

        return [$handler, $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        // Dispatch a URI, to obtain the route info
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                $e = new HttpMethodNotAllowedException("The allowed methods are $allowedMethods");
                $e->setStatusCode(405);
                throw $e;
            default:
                $e = new HttpException('Not Found');
                $e->setStatusCode(404);
                throw $e;
        }
    }
}