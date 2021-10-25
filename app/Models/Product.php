<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use App\Scopes\SellerScope;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Discount;
use App\Models\Size;
use App\Models\ProductImage;
use App\Models\ProductInventory;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Product extends Model
{
    use Sluggable;
    use SoftDeletes;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected static function boot()
	{
		parent::boot();
        // static::addGlobalScope(new DeleteScope);
        // static::addGlobalScope(new OrderScope);
        // static::addGlobalScope(new SellerScope);

        static::created(function($model)
        {
        // dd($model);
            $model->order = $model->id;
            $model->save();
        });

        // static::creating(function($model){
        //     if(Auth::guard('seller')->check()) {
        //         $model->seller_id = Auth::user()->id;
        //     }
        // });
    }
    
    // public function sellers()
    // {
    //     return $this->belongsTo('App\Seller', 'seller_id', 'id');
    // }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function brand()
    {
        return $this->belongsToMany(Brand::class, 'product_brand');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }
    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
        // return $this->belongsTo('App\Models\ProductImage');
    }
 
    public function product_inventories()
    {
        return $this->hasMany('App\Models\ProductInventory');
    }

    public function product_prices()
    {
        return $this->hasMany('App\Models\ProductPrice');
    }

    public function optionvalues()
    {
        return $this->belongsToMany(OptionValue::class, 'product_option_values');
    }
    public function product_lots()
    {
        return $this->hasMany('App\Models\ProductLot');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discounts');
    }
    public function title1()
    {
        return $this->hasOne('App\Models\Title1','product_id','id');
    }
    public function title2()
    {
        return $this->hasOne('App\Models\Title2','product_id','id');
    }
    public function title3()
    {
        return $this->hasOne('App\Models\Title3','product_id','id');
    }
    public function tag()
    {
        return $this->hasOne('App\Models\Tag','product_id','id');
    }
}
