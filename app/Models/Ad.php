<?php

namespace App\Models;

use App\Http\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ads';

    protected $fillable = [
        'image',
        'product_id',
        'priority'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('/assets/images/ads/' . $value);
        }
        return asset('/assets/images/ads/default.png');
    }

    public function setImageAttribute($image)
    {
        if ($image == 'avatar.png' || $image == 'default.png') {
            $this->attributes['image'] = $image;
        } else if ($image) {
            $image_name = FileTrait::uploadFile($image, '/assets/images/ads');

            if ($image_name['status'] == true) {
                $this->attributes['image'] = $image_name['image'];
            } else {
                // you can set default image or throw an error
                $this->attributes['image'] = 'avatar.png';
            }
        }
    }
}
