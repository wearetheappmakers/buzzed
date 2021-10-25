<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class referralLink extends Model
{
    protected $fillable = ['user_id','link','product_id',];
}
