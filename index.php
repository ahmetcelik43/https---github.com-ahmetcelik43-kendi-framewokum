<?php

use App\Configs\MigrationConfig;


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('session.sid_length', 128); // Session ID uzunluğunu artırın.
ini_set('session.sid_bits_per_character', 6); // Session ID'de kullanılacak karakter çeşitliliğini artırın.
ini_set('session.gc_maxlifetime', 3600); // 15 * 60 dk cinsinde
error_reporting(E_ERROR);
//phpinfo();
require_once "vendor/autoload.php";
require_once './src/Configs/Router.php';
defined('BASEPATH')  or define('BASEPATH', __DIR__);
defined('ENCRYPTION_KEY') or define('ENCRYPTION_KEY', 'cursorsoftahmetcelik4336');
if (!file_exists($pathupload = BASEPATH . "/public")) {
    mkdir($pathupload);
    mkdir($pathupload . "/upload");
}

$migrations = new MigrationConfig();
$migrations->control();
$router = new Router();
$router->routesInit();
