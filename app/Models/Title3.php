<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title3 extends Model
{
    protected $table = 'title3';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getImageAttribute()
    {
        if (isset($this->attributes['image']) && $this->attributes['image']) {
              return env('APP_URL').'/storage/uploads/product/Medium/'. $this->attributes['image'];
        }
        return '';
    }
    public function getImage1Attribute()
    {
        if (isset($this->attributes['image1']) && $this->attributes['image1']) {
            return env('APP_URL').'/storage/uploads/product/Medium/'. $this->attributes['image1'];
        }
        return '';
    }
}
