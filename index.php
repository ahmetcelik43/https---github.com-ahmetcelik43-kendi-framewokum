<?php
// doctrine-migrations generate --configuration=../../migrations.php
// doctrine-migrations status --configuration=../../migrations.php --db-configuration=../../migrations-db.php
// doctrine-migrations migrate --configuration=../../migrations.php --db-configuration=../../migrations-db.php
use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Business\Middlewares\AdminLoginMiddleware;
use App\Business\ServiceContainer;
use App\Configs\Migrations;
use App\Controllers\Home;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Database;
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
$router = new Router();
$router->get('/', [(new Home($cacheManager)), 'index'])->dispatch();
$router->get('/mig-create', [(new MigrationController()), 'create'])->dispatch();
$router->get('/delete', [(new Home($cacheManager)), 'delete'])->dispatch();
$router->get('/dashboard', [(new Dashboard()), 'save'])->filter(new AdminLoginMiddleware())->dispatch("403");
$router->get('/save/{id}', [(new Dashboard()), 'save'])->dispatch();
$router->get('/save', [(new Dashboard()), 'save'])->dispatch();
$router->post('/dashboard/insertBatch', [(new Dashboard()), 'insertBatch'])->dispatch();
$router->post('/dashboard/updateBatch', [(new Dashboard()), 'updateBatch'])->dispatch();

$migrations = new Migrations();
$migrations->control();


