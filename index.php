<?php

use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Business\ServiceContainer;
use App\Controllers\Home;
use App\Controllers\Admin\Dashboard;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);
require_once "vendor/autoload.php";
require_once './src/Configs/Router.php';
defined('BASEPATH')  or define('BASEPATH', __DIR__);

$container = new ServiceContainer();
$container->set(ICache::class, function () {
    static $instance = null;
    if ($instance === null) {
        $instance = new FileSystemCache();
    }
    return $instance;
});
$cacheManager = $container->get(ICache::class);
$router = new Router();
$router->get('/', [(new Home($cacheManager)), 'index']);
$router->get('/dashboard', [(new Dashboard()), 'save']);
$router->get('/save/{id}', [(new Dashboard()), 'save']);
$router->post('/dashboard/insertBatch', [(new Dashboard()), 'insertBatch']);
$router->post('/dashboard/updateBatch', [(new Dashboard()), 'updateBatch']);
$router->dispatch();
