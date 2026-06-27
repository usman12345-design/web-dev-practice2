<?php
namespace App\Controllers;

use App\View;
use App\Attributes\get;
use App\Attributes\post;

class UserController
{
    public function __construct()
    {
    }
    #[get('/users/create')]
    public function create(): View
    {
        return View::make('Users/registor');
    }

    #[post('/users')]
    public function registor(): View
    {
        return View::make('Users/registor');
    }


}