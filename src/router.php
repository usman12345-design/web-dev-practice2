<?php
namespace App;

use App\Attributes\Route;
use ReflectionClass;

class router
{
    private array $routes = [];
    public function __construct(protected \Illuminate\Container\Container $container)
    {
    }

    public function registorRoutesFromControlerAttribute(array $controlers)
    {
        foreach ($controlers as $controler) {
            $reflectionControler = new ReflectionClass($controler);
            foreach ($reflectionControler->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->registor(
                        $route->method->value,
                        $route->path,
                        [$controler, $method->getName()]
                    );

                }
            }

        }
    }
    public function registor(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        $this->registor('get', $route, $action);
        return $this;
    }

    public function post(string $route, callable|array $action): self
    {
        $this->registor('post', $route, $action);
        return $this;
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;
        if (!$action) {
            throw new \App\Exceptions\RouteNotFoundException();
        }
        if (is_callable($action)) {
            return call_user_func($action);
        }
        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $classInstance = $this->container->get($class);

                if (method_exists($classInstance, $method)) {
                    echo call_user_func([$classInstance, $method]);
                    return;
                }
            }

            throw new \App\Exceptions\RouteNotFoundException('action not callable');
        }

        throw new \App\Exceptions\RouteNotFoundException();
    }
}