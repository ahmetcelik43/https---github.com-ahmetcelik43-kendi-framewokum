<?php

namespace App\Business;

use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Entity\Repository\BaseCrudRepository;
use App\Entity\Repository\BaseUserRepository;
use App\Entity\Repository\Eloquent\UserRepository;
use App\Entity\Repository\Eloquent\CrudEloquentRepository;
use App\Entity\Repository\Eloquent\UserEloquentRepository;

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

    function services()
    {
        // cache continer
        $this->set(ICache::class, function () {
            static $instance = null;
            if ($instance === null) {
                $instance = new FileSystemCache();
            }
            return $instance;
        });

        $this->set(BaseUserRepository::class, function () {
            static $instance = null;
            if ($instance === null) {
                $instance = new UserEloquentRepository();
            }
            return $instance;
        });

        $this->set(BaseCrudRepository::class, function () {
            static $instance = null;
            if ($instance === null) {
                $instance = new CrudEloquentRepository();
            }
            return $instance;
        });

        $providers["cacheManager"] = $this->get(ICache::class);
        $providers["userManager"] = $this->get(BaseUserRepository::class);
        $providers["crudManager"] = $this->get(BaseCrudRepository::class);
        return $providers;
    }
}
