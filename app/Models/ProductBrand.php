<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ProductBrand extends Model
{
    use SoftDeletes;
    
    protected $table = 'product_brand';
    // protected $primaryKey = 'id';
    // protected $guarded = ['id'];
}