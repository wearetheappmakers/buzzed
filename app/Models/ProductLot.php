<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLot extends Model
{
   protected $table = 'product_lots';
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
}
