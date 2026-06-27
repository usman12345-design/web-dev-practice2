<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Controllers\UserController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

DEFINE('VIEW_PATH', __DIR__ . '/../Views');
DEFINE('STORAGE_PATH', __DIR__ . '/../storage/');
$container = new App\Container;
$Routers = new App\router($container);

$Routers->registorRoutesFromControlerAttribute([
    HomeController::class,
    InvoiceController::class,
    UserController::class
]);
//echo '<pre>';
//print_r($Routers->routes());
//echo '<pre>';

(new App\myApp(
    $container,
    $Routers,
    ['uri' => $_SERVER['REQUEST_URI'], 'req' => $_SERVER['REQUEST_METHOD']],
    new App\Config($_ENV)
))->run();


