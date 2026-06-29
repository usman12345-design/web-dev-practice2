<?php

namespace App\Enums;

enum InvoiceStatus :int
{
case PENDING =0;
case PROCESSING =1;
case PAID =2;
}