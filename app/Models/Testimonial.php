<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Auth;


class Testimonial extends Model
{
    
    protected $table = 'testimonial';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ['image_full_path'];

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

    public function getImageFullPathAttribute()
    {
        if(empty($this->media)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/testimonial/Big/'.$this->media;
    }

}
