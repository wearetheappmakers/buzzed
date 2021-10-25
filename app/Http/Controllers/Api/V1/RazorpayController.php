<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Razorpay\Api\Api;
use Carbon\Carbon;
use App\Models\OrderHeader;
use App\Models\OrderHistroy;
use App\Models\OrderLine;
use App\Models\Payment;
use App\Models\Product;
use App\Models\UserCart;
use App\Models\OrderStatus;
use Adil\Shyplite\Shyplite;
use App\User;
use App\Customer;
use DB;
use JWTAuth;
use Mail;

class RazorpayController extends Controller
{
	 public function pay() {
        return env('APP_URL').'/admin/pay';
    }

    public function dopayment(Request $request) {
        //Input items of form
        $input = $request->all();
        // dd($input);
        // Please check browser console.
        print_r($input);
        exit;
    }
    public function get(Request $request)
    {
        // $id = $request->id;

        if(!$request->razorpay_payment_id){
            return response()->json(['success' => 1, 'message' => 'required: razorpay_payment_id'], 500);
        }
        if(!$request->razorpay_order_id){
            return response()->json(['success' => 1, 'message' => 'required: razorpay_order_id'], 500);
        }
        if(!$request->razorpay_signature){
            return response()->json(['success' => 1, 'message' => 'required: razorpay_signature'], 500);
        }


        
        $string = $request->razorpay_order_id."|".$request->razorpay_payment_id;

        
        
        $generated_signature = hash_hmac('sha256',$string, env('RAZORPAY_SECRET'));



        if($generated_signature == $request->razorpay_signature) {
           
           Payment::where('order_id',$request->razorpay_order_id)->update(['payment_id'=>$request->razorpay_payment_id,'is_verified'=>1]);
           // dd('yoo');
           $order = Payment::where('order_id',$request->razorpay_order_id)->value('order');
           $order_line = OrderLine::where('id',$order)->first();
           // dd($order);
           $order_header = OrderHeader::where('id',$order_line->order_header_id)->first();
           $product = Product::where('id',$order_line->product_id)->first();

           $usercart = UserCart::where('customer_id',$order_line->customer_id)->delete();
           $customer = Customer::where('id',$order_line->customer_id)->latest()->first();
           $customer_name = $customer->name;
           $customer_email = $customer->email;

           $data = [
                'customer_id' => $order_line->customer_id,
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'order_id' => $order_line->id,
                ];
            $this->sendmail($data);
           

            // $mytime = Carbon::now();
            // $mytime = $mytime->toDateString();
            // $configs = [
            //     'username'=> 'shrayati.online@gmail.com',
            //     'password' => 'shrayati1234',
            //     'app_id' => '5131',
            //     'seller_id' => '44227',
            //     'key' => 'h2pPolLxwMo=',
            //     'secret' => 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g=='
            // ];

            // $shyplite = new Shyplite($configs);
            // $response = $shyplite->login();
            // $shyplite->setToken($response->userToken);
            
         
            // $timestamp = time();
            // $appID = "5131";
            // $key = 'h2pPolLxwMo=';
            // $secret = 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g==';

            // $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
            // $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
            // $ch = curl_init();

            // $data = Array(
            //     "orders" => Array(
            //         "0" => Array(
            //             "orderId" => $request->razorpay_order_id,
            //             "customerName" => $order_header->shipping_fullname,
            //             "customerAddress" => $order_header->shipping_country_name,
            //             "customerCity" => $order_header->shipping_city_name,
            //             "customerPinCode" => $order_header->shipping_pincode,
            //             "customerContact" => $order_header->shipping_mobile,
            //             "orderType" => "Prepaid",
            //             "modeType" => "Air",
            //             "orderDate" => $mytime,
            //             "package" => Array( 
            //                 "itemLength" => "12",
            //                 "itemWidth" => "15",
            //                 "itemHeight"=> "20",
            //                 "itemWeight" => "1.5"
            //             ),
            //             "skuList" => Array(
            //                 "0" => Array(
            //                     "sku" => $product->product_code,
            //                     "itemName" => $product->name,
            //                     "quantity" => $order_line->quantity,
            //                     "price" => $order_line->total_price,
            //                     "itemLength" => "",
            //                     "itemWidth" => "",
            //                     "itemHeight"=> "",
            //                     "itemWeight" => ""
            //                 )                            
            //             ),
            //             "totalValue" => $order_line->total_price,
            //             "sellerAddressId" => "30378"
            //         )
            //     )
            // );



            // $data_json = json_encode($data);
            // $selid = 44227;
            // $header = array(
            //     "x-appid: ".$appID."",
            //     "x-sellerid:".$selid."",
            //     "x-timestamp: ".$timestamp."",
            //     "x-version:3",
            //     "Authorization:".$authtoken."",
            //     "Content-Type: application/json",
            //     "Content-Length: ".strlen($data_json)
            // );


            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/order?method=sku');
            // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            // curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response  = curl_exec($ch);
            // // dd($response);
            // // var_dump($response);
            // // exit;
            // curl_close($ch);

            return response()->json(['success' => 1, 'message' => 'Order Placed Successfully'], 200);
        }else{
            return response()->json(['success' => 0, 'message' => 'payment is not authorized'], 200);
        }
    }

    function delete(Request $request){
        // dd($request->get('user_id'));
        DB::table('user_carts')->where('customer_id',$request->get('user_id'))->delete();
        return response()->json(['success' => 1], 200);
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