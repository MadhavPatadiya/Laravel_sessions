<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;
    protected $table = 'invoice_detail';
    protected $fillable = [
        'customer',
        'product',
        'rate',
        'unit',
        'qty',
        'discount',
        'netamount',
        'totalamount',

    ];
}
