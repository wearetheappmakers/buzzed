<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrderScope;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function boot()
	{
		parent::boot();
        static::addGlobalScope(new OrderScope);

        static::created(function($model)
        {
            $model->order = $model->id;
            $model->save();
        });
    }
    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
        // return $this->belongsToMany('App\Models\ProductImage');
    }

    public function colors()
    {
        return $this->belongsTo('App\Models\Color', 'color_id', 'id');
        // return $this->belongsToMany('App\Models\ProductImage');
    }

    public function getImageAttribute()
    {
        if (isset($this->attributes['image']) && $this->attributes['image']) {
            return env('APP_URL').'/storage/uploads/product/Medium/'. $this->attributes['image'];
        }
        return '';
    }
}
