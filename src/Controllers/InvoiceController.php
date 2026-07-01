<?php
namespace App\Controllers;
use App\Enums\InvoiceStatus;
use App\Modals\Invoice;
use App\View;
use App\myApp;
use App\Container;
use App\Attributes\Route;
use Symfony\Component\Mailer\MailerInterface;

class InvoiceController
{
    public function __construct( $mailer)
    {

    }
    #[Route('/invoice')]
    public function index(): View
    {
        $invoices = Invoice::query()->where('status', InvoiceStatus::PAID)->get();
        // Pass the collection data variables straight into the template view context
        return View::make('invoice/invoice', [
            'invoices' => $invoices
        ]);
    }
}