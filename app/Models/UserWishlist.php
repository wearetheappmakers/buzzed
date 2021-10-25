<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class UserWishlist extends Model
{
    protected $table = 'user_wishlists';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function colors()
    {
        return $this->hasOne('App\Models\Color',  'id', 'color_id');
    }

    public function sizes()
    {
        return $this->hasOne('App\Models\Size',  'id', 'size_id');
    }

    public function products()
    {
        return $this->hasOne('App\Models\Product',  'id', 'product_id');
    }

    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function product_prices()
    {
        return $this->hasMany('App\Models\ProductPrice');
    }
}
