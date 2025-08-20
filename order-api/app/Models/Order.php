<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'item_name', 'price', 'status'
    ];

    // protected $casts = [
    //     'price' => 'decimal:2',
    // ];
}
