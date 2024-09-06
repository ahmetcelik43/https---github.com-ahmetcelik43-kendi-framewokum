<?php

class Router
{
    private $routes = [];

    // GET metodu ile yönlendirme
    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    // POST metodu ile yönlendirme
    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    // Yönlendirme ekleme fonksiyonu
    private function addRoute($method, $path, $callback)
    {
        $this->routes[] = ['method' => $method, 'path' => $path, 'callback' => $callback];
    }

    // İsteği işleyip uygun yolu bulma
    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri=str_replace(["/doc2"],"",$requestUri);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($this->convertToRegex($route['path']), $requestUri, $matches)) {
                array_shift($matches); // İlk eleman tüm eşleşmeyi içerir, onu kaldırıyoruz
                return call_user_func_array($route['callback'], $matches);
            }
        }

        // 404 Durum Kodu ve Sayfa
        http_response_code(404);
        echo '404 - Page not found';
    }

    // URL parametrelerini işlemek için regex dönüştürme
    private function convertToRegex($path)
    {
        return "#^" . preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', $path) . "$#";
    }
}
