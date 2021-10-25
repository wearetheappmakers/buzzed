<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
	use SoftDeletes;
	
    protected $table = 'states';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id');
    }

}
