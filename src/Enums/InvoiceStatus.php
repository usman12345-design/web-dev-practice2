<?php

namespace App\Enums;

enum InvoiceStatus :int
{
case PENDING =0;
case VOID =1;
case PAID =2;

    public function toString(): string
    {
        return match($this) {
            self::PENDING => 'Pending Payment',
            self::PAID    => 'Paid & Settled',
            self::VOID    => 'Cancelled / Voided',
        };
    }
}
