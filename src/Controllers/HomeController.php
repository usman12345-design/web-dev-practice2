<?php
namespace App\Controllers;
use App\View;
use App\myApp;
use App\Container;
use App\Attributes\Route;
use App\Attributes\get;
use App\Attributes\put;
use App\Attributes\post;
class HomeController
{
    public function __construct()
    {
    }
    #[get(path: '/')]
    #[get('/home')]
    public function index(): View
    {
        return View::make('home/home');

        //automaticaly triger render method by __toString() by adding 
        // echo before return in resolve method in router.php
    }
    #[post('/')]
    #[get('/about')]
    public function about()
    {

    }
    #[put('/')]
    public function update()
    {

    }


}