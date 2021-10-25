<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
