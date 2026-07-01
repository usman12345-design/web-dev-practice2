<?php

namespace App\Modals;
use App\Entity\invoiceItems;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
     Const UPDATED_AT = null;
     protected $casts = [
         'created_at' => 'datetime',
         'status' => InvoiceStatus::class,
     ];
     public function items():HasMany
     {
         return $this->hasMany(invoiceItem::class);
     }
}