<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;

class TopDeals extends Model
{
    protected $table = 'topdeals';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ['image_full_path'];

    protected static function boot()
	{
		parent::boot();
        static::addGlobalScope(new DeleteScope);
        static::addGlobalScope(new OrderScope);
    }
    public function getImageFullPathAttribute()
    {
        if(empty($this->image)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/banner/Big/'.$this->image;
    }
}
