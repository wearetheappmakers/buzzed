<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'product_prices';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    public function colors()
    {
        return $this->belongsTo('App\Models\Color', 'color_id', 'id');
    }

    public function sizes()
    {
        return $this->belongsTo('App\Models\Size', 'size_id', 'id');
    }

    public function currencies() {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'id');
    }
}
