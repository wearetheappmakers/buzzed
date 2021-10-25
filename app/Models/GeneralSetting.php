<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralSetting extends Model
{
	use SoftDeletes;

    protected $table = 'site_setting';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ['logo_full_path'];

    public function getLogoFullPathAttribute()
    {
        if(empty($this->logo)){
            return '';
        }
        return env('APP_URL').'/storage/uploads/brand/Big/'.$this->logo;
    }
  
}
