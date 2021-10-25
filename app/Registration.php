<?php

namespace App;

use App\Notifications\CustomerResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Registration extends Authenticatable
{
    protected $table = 'registration';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    
}