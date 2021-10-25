<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
// use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class ReviewRating extends Model
{
    use SoftDeletes;
    protected $table = 'reviewrating';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function boot()
	{
		parent::boot();
        static::addGlobalScope(new DeleteScope);
        // static::addGlobalScope(new OrderScope);
        // static::addGlobalScope(new SellerScope);

        // static::created(function($model)
        // {
        //     $model->order = $model->id;
        //     $model->save();
        // });

        // static::creating(function($model){
        //     if(Auth::guard('seller')->check()) {
        //         $model->seller_id = Auth::user()->id;
        //     }
        // });
    }

    public function customer()
    {
        return $this->belongsTo('App\User', "customer_id", "id");
    }

    public function vendor()
    {
        return $this->belongsTo('App\User', "vendor_id", "id");
    }

    // public function sellers()
    // {
    //     return $this->belongsTo('App\Seller', 'seller_id', 'id');
    // }
}
