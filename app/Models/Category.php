<?php
namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Category extends Model
{
    use NestableTrait, Sluggable;
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ['backend_image', 'backend_banner_image', 'image_full_path', 'banner_image_full_path'];


    // protected static function boot()
	// {
    //     static::created(function($model)
    //     {
    //         $model->order = $model->id;
    //         $model->save();
    //     });
    // }

    public function getBackendImageAttribute()
    {
            return $this->image;
    }

    public function getBackendBannerImageAttribute()
    {
            return $this->banner_image;
    }
    
    public function isRoot()
    {
        return $this->exists && is_null($this->parent_id);
    }
    
    // protected static function booted()
    // {
    //     static::addActiveGlobalScope();
    // }
    
    public static function tree()
    {
        return static::orderByRaw('-position DESC')
                    ->get()
                    ->nest();
    }
    public static function newtree()
    {
        return static::orderByRaw('-position DESC')
                    ->where('status',1)
                    ->get()
                    ->nest();
    }
    public static function treeList()
    {
            return static::orderByRaw('-position DESC')
                ->get()
                ->nest()
                ->setIndent('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ')
                ->listsFlattened('name');
    }
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // public function seller_categories(){
    //     return $this->hasMany('App\Models\SellerCategory');
    // }
    // public function getSlugOptions() : SlugOptions
    // {
    //     return SlugOptions::create()
    //         ->generateSlugsFrom('name')
    //         ->saveSlugsTo('slug')
    //         ->generateSlugsOnUpdate();;
    // }

    public function getImageFullPathAttribute()
    {
        if(empty($this->image)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/category/Big/'.$this->image;
    }

    public function getBannerImageFullPathAttribute()
    {
        if(empty($this->banner_image)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/category/Big/'.$this->banner_image;
    }

}
