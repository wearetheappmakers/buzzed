<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Scopes\SellerScope;
use Auth;

class Color extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'colors';
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
        static::addGlobalScope(new DeleteScope);
        static::addGlobalScope(new OrderScope);
        // static::addGlobalScope(new SellerScope);

        static::created(function($model)
        {
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
}
