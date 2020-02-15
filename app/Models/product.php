<?php

namespace App\Models;


use App\Http\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'ar_name',
        'en_name',
        'ar_desc',
        'en_desc',
        'image',
        'unique_id',
        'price',
        'category_id',
    ];

    public function getImageAttribute($value)
    {
        return asset('/assets/images/product/' . $value);
    }

    public function setImageAttribute($image)
    {
        if ($image == 'avatar.png' || $image == 'default.png') {
            $this->attributes['image'] = $image;
        } else if ($image) {
            $image_name = FileTrait::uploadFile($image, '/assets/images/product');

            if ($image_name['status'] == true) {
                $this->attributes['image'] = $image_name['image'];
            } else {
                // you can set default image or throw an error
                $this->attributes['image'] = 'avatar.png';
            }
        }
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity');
    }
}
