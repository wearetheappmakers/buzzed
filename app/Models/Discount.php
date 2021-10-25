<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\DeleteScope;
use App\Scopes\OrderScope;
use Carbon\Carbon;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // protected $appends = ["format_discount_start_date", "format_discount_end_date"];

    protected static function boot()
	{
		parent::boot();
        static::addGlobalScope(new DeleteScope);
        static::addGlobalScope(new OrderScope);
    }

    // public function getFormatDiscountStartDateAttribute()
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['discount_start_date'])->format('d-m-Y g:i A');
    // }
    // public function getFormatDiscountEndDateAttribute()
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['discount_end_date'])->format('d-m-Y g:i A');
    // }
}
