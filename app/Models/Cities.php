<?php

namespace App\Models;
use App\Models\States;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
	use SoftDeletes;
	
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // public function states()
    // {
    //     return $this->hasOne('App\Models\States', 'id','state_id');
    // }

    // public function states()
    // {
    //     return $this->belongsTo('App\Models\States', 'state_id', 'id');
    // }

    // public function country()
    // {
    //     return $this->belongsTo('App\Models\Countries', 'country_id', 'id');
    // }
}
