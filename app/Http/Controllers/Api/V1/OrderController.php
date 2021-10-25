<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Helpers\CustomeHelper;
use App\Models\OrderHeader;
use App\Models\OrderHistroy;
use App\Models\OrderLine;
use App\Models\Payment;
use App\Models\OrderStatus;
use Adil\Shyplite\Shyplite;
use App\Models\UserCart;
use App\Models\ProductInventory;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\URL;
use App\User;
use Carbon\Carbon;
use JWTAuth;
use DB;
use Mail;
use Razorpay\Api\Api;
use App\Models\Product;
use App\Models\ReturnImages;
use App\Models\Color;
use App\Models\Size;
use App\Http\Requests\UserCartRequest;
use App\Models\Discount;

class OrderController extends Controller
{
    public function returnrequest(Request $request)
    {
        // dd($request->all());
        if(!($request->order_number)){
            return response()->json(['success' => 0, 'message' => 'required: order_number'], 500); 
        }
        if(!($request->order_line_id)){
            return response()->json(['success' => 0, 'message' => 'required: order_line_id'], 500); 
        }
        if(!($request->reason)){
            return response()->json(['success' => 0, 'message' => 'required: reason'], 500); 
        }
        $order_header = OrderHeader::where('id',$request->order_number)->first();
        
        if(!(date('Y-m-d',strtotime($order_header->return_date.'+1 days')) > today()))
        {
            return response()->json(['success' => 1, 'message' => 'Return date expired.'], 200); 
        }else{
            $order_header->update(['order_status_id'=>6]);
            $order_line = OrderLine::where('id',$request->order_line_id)->update(['cancle_note'=>$request->reason]);

            if($request->images){
                foreach ($request->images as $key => $value) {
                    // ReturnImages::
                    // $filename = time();
                    // $request->file('pimage')->move(public_path().'/dist/listerimage/', $filename);  
                    // $lister->update(['pimage' => $filename]);
                    $imageName = time().'-'. $value->getClientOriginalName();

                      ReturnImages::create(['order_line_id'=>$request->order_line_id,'images'=>$imageName,'created_at'=>date('Y-m-d'),'updated_at'=>date('Y-m-d')]);

                      $value->move(public_path('returnimages/'),$imageName);
                }
            }
            $data = ['order_number'=>$order_header->id,'order_line'=>OrderLine::where('id',$request->order_line_id)->first()];
            $customer_email = JWTAuth::user()->email;

            Mail::send('returnrequest', $data, function($message) use ($customer_email) {
                $message->to($customer_email);
                $message->subject('Return Request Submitted');
            });
            //for referral commission
            if(isset($request->refe_id) && isset($request->slug)) {
                $user = AffiliateUser::where('referral_id',$request->refe_id)->first();
                $userid = $user->id;

                $product = Product::where('slug',$request->slug)->first();
                $productid = $product->id;

                $amount = productComm::where('product_id',$productid)->first();
                $pr = $amount->comm;
                $comm = ($pr / 100) * $total_price;

                $date = $orderheader->return_date;
                $userComm = userComm::where([
                                                ['user_id', '=', $userid],
                                                ['order_id', '=',  $order_header->id],
                                                ['product_id', '=', $productid]
                                            ])->first();
                if(isset($userComm)){
                    $userComm->updare([
                        'status' => 3,
                    ]);
                }
                
            }
            //end
            return response()->json(['success' => 1, 'message' => 'Return request sent Successfully.'], 200); 
        }

    }
    public function placeOrder(Request $request)
    {

        $deafult_currency = config('common.default_currency');
        // dd($deafult_currency);
        $customer_id = JWTAuth::user()->id;
        $customer_name = JWTAuth::user()->name;
        $customer_email = JWTAuth::user()->email;

        $settings = GeneralSetting::first();

        if (Carbon::now()->format('H:i') > $settings->shop_open && Carbon::now()->format('H:i') < $settings->shop_close) {
           
        $shipping_address= Address::findOrFail($request->shipping_address_id);
        if($request->shipping_address_id == $request->billing_address_id) {
            $billing_address =  $shipping_address;
        } else {
            $billing_address =  Address::findOrFail($request->billing_address_id);
        }

        $s_country = $shipping_address->countries;
        $s_state = $shipping_address->states;

        $b_country = $billing_address->countries;
        $b_state = $billing_address->states;
        $o_no = $this->findOrderNumber();

        // dd($o_no);


        $param= [];
        $param['currency'] = $request->currency;
        if($request->gst_no){
            $param['gst_no'] = $request->gst_no;
        }
        $param['shipping_fullname'] = $shipping_address->fullname;
        $param['shipping_country_name'] = $s_country->name;
        $param['shipping_country_phone_code'] = $s_country->phonecode;
        $param['shipping_country_code'] = $s_country->iso2;
        $param['shipping_city_name'] = $shipping_address->city_id;
        $param['shipping_state_name'] =  $s_state->name;
        $param['shipping_state_code'] =  $s_state->iso2;
        $param['shipping_pincode'] =  $shipping_address->pincode;
        $param['shipping_mobile'] = $shipping_address->number;
        $param['billing_fullname'] = $shipping_address->fullname;
        $param['billing_country_name'] =  $s_country->name;
        $param['billing_country_phone_code'] =  $s_country->phonecode;
        $param['billing_country_code'] = $s_country->iso2;
        $param['billing_city_name'] = $shipping_address->city_id;
        $param['billing_state_name'] = $s_state->name;
        $param['billing_state_code'] = $s_state->iso2;
        $param['billing_pincode'] = $shipping_address->pincode;
        $param['billing_mobile'] = $shipping_address->number;
        $param['payment_type'] = 'cod';
        $param['customer_id'] = $customer_id;
        $param['order_status_id'] = 1;
        $param['order_number'] = $this->findOrderNumber();

        $orderheader = OrderHeader::create($param);

        if(isset($orderheader->id)) {
            // $seller_id = NULL;
            $carts = UserCart::where('customer_id', $customer_id)->get();
            $total_price = 0;
            $price = 0;
            $total_quantity = 0;
            $discount_code = NULL;
            $discount_per = 0;

            //for referral commission
            if(isset($request->refe_id)){
                $orderproduct = UserCart::where('customer_id', $customer_id)->get();
                foreach($orderproduct as $product){
                    $user = AffiliateUser::where('referral_id',$request->refe_id)->first();
                    $userid = $user->id;

                    $pro = referralLink::where('user_id',$userid)->where('product_id',$product->product_id)->first();
                    if($pro){
                        $amount = productComm::where('product_id',$product->product_id)->first();
                        if($amount){
                            $pr = $amount->comm;
                            $comm = ($pr / 100) * $product->price;
                        } else {
                            $comm = 0;
                        }

                        $date = $orderheader->return_date;

                        userComm::create([
                            'user_id' => $userid,
                            'order_id' => $orderheader->id,
                            'product_id' => $product->product_id,
                            'status' => 0,
                            'amount' => $comm,
                            'approvedDate' => $date,
                        ]);
                    }
                }
                ///end
            }

            foreach($carts as $cart) {

                $new_array = $cart->toArray();
                    $used = 0;
                    $used = ProductInventory::where([['product_id',$new_array['product_id']],['color_id',$new_array['color_id']],['size_id',$new_array['size_id']]])->value('used');
                    // dd($used);
                    $confirm = ProductInventory::where([['product_id',$new_array['product_id']],['color_id',$new_array['color_id']],['size_id',$new_array['size_id']]])->update(['used'=>($used+$new_array['total_quantity'])]);
                    // dd($confirm);
                unset($new_array['id'],$new_array['created_at'], $new_array['updated_at'], $new_array['discount_code'], $new_array['discount_per'] );
                $new_array['order_header_id'] = $orderheader->id;
                $new_array['cart_id'] = $cart['id'];
                $new_array['currency'] = $request->currency; 
                $new_array['price'] = $cart['price'];
                $new_array['main_price'] =$cart['main_price'];
                $new_array['total_price'] = $cart['price'] * $cart['total_quantity'];
                // $price +=$cart['price'];
                $price +=$cart['total_price'] * $cart['total_quantity'];
                $total_quantity +=$cart['total_quantity'];
                if($cart['discount_code']) {
                    $discount_code = $cart['discount_code'];
                }
                if($cart['discount_per']) {
                    $discount_per = $cart['discount_per'];
                }

                $OrderLineData = OrderLine::where('cart_id',$cart['id'])->first();

                $cart->delete();
                // if ($request->get('type') != 'cod') {
                //     if (!empty($OrderLineData)) {
                //        $Paymentdata = Payment::where('order',$OrderLineData->id)->first();
                //        if (!empty($Paymentdata)) {
                //            if($Paymentdata->is_verified == 1){
                //                 $cart->where('customer_id',$OrderLineData->customer_id)->delete();
                //            }
                //        }
                //     }
                // }else{
                // }
                
                $order_line = OrderLine::create($new_array);
                // $seller_id = $cart['seller_id'];
            }

            $total_price = $price;
            if($discount_per > 0) {
                $discount_price = ($total_price * $discount_per) / 100;
                $discounted_price = $total_price-$discount_price ;
                $total_price = $discounted_price;
            } 

            // dd($deafult_currency);

            $orderheader->price = CustomeHelper::convertCurrency($deafult_currency, $request->currency,  $price );
            // dd($orderheader->price);
            $orderheader->total_price = CustomeHelper::convertCurrency($deafult_currency, $request->currency, $total_price );
            $orderheader->discount_code = $discount_code;
            $orderheader->discount_per = $discount_per;
            // $orderheader->seller_id = $seller_id;
            $orderheader->save();
            // dd($orderheader->toArray());

            $orderheader->order_statuses()->sync([1],true);
            
            
        }



        // if ($request->get('type') != 'cod') {
        //     $api = new Api(env('RAZORPAY_KEY'),env('RAZORPAY_SECRET'));

        //     $order  = $api->order->create([
        //       'receipt' => $order_line['id'],
        //       // 'amount'  => $order_line['price']."00",
        //       'amount'  => $total_price."00",
        //       'currency' => 'INR'
        //     ]);

        //     $ohi = OrderLine::where('id',$order_line->id)->latest()->first();
                        
        //     $detail = Payment::create(['order'=> $order_line->id,'order_id' => $order->id, 'receipt' => $order->receipt]);
        //     $detail['order_header'] = $ohi->order_header_id;
        // }else{
            if (!empty($order_line->id)) {
                $detail = OrderLine::where('id',$order_line->id)->latest()->first();
                $detail['order_header'] = $detail->order_header_id;
            }else{
                $detail['order_header'] = '';
            }
            
            $data = [
                'customer_id' => $customer_id,
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'order_id' => $order_line->id,
                ];
                
            $this->sendmail($data);
            return response()->json(['success' => 1, 'message' => 'Order Placed Successfully.', 'detail' => $data], 200);
        }else{
            return response()->json(['success' => 0, 'message' => 'Please order in shop timing'], 200);
        }   
        // }
        // $data = [
        //         'customer_id' => $customer_id,
        //         'customer_name' => $customer_name,
        //         'customer_email' => $customer_email,
        //         'order_id' => $order_line->id,
        //         ];
        //         // 'product_name' => $order_line->product_name,
        //         // 'product_image' => URL::to('/').'/'.$order_line->image,
        //         // 'product_color' => $order_line->color,
        //         // 'product_currency' => $order_line->currency,
        //         // 'product_total_price' => $order_line->total_price,
        //         // 'product_total_quantity' => $order_line->total_quantity,
        //     $this->sendmail($data);
        // return response()->json(['success' => 1, 'message' => 'Order Placed Successfully.', 'detail' => $detail], 200);   
    }

    public function newplaceOrder(Request $request)
    {

        $params = $request->all();
        // dd($params);
        $forproduct = $request->product_id;
        // dd($forproduct);

        $newparam['shipping_address_id'] = $params['shipping_address_id'];
        $newparam['billing_address_id'] = $params['billing_address_id'];
        $newparam['payment_type'] = $params['payment_type'];
        $newparam['currency'] = $params['currency'];
        unset($params['shipping_address_id'],$params['billing_address_id'],$params['payment_type'],$params['currency']);
            
        foreach ($forproduct as $key => $value) {
            // dd($params['product_id'][$key]);
            
            $params['customer_id'][$key] = JWTAuth::user()->id;
            // dd($params['customer_id'][$key]);
            $userCart = UserCart::where('customer_id', $params['customer_id'][$key])->first();
            // dd($userCart);
            $product = Product::findOrFail($request->product_id[$key]);
            // dd($product);
            $params['product_name'][$key] = $product->name;
            // dd($params['product_name'][$key]);
            if($request->color_id[$key]) {
                $color = Color::findOrFail($request->color_id[$key]);
                $params['color'][$key] = $color->name;
            }
            if($request->size_id[$key]) {
                $size = Size::findOrFail($request->size_id[$key]);
                $params['size'][$key] = $size->name;
            }
            $params['quantity'][$key] = 1;
            $params['total_quantity'][$key] = $request->quantity[$key];
            $params['total_price'][$key] = $request->price[$key];
        
            $is_exist = UserCart::where('product_id', $params['product_id'][$key])
            ->where('color_id', $params['color_id'][$key])
            ->where('customer_id', $params['customer_id'][$key]);

            if($request->size_id[$key]) {
                $is_exist->where('size_id', $request->size_id[$key]);
            }
            $is_exist = $is_exist->first();
            $paramss[$key]['customer_id'] = $params['customer_id'][$key];
            $paramss[$key]['product_id'] = $params['product_id'][$key];
            $paramss[$key]['color_id'] = $params['color_id'][$key];
            $paramss[$key]['size_id'] = $params['size_id'][$key];
            $paramss[$key]['product_name'] = $params['product_name'][$key];
            $paramss[$key]['color'] = $params['color'][$key];
            $paramss[$key]['size'] = $params['size'][$key];
            $paramss[$key]['main_price'] = $params['main_price'][$key];
            $paramss[$key]['price'] = $params['price'][$key];
            $paramss[$key]['quantity'] = $params['quantity'][$key];
            $paramss[$key]['total_quantity'] = $params['total_quantity'][$key];
            $paramss[$key]['total_price'] = $params['total_price'][$key];
            // dd($params[$key]);
            if($is_exist) {
                $cart = UserCart::where('id', $is_exist->id);
                $cart->update($paramss[$key]);
            } else {

                $cart = UserCart::create($paramss[$key]);
            }
        }
        // dd($cart);
        $deafult_currency = config('common.default_currency');
        $customer_ids = JWTAuth::user()->id;
        $customer_name = JWTAuth::user()->name;
        $customer_email = JWTAuth::user()->email;


        $shipping_address= Address::findOrFail($request->shipping_address_id);
        if($request->shipping_address_id == $request->billing_address_id) {
            $billing_address =  $shipping_address;
        } else {
            $billing_address =  Address::findOrFail($request->billing_address_id);
        }

        $s_country = $shipping_address->countries;
        $s_state = $shipping_address->states;

        $b_country = $billing_address->countries;
        $b_state = $billing_address->states;
        $o_no = $this->findOrderNumber();

        $param= [];
        $param['currency'] = $request->currency;
        if($request->gst_no)
        {
            $param['gst_no'] = $request->gst_no;
        }
        $param['shipping_fullname'] = $shipping_address->fullname;
        $param['shipping_country_name'] = $s_country->name;
        $param['shipping_country_phone_code'] = $s_country->phonecode;
        $param['shipping_country_code'] = $s_country->iso2;
        $param['shipping_city_name'] = $shipping_address->city_id;
        $param['shipping_state_name'] =  $s_state->name;
        $param['shipping_state_code'] =  $s_state->iso2;
        $param['shipping_pincode'] =  $shipping_address->pincode;
        $param['shipping_mobile'] = $shipping_address->number;
        $param['billing_fullname'] = $shipping_address->fullname;
        $param['billing_country_name'] =  $s_country->name;
        $param['billing_country_phone_code'] =  $s_country->phonecode;
        $param['billing_country_code'] = $s_country->iso2;
        $param['billing_city_name'] = $shipping_address->city_id;
        $param['billing_state_name'] = $s_state->name;
        $param['billing_state_code'] = $s_state->iso2;
        $param['billing_pincode'] = $shipping_address->pincode;
        $param['billing_mobile'] = $shipping_address->number;
        $param['payment_type'] = $request->payment_type;
        $param['customer_id'] = $customer_ids;
        $param['order_status_id'] = 1;
        $param['order_number'] = $this->findOrderNumber();

        $orderheader = OrderHeader::create($param);

        if(isset($orderheader->id)) {
            // $seller_id = NULL;
            $carts = UserCart::where('customer_id', $customer_ids)->get();
            $total_price = 0;
            $price = 0;
            $total_quantity = 0;
            $discount_code = NULL;
            $discount_per = 0;
            foreach($carts as $cart) {

                $new_array = $cart->toArray();
                $used = 0;
                    $used = ProductInventory::where([['product_id',$new_array['product_id']],['color_id',$new_array['color_id']],['size_id',$new_array['size_id']]])->value('used');
                    // dd($used);
                    $confirm = ProductInventory::where([['product_id',$new_array['product_id']],['color_id',$new_array['color_id']],['size_id',$new_array['size_id']]])->update(['used'=>($used+$new_array['total_quantity'])]);
                    
                unset($new_array['id'],$new_array['created_at'], $new_array['updated_at'], $new_array['discount_code'], $new_array['discount_per'] );
                $new_array['order_header_id'] = $orderheader->id;
                $new_array['cart_id'] = $cart['id'];
                $new_array['currency'] = $request->currency; 
                $new_array['price'] = $cart['price'];
                $new_array['main_price'] =$cart['main_price'];
                $new_array['total_price'] =  $cart['price'] * $cart['total_quantity'];
                // $price +=$cart['price'];
                $price +=$cart['total_price'] * $cart['total_quantity'];
                $total_quantity +=$cart['total_quantity'];
                if($cart['discount_code']) {
                    $discount_code = $cart['discount_code'];
                }
                if($cart['discount_per']) {
                    $discount_per = $cart['discount_per'];
                }

                // $OrderLineData = OrderLine::where('cart_id',$cart['id'])->first();

                // if ($request->get('type') != 'cod') {

                //     if (!empty($OrderLineData)) {
                //        $Paymentdata = Payment::where('order',$OrderLineData->id)->first();
                //        if (!empty($Paymentdata)) {
                //            if($Paymentdata->is_verified == 1){
                //                 $cart->where('customer_id',$OrderLineData->customer_id)->delete();
                //            }
                //        }
                //     }
                // }else{
                //     $cart->delete();
                // }
                
                $order_line = OrderLine::create($new_array);
                $cart->delete();
            }

            $total_price = $price;
            if($discount_per > 0) {
                $discount_price = ($total_price * $discount_per) / 100;
                $discounted_price = $total_price-$discount_price ;
                $total_price = $discounted_price;
            }

            $orderheader->price = CustomeHelper::convertCurrency($deafult_currency, $request->currency,  $price );
            $orderheader->total_price = CustomeHelper::convertCurrency($deafult_currency, $request->currency, $total_price );
            $orderheader->discount_code = $discount_code;
            $orderheader->discount_per = $discount_per;
            $orderheader->save();

            $orderheader->order_statuses()->sync([1],true);
        }

        if ($request->payment_type === 'cod') {
            $detail = Payment::create(['order'=> $orderheader['id'],'order_id' => $orderheader['id'], 'receipt' => $orderheader['id']]);
            $data = [
                'customer_id' => $customer_ids,
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'order_id' => $orderheader['id'],
                ];
            $this->sendmail($data);
            
        }else{
            
           $api = new Api(env('RAZORPAY_KEY'),env('RAZORPAY_SECRET'));

            $order  = $api->order->create([
              'receipt' => $orderheader['id'],
              // 'amount'  => $order_line['price']."00",
              'amount'  => $total_price."00",
              'currency' => 'INR'
            ]);

            $detail = Payment::create(['order'=> $orderheader['id'],'order_id' => $order->id, 'receipt' => $order->receipt]);
            
        }
        $data = [
                'customer_id' => $customer_ids,
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'order_id' => $orderheader['id'],
                ];
            $this->sendmail($data);
        return response()->json(['success' => 1, 'message' => 'Order Placed Successfully.','detail' => $detail], 200);
    }
    public function confirmOrder()
    {
        $mytime = Carbon::now();
        $mytime = $mytime->toDateString();
        $configs = [
            'username'=> 'shrayati.online@gmail.com',
            'password' => 'shrayati1234',
            'app_id' => '5131',
            'seller_id' => '44227',
            'key' => 'h2pPolLxwMo=',
            'secret' => 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g=='
        ];

        $shyplite = new Shyplite($configs);
        $response = $shyplite->login();
        $shyplite->setToken($response->userToken);
        // dd($shyplite);
     
        $timestamp = time();
        $appID = "5131";
        $key = 'h2pPolLxwMo=';
        $secret = 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g==';

        $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        $ch = curl_init();

        $data = Array(
            "orders" => Array(
                "0" => Array(
                    "orderId" => "TSTAPI038",
                    "customerName" => "Pushpendra Kumar",
                    "customerAddress" => "Address Line1, Address Line2, Address Line3",
                    "customerCity" => "New Delhi",
                    "customerPinCode" => "110016",
                    "customerContact" => "9876543210",
                    "orderType" => "Prepaid",
                    "modeType" => "Air",
                    "orderDate" => "2019-11-26",
                    "package" => Array( 
                        "itemLength" => "12",
                        "itemWidth" => "15",
                        "itemHeight"=> "20",
                        "itemWeight" => "1.5"
                    ),
                    "skuList" => Array(
                        "0" => Array(
                            "sku" => "Test",
                            "itemName" => "Item1",
                            "quantity" => 1,
                            "price" => 45.00,
                            "itemLength" => "",
                            "itemWidth" => "",
                            "itemHeight"=> "",
                            "itemWeight" => ""
                        ),
                        "1" => Array(
                            "sku" => "Test1",
                            "itemName" => "Item2",
                            "quantity" => 1,
                            "price" => 45.00,
                            "itemLength" => "",
                            "itemWidth" => "",
                            "itemHeight"=> "",
                            "itemWeight" => "" 
                        ),
                        "2" => Array(
                            "sku" => "Test1",
                            "itemName" => "Item3",
                            "quantity" => 1,
                            "price" => 45.00,
                            "itemLength" => "",
                            "itemWidth" => "",
                            "itemHeight"=> "",
                            "itemWeight" => ""
                        )
                    ),
                    "totalValue" => 1320,
                    "sellerAddressId" => 30378
                )
            )
        );

        $data_json = json_encode($data);
        $selid = 44227;
        $header = array(
            "x-appid: ".$appID."",
            "x-sellerid:".$selid."",
            "x-timestamp: ".$timestamp."",
            "x-version:3",
            "Authorization:".$authtoken."",
            "Content-Type: application/json",
            "Content-Length: ".strlen($data_json)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/order?method=sku');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        dd($response);
        var_dump($response);
        exit;
        curl_close($ch);
    }

    public function findOrderNumber() {
        $orderHeader = OrderHeader::latest()->first();
        if($orderHeader) {
            $ord_n = $orderHeader->order_number + 1;
        } else {
            $ord_n = 1;
        }
        return $ord_n;
    }

    public function getOrderList(Request $request) {
        $customer_id = JWTAuth::user()->id;
        $orderheader = OrderHeader::where('customer_id', $customer_id)->get()->all();

        return response()->json(['success' => 1, 'records' => $orderheader ], 200);
    }
    public function getOrderDetail(Request $request,$id)
    {
        dd($id);
        // $order_header = OrderLine::where('order_header_id',$id)->get();
        // dd($order_header);
        // $order_status = OrderStatus::where('status',1)->where('show_on_timeline',1)->get();
        // dd($order_header->toArray());

         return response()->json(['success' => 1, 'records' => $order_header], 200);
    }

    public function getOrder(Request $request,$id){

        $history = OrderHistroy::with('order_statuses')->where('order_header_id',$id)->get();
        if (!empty($history)) {
            foreach ($history as $key => $value) {
               $value->date = date('d-m-Y',strtotime($value->updated_at));
               $value->time = date('H:i',strtotime($value->updated_at));
            }
        }

        $order_status = OrderStatus::where('status',1)->get();
        return response()->json(['success' => 1, 'records' => $history, 'all_status' => $order_status], 200);
    }

    public function updateProductQty(Request $request){

        $cart = UserCart::where('id', $request->get('cart_id'))->first();
        $total_price = $cart->price;
        $cart->total_quantity = $request->get('qty');
        $cart->save();

        return response()->json(['success'=>true,'message'=>'cart update sucessfully'],200);
    }

    public function removeItemCart(Request $request){
        $cart = UserCart::where('id', $request->get('cart_id'))->delete();
        return response()->json(['success'=>true,'message'=>'Item deleted Sucessfully'],200);
    }

    public function sendmail($data){
        $email = $data['customer_email'];
       

        if (!empty($email)) {
            Mail::send('order_place', $data, function($message) use ($email) {
                $message->to($email);
                $message->subject('Your Order From Shrayati');
            });

            return response()->json(['success'=>true,'message'=>'Email sent Successfully'],200);
        }else{
            return response()->json(['success'=>false,'message'=>'Please enter email.'],200);
        }

    }
}