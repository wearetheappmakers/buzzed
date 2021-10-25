<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;
    protected $table = 'order_statuses';
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
