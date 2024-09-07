<?php
namespace App\Business;

class ServiceContainer
{
    protected $services = [];
    protected $sharedInstances = [];

    public function set($name, callable $resolver)
    {
        $this->services[$name] = $resolver;
    }

    public function get($name)
    {
        if (isset($this->sharedInstances[$name])) {
            return $this->sharedInstances[$name];
        }

        if (!isset($this->services[$name])) {
            return $this->resolve($name);
        }

        $service = $this->services[$name]($this);
        $this->sharedInstances[$name] = $service;

        return $service;
    }

    protected function resolve($name)
    {
        $reflection = new \ReflectionClass($name);

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $name;
        }

        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            $dependency = $param->getClass();
            if ($dependency) {
                $dependencies[] = $this->get($dependency->name);
            } else {
                throw new \Exception("Can't resolve dependency");
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}