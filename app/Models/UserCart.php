<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_carts';
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
}
