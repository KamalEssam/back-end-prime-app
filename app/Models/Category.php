<?php

namespace App\Models;


use App\Http\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = [
        'ar_name',
        'en_name',
        'image',
        'is_visible',
        'order'
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('/assets/images/category/' . $value);
        }
        return asset('/assets/images/category/default.png');
    }

    public function setImageAttribute($image)
    {
        if ($image == 'avatar.png' || $image == 'default.png') {
            $this->attributes['image'] = $image;
        } else {
            if ($image) {
                $image_name = FileTrait::uploadFile($image, '/assets/images/category');

                if ($image_name['status'] == true) {
                    $this->attributes['image'] = $image_name['image'];
                } else {
                    // you can set default image or throw an error
                    $this->attributes['image'] = 'avatar.png';
                }
            }
        }
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
