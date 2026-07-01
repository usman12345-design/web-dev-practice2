<?php

use App\Modals\Invoice;
use App\Modals\InvoiceItem;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Capsule\Manager as Capsule;
require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../eloquent.php';
//this is base query builder that is extended by eloquent query builder that is present below base query
//Copsule::connection()->query()->from('');
//Copsule::connection()->table()->where();
//$invoices=Capsule::table('invoices')->where(['status'=>InvoiceStatus::PAID]);
//var_dump($invoices);  return long std class
//exit;
$invoiceId=1;
Invoice::query()->where('id',$invoiceId)->update([
    'status'=>InvoiceStatus::PAID
]);
Invoice::query()->where('status',InvoiceStatus::PAID)->get()->each(function(Invoice $invoice){
   echo $invoice->id.','. $invoice->status->tostring().','.$invoice->created_at.PHP_EOL;
   $item =$invoice->items->first();
   $item->description = 'Foo Bar';
   $item->save();
   // $item->push(); for update both table by single command
});

/*Capsule::connection()->transaction(function(){
    $invoice = new Invoice();
    $invoice->amount = 1000;
    $invoice->invoice_number = 111;
    $invoice->status=\App\Enums\InvoiceStatus::PENDING ;
    $invoice->save();

    $items = [['item111', 111, 15],['item222', 222, 7.5],['item333', 333, 75]];
    foreach ($items as [$description, $quantity,$UnitPrice]) {
        $invoiceItem = new \App\Modals\InvoiceItem();
        $invoiceItem->description = $description;
        $invoiceItem->quantity = $quantity;
        $invoiceItem->unit_price = $UnitPrice;
        //$this->invoice_id=$invoice->id;
        $invoiceItem->invoice()->associate($invoice);
        $invoiceItem->save();
    }

});
*/