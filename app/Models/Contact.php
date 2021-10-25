<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
