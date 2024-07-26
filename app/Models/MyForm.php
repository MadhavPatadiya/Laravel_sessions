<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyForm extends Model
{
    use HasFactory;

    protected $table = '_myform';
    
    protected $fillable = [
        'customer',
        'product',
        'rate',
        'unit',
        'qty',
        'discount',
        'net_amount',
        'total_amount'
    ];
}
