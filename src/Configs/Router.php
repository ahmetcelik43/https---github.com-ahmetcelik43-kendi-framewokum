<?php

use App\Business\Cache\ICache;
use App\Business\Middlewares\AdminLoginMiddleware;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\LoginController;
use App\Controllers\Front\Home;
use App\Controllers\ImageController;
use App\Controllers\MigrationController;

class Router
{
    private $routes = [];
    private $filter = null;
    private $isNotFound = true;
    private $searchname = null;
    public  $foundedUrl = null;
    public $routeAll = [];
    public $providers = [];

    function __destruct()
    {
        if ($this->isNotFound == true and !$this->searchname) {
            return view("Errors/404");
        }
    }
    public function __construct(ICache $cacheManager = null)
    {
        $this->providers["cacheManager"] = $cacheManager;
    }

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
        return $this;
    }
    public function saltRoutes($name = null)
    {
        $routeAll = [
            ["path" => "/", "class" => Home::class, "action" => "index", "paramClasses" => [$this->providers["cacheManager"]], "name" => "home.index"],
            ["path" => "/mig-create", "class" => MigrationController::class, "action" => "paramClasses", "name" => "migrate"],
            ["path" => "/login", "class" => LoginController::class, "action" => "login", "name" => "login.index"],
            ["path" => "/logout", "class" => LoginController::class, "action" => "logout", "name" => "login.index", "filter" => AdminLoginMiddleware::class, "view" => "403"],
            ["path" => "/image", "class" => ImageController::class, "action" => "index", "name" => "image"],
        ];
       
        if ($name) {
            $this->searchname = $name;
            foreach ($routeAll as $item) {
                if ($item["name"] == $name) {
                    return $item["path"];
                }
            }
        }
        return $routeAll;
    }
    public function routesInit($name = "")
    {
        foreach ($this->saltRoutes() as $route) {
            if(isset($route["method"])){
                $this->{$route["method"]}($route["path"], [$route["class"], $route["action"]])
                ->filter(($route["filter"] ?? null))
                ->dispatch(view: $route["view"], paramClasses: ($route["paramClasses"] ?? []));
            }else{
                $this->get($route["path"], [$route["class"], $route["action"]])
                ->filter(($route["filter"] ?? null))
                ->dispatch(view: $route["view"], paramClasses: ($route["paramClasses"] ?? []));
            }
            
        }
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
        if ($filterClass == null) {
            return $this;
        }
        $this->filter = new $filterClass();
        return $this;
    }
    // Yönlendirme ekleme fonksiyonu
    private function addRoute($method, $path, $callback)
    {
        $this->routes = ['method' => $method, 'path' => $path, 'callback' => $callback];
    }

    // İsteği işleyip uygun yolu bulma
    public function dispatch(string $view = null, $paramClasses = [], string $name = null)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace(config('Settings', 'base_path'), "", $requestUri);
        // Filtreleri uygula
        $pattern = "#^/public/upload/([a-zA-Z0-9_\-\.]+)(?:\?.*)?$#";

        if (preg_match($pattern, $requestUri, $matches)) {
            $this->isNotFound = false;
            // Dosya adı
            $filename = $matches[1];
            array_shift($matches);
            // İlgili handler'ı çağır
            (new ImageController())->index($filename);
        }
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
