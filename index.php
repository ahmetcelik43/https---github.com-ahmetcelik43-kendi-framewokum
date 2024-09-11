<?php
use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Business\Middlewares\AdminLoginMiddleware;
use App\Business\ServiceContainer;
use App\Configs\MigrationConfig;
use App\Controllers\Front\Home;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\LoginController;
use App\Controllers\MigrationController;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('session.sid_length', 128); // Session ID uzunluğunu artırın.
ini_set('session.sid_bits_per_character', 6); // Session ID'de kullanılacak karakter çeşitliliğini artırın.
ini_set('session.gc_maxlifetime', 3600); // 15 * 60 dk cinsinde
error_reporting(E_ERROR);
require_once "vendor/autoload.php";
require_once './src/Configs/Router.php';
defined('BASEPATH')  or define('BASEPATH', __DIR__);
defined('ENCRYPTION_KEY') or define('ENCRYPTION_KEY','cursorsoftahmetcelik');
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
$router->get('/', [Home::class,"index"])->dispatch(paramClasses:[$cacheManager]);
$router->get('/mig-create', [MigrationController::class,"create"])->dispatch();
$router->get('/login', [LoginController::class,"login"])->dispatch();
$router->get('/logout', [LoginController::class,"logout"])->filter(AdminLoginMiddleware::class)->dispatch(view:"403");
$router->get('/dashboard', [Dashboard::class, "save"])->filter(AdminLoginMiddleware::class)->dispatch(view:"403");
$router->get('/save/{id}/{id2}', [Dashboard::class,"save"])->dispatch();
