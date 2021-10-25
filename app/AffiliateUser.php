<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class AffiliateUser extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $guard = 'AffUser';
    
    protected $fillable = ['name','address','email','password','phone','bankAcName','bankAcNumber','IFSC','bankName','status','referral_id',];

}
