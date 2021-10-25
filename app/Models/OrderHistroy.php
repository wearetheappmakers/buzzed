<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;

class OrderHistroy extends Model
{
	protected $table = 'order_histroys';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

   public function order_statuses()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}
