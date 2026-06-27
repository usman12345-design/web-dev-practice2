<?php
namespace App\Controllers;
use App\View;
use App\myApp;
use App\Container;
use App\Attributes\Route;

class InvoiceController
{
    public function __construct()
    {
    }
    #[Route('/invoice')]
    public function index(): View
    {
        return View::make('invoice/invoice');
    }


}