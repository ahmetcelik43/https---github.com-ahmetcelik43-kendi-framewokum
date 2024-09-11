<?php

class Router
{
    private $routes = [];
    private $filter = null;
    private $isNotFound = true;

    function __destruct()
    {
        if ($this->isNotFound == true) {
            return view("Errors/404");
        }
    }

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
        return $this;
    }

    // POST metodu ile yönlendirme
    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
        return $this;
    }

    // Filtreleri uygula
    private function applyFilters()
    {
        if ($this->filter and !$this->filter->before()) {
            return false;
        }
        return true;
    }

    // Filtre ekleme
    public function filter($filterClass)
    {
        $this->filter = new $filterClass();
        return $this;
    }
    // Yönlendirme ekleme fonksiyonu
    private function addRoute($method, $path, $callback)
    {
        $this->routes = ['method' => $method, 'path' => $path, 'callback' => $callback];
    }

    // İsteği işleyip uygun yolu bulma
    public function dispatch(string $view = "", $paramClasses = [])
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace(config('Settings', 'base_path'), "", $requestUri);
        // Filtreleri uygula

        if ($this->routes['method'] === $requestMethod && preg_match($this->convertToRegex($this->routes['path']), $requestUri, $matches)) {
            $this->isNotFound = false;
            if (!$this->applyFilters()) {
                header("HTTP/1.1 $view");
                view("Errors/$view");
                $this->clearRoutes();
            }
            $class = $this->routes['callback'];
            array_shift($matches);
            (new $class[0](...$paramClasses))->{$class[1]}(...$matches);
            $this->clearRoutes();
        }
        $this->clearRoutes();
    }

    // URL parametrelerini işlemek için regex dönüştürme
    private function convertToRegex($path)
    {
        return "#^" . preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', $path) . "$#";
    }

    private function clearRoutes()
    {
        $this->routes = [];
        $this->filter = null;
        return;
    }
}
