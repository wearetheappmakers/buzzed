<?php

namespace App\Models;
use App\Models\States;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
	use SoftDeletes;
	
    protected $table = 'emailtemplate';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
