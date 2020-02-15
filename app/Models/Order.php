<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'status',
        'name',
        'email',
        'mobile',
        'is_sale',
        'is_approved'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(ProductColors::class, 'order_product', 'order_id', 'variant_id')
            ->withTimestamps();
    }
}
