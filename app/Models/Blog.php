<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use App\Scopes\SellerScope;
use Auth;

class Blog extends Model
{
    use Sluggable;
    protected $table = 'blog';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ['image_full_path', 'banner_image_full_path'];

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
    
    }
    
    public function blogcategories()
    {
        return $this->belongsTo('App\BlogCategories', 'blog_category_id', 'id');
    }

    public function getImageFullPathAttribute()
    {
        if(empty($this->image)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/blog/Big/'.$this->image;
    }

    public function getBannerImageFullPathAttribute()
    {
        if(empty($this->banner_image)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/blogbanner/Big/'.$this->image;
    }
}
