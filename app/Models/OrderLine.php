<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CustomeHelper;

class OrderLine extends Model
{
    protected $table = 'order_lines';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $appends = ["product_image", "formated_price", "formated_main_price", "formated_total_price", "size_table"];

    public function getProductImageAttribute()
    {
        if (isset($this->attributes['image']) && $this->attributes['image']) {
            return env('APP_URL').'/'.$this->attributes['image'];
        }
        return '';
    }

    public function getFormatedPriceAttribute()
    {
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->price, 'money');
    }

    public function getFormatedMainPriceAttribute()
    {
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->main_price, 'money');
    }

    public function getFormatedTotalPriceAttribute()
    {
        $deafult_currency = config('common.default_currency');
        return  CustomeHelper::convertCurrency($deafult_currency, $this->currency, $this->total_price, 'money');
    }

    public function getSizeTableAttribute()
    {
        if($this->lot) {
            $lot_explode = explode(" | ", $this->lot);
            $table='<table class="table table-bordered"> 
                       <thead class="thead-light"><tr>';
            foreach($lot_explode as $lot){
                $lot_header = explode('-', $lot);
                $table.="<th>".$lot_header[0]."</th>";
            }
            $table.="</tr></thead>
                     <tbody><tr>";
            foreach($lot_explode as $lot){
                $lot_header = explode('-', $lot);
                $table.="<td>".$lot_header[1]."</td>";
            }
            $table.='</tr></tbody></table>';
            return $table;
        } 
        if($this->size_id) {
            $table='<table class="table table-bordered"> 
            <thead class="thead-light"><tr>';
            $table.="<th>".$this->size."</th>";
            $table.="</tr></thead>
                     <tbody><tr>";
            $table.="<td>".$this->quantity."</td>";
            $table.='</tr></tbody></table>';
            return $table;
        } 
        return '-';
    }
}
