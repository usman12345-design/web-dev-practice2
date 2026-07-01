<?php

namespace App\Modals;
use App\Modals\invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem  extends Model
{
public $timestamps = false;
public function invoice(): BelongsTo
{
 return $this->belongsTo(invoice::class);
}
}