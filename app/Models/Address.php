<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Address extends Model
{
    use SoftDeletes;
    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function states()
    {
        return $this->hasOne('App\Models\States','id', 'state_id');
    }
    public function city()
    {
        return $this->hasOne('App\Models\Cities','id', 'city_id');
    }
    public function countries()
    {
        return $this->hasOne('App\Models\Countries', 'id', 'country_id');
    }
    
}