<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Scopes\SellerScope;
use Auth;

class Membership extends Model
{
    use SoftDeletes;
    protected $table = 'membership';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
