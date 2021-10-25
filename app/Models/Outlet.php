<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\SoftDeletes;


class Outlet extends Model
{
    use SoftDeletes;
    protected $table = 'outlet';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
