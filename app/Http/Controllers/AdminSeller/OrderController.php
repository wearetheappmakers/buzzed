<?php

namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHeader;
use App\Models\Address;
use App\Models\OrderStatus;
use App\Models\Settings;
use App\Models\Discount;
use App\Models\Captain;
use App\Models\Outlet;
use DataTables;
use App\Models\OrderLine;
use App\Customer;
use App\User;
use Mail;
use DB;

class OrderController extends Controller
{
    public function exportview(Request $request)
    {
        $data['data'] = OrderHeader::get();
        return view('adminseller.order.export_view')->with($data);
    }
    public function exportupdate(Request $request)
    {
        if(!($request->start_date))
        {
            $res['status'] = 'Error';
            $res['message'] = 'Start date required.';
            return response()->json($res);
        }
        if(!($request->end_date))
        {
            $res['status'] = 'Error';
            $res['message'] = 'End date required.';
            return response()->json($res);
        }
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $data = OrderHeader::whereBetween('created_at', [$start_date, $end_date])->get();
        foreach ($data as $key => $value) {
            $check_product = DB::table('order_lines')->where('order_header_id',$value['id'])->select('product_name')->get()->toArray();
            foreach ($check_product as $keys => $values) {
                // dd($values->product_name);
                $value['products_names'] = $value['products_names'].' =>'.$values->product_name;
            }
            // dd($value['products_names']);
        }
        // dd($data->toArray());
        $html = '<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows_export"><thead><tr><th>Order Number</th><th>Customer Name</th><th>City</th><th>State</th><th>Country</th><th>GST</th><th>Price</th><th>Date</th><th>Type</th><th>Product</th></tr></thead><tbody>';
        foreach ($data as $key => $value) {
            $html .='<tr><td>'.$value->order_number.'</td><td>'.$value->customers->name.'</td><td>'.$value->shipping_city_name.'</td><td>'.$value->shipping_city_name.'</td><td>'.$value->shipping_country_name.'</td><td>'.$value->gst_no.'</td><td>'.$value->total_price.'</td><td>'.$value->created_at.'</td><td>'.$value->payment_type.'</td><td>'.$value->products_names.'</td>';
        }
        $html .='</tbody></table>';
        $res['status'] = 'Success';
        $res['message'] = $html;
        // dd($res);
        return response()->json($res);
    }
    public function accept(Request $request)
    {
        // dd($request->all());
        OrderLine::where('id',$request->id)->update(['cancle_status'=>1]);
        $data = ['status'=>'Accepted','order_line'=>OrderLine::where('id',$request->id)->first()];
        $cus = OrderLine::where('id',$request->id)->first();
        $customer_email = Customer::where('id',$cus->customer_id)->value('email');

        Mail::send('returnstatus', $data, function($message) use ($customer_email) {
            $message->to($customer_email);
            $message->subject('Return Request Accepted');
        });
    }
    public function reject(Request $request)
    {
        // dd($request->all());
        OrderLine::where('id',$request->id)->update(['cancle_status'=>2]);
        $data = ['status'=>'Rejected','order_line'=>OrderLine::where('id',$request->id)->first()];
        $cus = OrderLine::where('id',$request->id)->first();
        $customer_email = Customer::where('id',$cus->customer_id)->value('email');

        Mail::send('returnstatus', $data, function($message) use ($customer_email) {
            $message->to($customer_email);
            $message->subject('Return Request Accepted');
        });
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $query = OrderHeader::whereRaw('1 = 1');
            if (\Auth::guard('customer')->check()) {
                $query->where('customer_id', \Auth::guard('customer')->user()->id);
            }
            // if($request->status_id) {
            //     $query->where('order_status_id', $request->status_id);
            // }
            $query =  $query->orderBy('id','DESC')->get();
            
            $order_status = OrderStatus::where('status', 1)->get();
            return Datatables::of($query)
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })->addColumn('order_status', function ($row) use ($order_status) {
                    $html = "<select class='order_status_change form-control' data-header_id='".$row->id."'>";
                    foreach($order_status as $os) {
                        $html .= "<option value='".$os['id']."' ".($row->order_status_id ==$os['id'] ? "selected='selected'" : '')." ".($row->order_status_id > $os['id'] ? "readonly='readonly'" : '').">".$os['name']."</option>";
                    }
                    $html .="</select>";
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $action = '<a style="background: green;" href="'.route('admin.order.detail', $row->id).'" title="View details" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i style="color: white;" class="la la-eye"></i>
                            </a>';
                    return $action;
                })
                ->addColumn('customer_name', function ($row) {
                    $user = User::where('id',$row->customer_id)->value('fname');
                    return $user;
                })
                ->addColumn('captain', function ($row) {
                    $captain = Captain::where('id',$row->captain_id)->value('name');
                    return $captain;
                })
                ->addColumn('outlet', function ($row) {
                    $outlet = Captain::where('id',$row->captain_id)->value('outlet');
                    $name = Outlet::where('id',$outlet)->value('name');
                    return $name;
                })
                
                ->addColumn('order_date',function($row){
                    $btn = date('d-m-Y',strtotime($row->created_at));
                    return $btn;
                })
                ->addColumn('type',function($row){
                    if($row->payment_type === 'online'){
                        $btn = 'Prepaid';
                    }else{
                        $btn = 'COD';
                    }
                    return $btn;
                })
                ->addColumn('discount',function($row){

                    return $row->discount_price;
                })
                ->rawColumns(['order_status','customer_name','outlet','captain','type','action','order_date'])
                ->make(true);
        }
        $status_id = '';
        if($request->status_id) {
            $status_id =$request->status_id;
        }
        return view('adminseller.order.index', compact('status_id'));
    }

    public function changeOrderStatus(Request $request)
    {
        
        $order_header_id = $request->order_header_id;
        $status_id = $request->status_id;

        $orderHeader = OrderHeader::findOrFail($order_header_id);
        if($status_id == 2) {
            $this->shypliteOrderCreate($orderHeader);
        }
       
        $orderHeader->order_status_id = $status_id;
        $orderHeader->save();

        $orderHeader->order_statuses()->sync([$status_id],false);

        $res['status'] = 'Success';
        $res['message'] = 'Order Status Change successfully';
        return response()->json($res);
    }

    public function detail($order_header_id, Request $request)
    {
        $order_header = OrderHeader::findOrFail($order_header_id);
        // dd($order_header->toArray());
        $address = Address::where('customer_id',$order_header->customer_id)->value('address');
        $order_status = OrderStatus::where('status',1)->where('show_on_timeline',1)->get();
        $outlet = Captain::where('id',$order_header->captain_id)->value('outlet');
        $outlet_name = Outlet::where('id',$outlet)->value('name');

        return view('adminseller.order.detail', compact('order_header', 'order_status','address','outlet_name'));
    }
    public function print($order_header_id, Request $request)
    {
        $order_header = OrderHeader::findOrFail($order_header_id);
        // dd($order_header->toArray());
        $address = Address::where('customer_id',$order_header->customer_id)->value('address');
        $order_status = OrderStatus::where('status',1)->where('show_on_timeline',1)->get();
        return view('adminseller.order.print', compact('order_header', 'order_status','address'));
    }

    public function shypliteOrderCreate($order) {
        $timestamp    = time();
        $authtoken =  self::shypliteAuthToken($timestamp);
        
        $ch = curl_init();

        $main_address = Address::where('customer_id',$order->customer_id)->first();



        if (!empty($main_address)) {
            $address = $main_address->address .", ". $order->shipping_state_name . ", ". $order->shipping_country_name
            .",".$order->shipping_pincode .", ".$order->shipping_mobile;

        }else{
            $address = $order->shipping_state_name . ", ". $order->shipping_country_name
            .",".$order->shipping_pincode .", ".$order->shipping_mobile;
        }


        $data = [
            "orders" => [
                [
                    "orderId" =>  "SHRAYATI_".$order->id,
                    "customerName" => $order->shipping_fullname,
                    "customerAddress" => $address,
                    "customerCity" => $order->shipping_city_name,
                    "customerPinCode" => $order->shipping_pincode,
                    "customerContact" => $order->shipping_mobile,
                    "orderType" => $order->payment_type == 'cod' ? 'COD' : 'Prepaid',
                    // "modeType" => "Lite-0.5kg",
                    "orderDate" => date('Y-m-d'),
                    "totalValue" =>(float) $order->total_price,
                    "sellerAddressId" => "30378",
                ]
            ]
        ];

        

        $total_qty = 0;
        foreach ($order->order_lines as $product) {
            $data['orders'][0]['skuList'][] = [
                "sku" => $product->sku ? $product->sku : $product->product_name ,
                "itemName" => $product->product_name ,
                "quantity" => $product->quantity ,
                "price" => $product->total_price,
                "itemLength" => "12", //optional
                "itemWidth" => "15", //optional
                "itemHeight"=> "20", //optional
                "itemWeight" => "1.5" //optional
            ];
            $total_qty += $product->quantity;
        }

        $height = 2*$total_qty;
        $weight = 1.5*$total_qty;

        $data['orders'][0]['package'] = [
            "itemLength" => "12",
            "itemWidth" => "15",
            "itemHeight"=> $height,
            "itemWeight" => $weight
        ];
        if($weight < 0.5) {
            $data['orders'][0]['modeType'] = "Lite-0.5kg";
        } else if($weight < 1) {
            $data['orders'][0]['modeType'] = "Lite-1kg";
        } else {
            $data['orders'][0]['modeType'] = "Lite-2kg";
        }

        // echo "<pre>";
        // print_r($data);
        // exit;

        $data_json = json_encode($data);
         // dd($data_json);

        $url = "https://api.shyplite.com/order";
        $response = self::getCurlRequest($authtoken, $timestamp, $url, $data_json);
        echo "<pre>";
        print_r($response);
        // exit;
        return $response;
    }

    public static function shypliteAuthToken($timestamp) {
       
        $appID        = 5131;
        $key          = 'h2pPolLxwMo=';
        $secret       = 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g==';
        
        $sign = "key:".$key."id:".$appID.":timestamp:".$timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true))); 
        return $authtoken;
    }

    public static function getCurlRequest($authtoken, $timestamp, $url, $data='') {
        $appID = 5131;
        $sellerId = 44227;

        $header = array(
            "x-appid: $appID",
            "x-sellerid:$sellerId",
            "x-timestamp: $timestamp",
            "x-version:3", // for auth version 3.0 only
            "Authorization: $authtoken",
        );
        if($data != '') {
            $header[] = "Content-Type:application/json";
            $header[] = "Content-Length:".strlen($data);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        if($data != '') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
        return $response;
    }

    public static function shylightShipmentSlip($order_id) {
        $timestamp = time();
        $authtoken = self::shypliteAuthToken($timestamp);
        $url = 'https://api.shyplite.com/getSlip?orderID='.urlencode($order_id);

        $response = self::getCurlRequest($authtoken, $timestamp, $url);
        return $response;
    }

    public function destory(Request $request)
    {
        $result = OrderStatus::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }

    public function addorder(Request $request){

        $param = $request->all();
        // $discount=Discount::where('id',$request->source_id)->first();
        // $param['discount_per']=$discount->discount_per;
        // $param['discount_price']=($discount->discount_per * $request->price)/100;

        $order = OrderHeader::latest()->first();

        if (!empty($order)) {
            $order_id = 'Buzzed-'.($order->id+1);
        }else{
            $order_id = 'Buzzed-1';
        }
        $param['order_uniqueid'] = $order_id;
        $result = OrderHeader::create($param);

        if ($result){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function billHistory(){
        return view('customer.billhistory');
    }

}
