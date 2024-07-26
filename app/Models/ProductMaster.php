<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    use HasFactory;


     // Specify the table name
     protected $table = '_product_master';

     // Define the fillable attributes
     protected $fillable = [
         'Product_Name',
         'Rate',
         'Unit',
     ];
}
