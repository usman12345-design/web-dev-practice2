<?php
/*now using laraval container
namespace App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;

class Container implements ContainerInterface
{
    private array $enteries = [];
    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->enteries[$id];
            if (is_callable($entry)) {
                return $entry($this);
            }
            $id = $entry;
        }
        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->enteries[$id]);
    }

    public function set(string $id, callable|string $concrete)
    {
        $this->enteries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
        //1.we have to inspect the class that we want to get through container
        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException('class"' . $id . '" is not instantiable');
        }
        //2. if it has __construct method then we have to inspect it
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return new $id;
        }
        //3.then inspect the parameter of a class (dependencies)
        $parameters = $constructor->getParameters();
        if (!$parameters) {
            return new $id;
        }
        //4.if constructor parameter are classes then we  have to try to resolve them using container
        $dependencies = array_map(function (\ReflectionParameter $param) use ($id) {
            $name = $param->getName();
            $type = $param->getType();
            if (!$type) {
                throw new ContainerException('class"' . $id . '" misssing type hint ');
            }
            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException('class"' . $id . '" is having param of union type');
            }
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }
            throw new ContainerException('class' . $id . ' has invalid params');
        }, $parameters);
        return $reflectionClass->newInstanceArgs($dependencies); //which is equivalent to:new invoiceService(new emailService());
    }
}*/