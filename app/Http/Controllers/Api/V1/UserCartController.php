<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\UserCart;
use App\Models\Currency;
use App\Helpers\CustomeHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Http\Requests\UserCartRequest;
use App\Models\Discount;
use Carbon\Carbon;
use JWTAuth;
use Illuminate\Support\Facades\URL;

class UserCartController extends Controller
{
    public function add(UserCartRequest $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'color_id' => 'required',
            'size_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'image' => 'required', 
        ]);

        $params = $request->all();
        $params['customer_id'] = JWTAuth::user()->id;

        $userCart = UserCart::where('customer_id', $params['customer_id'])->first();
        // if($userCart){
        //     if($userCart['seller_id'] != $request->seller_id) {
        //         $res['success'] = 0;
        //         $res['message'] = 'Cart have other store Product.';
        //         return response()->json($res, 400); 
        //     }
        // }
        $product = Product::findOrFail($request->product_id);
        $params['product_name'] = $product->name; 
        if($request->image){
            
            $str=$request->image;
            $exp=explode('storage',$str);
            
            $params['image'] = 'storage'.$exp[1];
            
        }
        if($request->color_id) {
            $color = Color::findOrFail($request->color_id);
            $params['color'] = $color->name;
        }
        if($request->size_id) {
            $size = Size::findOrFail($request->size_id);
            $params['size'] = $size->name;
        }
        $params['quantity'] = 1;
        $params['total_quantity'] = $request->quantity;
        // if($request->lot) {
        //     $params['total_quantity'] = $request->quantity * $request->lot_quantity;
        //     $params['total_price'] = $request->price * $request->quantity * $request->lot_quantity;
        // }  else {
            // $params['lot_quantity'] = $request->quantity;
            // $params['total_price'] = $request->price * $request->quantity ;
            $params['total_price'] = $request->price;
        // }

        $is_exist = UserCart::where('product_id', $params['product_id'])
        ->where('color_id', $params['color_id'])
        ->where('customer_id', $params['customer_id']);
        if($request->size_id) {
            $is_exist->where('size_id', $request->size_id);
        }
        
        $is_exist = $is_exist->first();
        if($is_exist) {
            $cart = UserCart::where('id', $is_exist->id);
            $cart->update($params);
        } else {

            $cart = UserCart::create($params);
        }
        return response()->json(['success' => 1, 'message' => 'Product Add to Cart Successfully.'], 200);   
    }

    public function applyDiscount(Request $request) {
        $discount_code = $request->get('discount_code');
        $customer_id = JWTAuth::user()->id;

        $today = Carbon::now()->format('Y-m-d H:i:s');

        $discount = Discount::where('discount_code', $discount_code)
            ->where('status', 1)
            ->first();
        if($discount){
            if($today >= $discount['discount_start_date']) {
                if($today <= $discount['discount_end_date']) {
                    $cart = UserCart::where('customer_id', $customer_id);
                    $cart->update(['discount_code'=>$discount_code, 'discount_per'=>$discount['discount_per']]);
                    $res['success'] = 1;
                    $res['message'] = 'Coupon Code Apply SuccessFully.';
                    return response()->json($res, 200); 
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Coupon Code Expired.';
                    return response()->json($res, 200); 
                }
            } else {
                $res['success'] = 0;
                $res['message'] = 'Coupon Code Not Valid';
                $res['from'] = 'start_date';
                return response()->json($res, 200); 
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Coupon Code Not Valid';
            $res['from'] = 'not_found';
            return response()->json($res, 200);   
        }

            // check confition of date 
            // if expired give error if not have code give error if valid then add code and per to cart row 
    }

    public function removeDiscount() {
        // dd('hello');
        $customer_id = JWTAuth::user()->id;
        $cart = UserCart::where('customer_id', $customer_id);
        $cart->update(['discount_code'=>NULL, 'discount_per'=>0]);
        $res['success'] = 1;
        $res['message'] = 'Coupon Code Remove SuccessFully.';
        return response()->json($res, 200); 
               
    }

    public function getCartList(Request $request) {
        $customer_id = JWTAuth::user()->id;    
        $carts = UserCart::where('customer_id', $customer_id)->get();
        // dd($carts);
        $currency = Currency::where('status', 1)->get()->toArray();
        
        $deafult_currency = config('common.default_currency');
        $cart_array = [];
        if(count($carts) != 0) {
            $total_price = 0;
            $discount_code = '';
            $discount_per = 0;
            foreach($carts as $cart) {
                if($cart->lot) {
                    $lot = $cart->lot;
                } else {
                    $lot = $cart->sizes->name .'-'.  $cart->quantity;
                }
               $single_cart_array = [
                   'cart_id' => $cart->id,
                   'product_name' => $cart->products->name,
                   'color_name' => $cart->colors->name,
                   'size_or_lot' => $lot,
                   'price' => $cart->price,
                   'main_price' => $cart->main_price,
                   'total_price' => $cart->total_price * $cart->total_quantity,
                   'quantity' => $cart->quantity,
                   'total_quantity' => $cart->total_quantity,
                   // 'lot_quantity' => $cart->lot_quantity,
                   'image' => !empty($cart->image) ? URL::to('/').'/'.$cart->image : '',
               ];


               foreach($currency as $cur) {
                    $single_cart_array['format_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $cart->price, 'money');
                    $single_cart_array['format_main_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $cart->main_price, 'money');
                    $single_cart_array['format_total_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $cart->total_price, 'money');
                }

               $cart_array[] =$single_cart_array;
               $total_price += $cart->total_price * $cart->total_quantity;

                if($cart->discount_code) {
                   $discount_code = $cart->discount_code;
                }
                if($cart->discount_per) {
                   $discount_per = $cart->discount_per;
                }
            }



  
            $final_array['discount_code'] = $discount_code;
            $final_array['discount_error'] = '';

            if($discount_code != '') {
                $final_array['discount_error'] = $this->checkDiscountInCartList($discount_code);
            }
            $discount_price = 0;
            $discounted_price = $total_price;
            if($discount_per > 0) {
                $discount_price = ($total_price * $discount_per) / 100;
                $discounted_price = $total_price-$discount_price ;
                $final_array['discount_price'] = $discount_price;
            } 
            foreach($currency as $cur) {
                $final_array['price'] = $total_price;
                $final_array['format_total_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $total_price, 'money');
                $final_array['format_discount_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $discount_price, 'money');
                $final_array['format_discounted_price'.$cur['value']] = CustomeHelper::convertCurrency($deafult_currency, $cur['value'], $discounted_price, 'money');
            }

            $res['success'] =1;
            $res['records'] = [
                'cart_list'=>$cart_array,
                'total' => $final_array,
            ];
             // dd($res);
            return response()->json($res, 200);

        } else {
            $res['success'] = 0;
            $res['message'] = 'No records Found.';
            return response()->json($res, 200);
        }
        
    }

    public function checkDiscountInCartList($discount_code) {
        $discount = Discount::where('discount_code', $discount_code)
        ->where('status', 1)
        ->first();

        $today = Carbon::now()->format('Y-m-d H:i:s');

        if($discount){
            if($today >= $discount['discount_start_date']) {
                if($today <= $discount['discount_end_date']) {
                   $discount_error = ''; 
                } else {
                    $discount_error  = 'Coupon Code Expired.';
                }
            } else {
                $discount_error  = 'Coupon Code Not Valid';
            }
        } else {
            $discount_error  = 'Coupon Code Not Valid';
        }
        return $discount_error ;
    }

    public function deleteCart(Request $request) {
        $id = $request->id;

        $cart = UserCart::findOrFail($id);
        $cart->delete();
        $res['success'] = 1;
        $res['message'] = 'Product deleted from cart successfully.';
        return response()->json($res, 200);
    }

    public function updateCart(Request $request) {
        $cart_id = $request->cart_id;
        $quantity = $request->quantity;
        
        $cart = UserCart::findOrFail($cart_id);

        $cart->quantity = $quantity;
        // if($cart->size_id) {
        //     $cart->total_quantity = $quantity;
        // } else {
        //     $cart->total_quantity = $quantity;
        // }
        $cart->total_price = $cart->quantity * $cart->price;
        $cart->save();
        $res['success'] = 1;
        $res['message'] = 'Cart Updated Successfully.';
        return response()->json($res, 200);
    }
}