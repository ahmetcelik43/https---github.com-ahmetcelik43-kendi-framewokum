<?php
use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Business\Middlewares\AdminLoginMiddleware;
use App\Business\ServiceContainer;
use App\Configs\MigrationConfig;
use App\Controllers\Home;
use App\Controllers\Admin\Dashboard;
use App\Controllers\MigrationController;

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
$migrations = new MigrationConfig();
$migrations->control();
$router = new Router();
$router->get('/', ["class"=>Home::class,"method"=>"index"])->dispatch(paramClasses:[$cacheManager]);
$router->get('/mig-create', ["class"=>MigrationController::class,"index"])->dispatch();
$router->get('/dashboard', ["class"=>Dashboard::class, "method"=>'save'])->filter(new AdminLoginMiddleware())->dispatch(view:"403");
$router->get('/save/{id}', ["class"=>Dashboard::class, "method"=>'save'])->dispatch();
