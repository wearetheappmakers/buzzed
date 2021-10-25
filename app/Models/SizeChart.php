<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Auth;


class SizeChart extends Model
{
    
    protected $table = 'sizechart';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

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

       
    }

    
}
