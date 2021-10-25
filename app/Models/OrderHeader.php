<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Helpers\CustomeHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHeader extends Model
{
    use SoftDeletes;
    protected $table = 'order_headers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    protected $appends = ["customer_name", 'formated_total_price', 'formated_price', 'formated_discount', 'order_date'];
    
    public function order_statuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_histroys')->withTimestamps();;
    }

    public function order_lines()
    {
        return $this->hasMany('App\Models\OrderLine');
    }

        // public function sellers()
        // {
        //     return $this->hasOne('App\Seller',  'id', 'seller_id');
        // }

    public function customers()
    {
        return $this->hasOne('App\User',  'id', 'customer_id');
    }

    public function getCustomerNameAttribute(){
        return $this->customers->name;
    }

    // public function getSellerNameAttribute(){
    //     return $this->sellers->name;
    // }

    public function getFormatedTotalPriceAttribute(){        
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->total_price, 'money');
    }
    
    public function getFormatedPriceAttribute(){        
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->price, 'money');
    }

    public function getFormatedDiscountAttribute(){        
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->price - $this->total_price, 'money');
    }


    public function getOrderDateAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y g:i A');
    }

}
