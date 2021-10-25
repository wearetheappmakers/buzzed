<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use App\Models\Option;

class OptionValue extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'option_values';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $appends = ['ischecked'];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
  
    public function getIscheckedAttribute()
    {
        // if(empty($this->image)){
            return false;
        // }
        // return env('APP_URL').'/storage/uploads/banner/Big/'.$this->image;
    }
    protected static function boot()
	{
		parent::boot();
		static::addGlobalScope(new DeleteScope);
		static::addGlobalScope(new OrderScope);
	
    }

    public function options()
    {
        return $this->belongsTo(Option::class, "option_id", "id");
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_values');
    }
    // public function options()
    // {
    //     return $this->hasMany(Option::class);
    // }
}
