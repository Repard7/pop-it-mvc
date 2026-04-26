<?php

namespace Src;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use Src\Traits\SingletonTrait;

class Middleware
{
   use SingletonTrait;

   private RouteCollector $middlewareCollector;

   public function add($httpMethod, string $route, array $action): void
   {
       $this->middlewareCollector->addRoute($httpMethod, $route, $action);
   }

   public function group(string $prefix, callable $callback): void
   {
       $this->middlewareCollector->addGroup($prefix, $callback);
   }

   private function __construct()
   {
       $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
   }

   public function go(string $httpMethod, string $uri, Request $request): Request
   {
       $request = $this->runAppMiddlewares($request);
       return $this->runMiddlewares($httpMethod, $uri, $request);
   }

   private function runMiddlewares(string $httpMethod, string $uri, Request $request): Request
   {
        $routeMiddleware = app()->settings->app['routeMiddleware'] ?? [];
        
        foreach ($this->getMiddlewaresForRoute($httpMethod, $uri) as $middleware) {
            $args = explode(':', $middleware);
            if (isset($routeMiddleware[$args[0]])) {
                $handler = new $routeMiddleware[$args[0]];
                $result = $handler->handle($request, $args[1] ?? null);
                if ($result instanceof Request) {
                    $request = $result;
                }
            }
        }
        
        return $request;
   }

   private function runAppMiddlewares(Request $request): Request
   {
        $routeMiddleware = app()->settings->app['routeAppMiddleware'] ?? [];
        
        foreach ($routeMiddleware as $class) {
            $handler = new $class;
            $result = $handler->handle($request);
            if ($result instanceof Request) {
                $request = $result;
            }
        }
        
        return $request;
   }

   private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
   {
       $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
       $result = $dispatcherMiddleware->dispatch($httpMethod, $uri);
       return $result[1] ?? [];
   }
}