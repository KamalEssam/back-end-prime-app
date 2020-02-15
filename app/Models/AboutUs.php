<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'ar_about_us',
        'en_about_us',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
