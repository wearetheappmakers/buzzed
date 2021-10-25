<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;

class ImageOptimize extends Model
{
    protected $table = 'image_optimize';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function boot()
	{
		parent::boot();
        static::addGlobalScope(new DeleteScope);
        static::addGlobalScope(new OrderScope);

        static::created(function($model)
        {
            $model->order = $model->id;
            $model->save();
        });
	}
}
