<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Controllers\UserController;

DEFINE('VIEW_PATH', __DIR__ . '/../Views');
DEFINE('STORAGE_PATH', __DIR__ . '/../storage/');
$container = new App\Container;
$Routers = new App\router($container);

$Routers->registorRoutesFromControlerAttribute([
    HomeController::class,
    InvoiceController::class,
    UserController::class
]);

(new App\myApp(
    $container,
    $Routers,
    ['uri' => $_SERVER['REQUEST_URI'], 'req' => $_SERVER['REQUEST_METHOD']]
))->boot()->run();


