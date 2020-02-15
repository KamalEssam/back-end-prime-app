<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'en_title',
        'ar_title',
        'en_message',
        'ar_message',
        'product_id',
        'is_read',
    ];
}
