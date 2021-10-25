<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Currency;
use App\Http\Requests\AddressRequest;
use JWTAuth;
use DB;
class AddressController extends Controller
{
     public function index()
    {
        $address = Address::with('states','city')->where('customer_id',JWTAuth::user()->id)->get()->all();

        if (!empty($address)) {
            return response()->json(['success' => 1, 'message'=>'Record fetched successfully', 'data' => $address],200);
        }else{
            return response()->json(['success' => 0, 'message'=>'No records Found'],200);
        }
    }

    public function add(AddressRequest $request)
    {
        $user = JWTAuth::user();
        $user_id = $user->id;
        $param = $request->all();
        $param['customer_id']= $user_id;
        $param['fullname']= $user->fname;
        $param['number']= $user->number;
        $param['country_id']= 101;

        $address = Address::create($param);
        $address = Address::with('states','city')->findOrFail($address->id);
        
        return response()->json(['success' => 1, 'message' => 'Address created successfully', 'data' => $address],200);
    }
    public function edit(AddressRequest $request)
    {
        $user = JWTAuth::user();
        $user_id = $user->id;
        $param = $request->all();
        $param['customer_id']= $user->id;
        $address = Address::where('id', $request->id);
        $address->update($param);

        return response()->json(['success' => 1, 'message' => 'Address Updated successfully'],200);
    }
    public function view()
    {
        $user = JWTAuth::user();
        $user_id = $user->id;
        $data = Address::where([['customer_id',$user_id],['deleted_at',NULL]])->latest()->first();
        
        return response()->json(['success' => 1, 'message' => $data],200);
    }
    public function delete(Request $request)
    {
        if($request->id)
        {
            Address::where('id', $request->id)->delete();
            return response()->json(['success' => 1, 'message' => 'Address Deleted successfully'],200);
        } else {
            return response()->json(['success' => 0, 'message' => 'Provide id'],400);
        }
    }
}