<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Models\Currency as ModelCurrency;
use App\Seller;
use Currency;

class CustomeHelper
{
    public static function sellerSelect($for_select = false)
    {
        $sellers = Seller::get();

        if($for_select) {
            $seller_array[''] = 'Select Seller'; 
        }
        
        foreach($sellers as $s) {
            $seller_array[$s['id']] = $s['name'] ;
        }
        return $seller_array;
    }
    // public static function currencyRate()
    // {
    //     $currency = Currency::where('status',1)->get();
    //     $default_curreny = '';
    //     $currency_rate = [];
    //     foreach ($currency as $key => $value ) {
    //         // $k = $value->name;
    //         if($key == 0){
    //             $currency_rate[$value->name]=1;
    //             $default_currency=$value->name;
    //             continue;
    //         }
    //         // echo $default_currency;
    //         // exit;
            
    //         $current_currency_rate = floatval(config('fashionb2b.'.$default_currency.'-'.$value->name));
    //         $currency_rate[$value->name]=$current_currency_rate;
    //         // dd($current_currency_rate);
    //     }
    //     return $currency_rate;
    // }

    public static function convertCurrency($from, $to, $value, $round = 2)
    {
        //  print_r(Currency::rates());
        //  print_r(Currency::rates('NOK'));
        //  echo moneyFormat(10, 'INR');
        //  exit;
        $price = 0;
        $from = strtoupper($from);
        $to = strtoupper($to);
        if (empty($value)) {
            return $price;
        }

        if(config('fashionb2b.is_currency_conversion_live') == '1') {
            if($round === 'money') {
                $price = Currency::conv($from, $to, $value, 'money');
            } else {
                $price = Currency::conv($from, $to, $value);
            }
        } else {
            // if ($from === 'INR' && $to === 'USD' ) {
            //     $rate = floatval(config('fashionb2b.'.$from.'-'.$to));
            //     $price = $value * $rate;
            // } else if ($from === 'USD' && $to === 'INR' ) {
            //     $rate = floatval(config('fashionb2b.'.$from.'-'.$to));
            //     $price = $value * $rate;
            // } else 
            if($from === $to ){
                $price = $value;
            } else {
                $rate = floatval(config('fashionb2b.'.$from.'-'.$to));
                $price = $value * $rate;
            }
            $price = round($price, 2);
            if($round === 'money') {
                $price = moneyFormat($price, $to);
                // $price = Currency::conv($to, $to, $price, $round);
            }
        }   
             
        return $price;
    }
}
