<?php

namespace App\Models;
use App\Models\Countries;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function countries()
    {
        return $this->hasOne('App\Models\Countries', 'id', 'country_id');
    }
}
