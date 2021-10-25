<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use App\Scopes\SellerScope;
use Auth;

class BlogCategories extends Model
{
    use Sluggable;
    protected $table = 'blog_categories';
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
    }
    
}
