<?php

namespace App\Models;
use App\Models\States;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UpdateRecords extends Model
{
	use SoftDeletes;
	
    protected $table = 'update_records';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    
}
