<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColors extends Model
{
    protected $table = 'product_colors';

    protected $fillable = [
        'color_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
