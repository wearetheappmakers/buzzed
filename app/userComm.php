<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userComm extends Model
{
    protected $fillable = ['user_id','product_id','status','amount','approvedDate','order_id'];
}
