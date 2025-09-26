<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    public $fillable = [
        'id',
        'title',
        'description',
        'status'
    ];

    protected $casts = [
        'status'      => 'boolean',
    ];

    function getImageUrlAttribute()
    {
        $img = [];
        $userImage = $this->getMedia('product');
        if($userImage){
            foreach ($userImage as $image) {
                $img[] =  $image->getUrl();
            }
            return $img;
        }
        return null;
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
