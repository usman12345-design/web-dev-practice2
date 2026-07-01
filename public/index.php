<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Controllers\UserController;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Database\Query\Builder;

// ADD THESE LINES TO LOAD YOUR ENV VARIABLES:
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

DEFINE('VIEW_PATH', __DIR__ . '/../Views');
DEFINE('STORAGE_PATH', __DIR__ . '/../storage/');
//$container = new App\Container;
$container = new \Illuminate\Container\Container;
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

