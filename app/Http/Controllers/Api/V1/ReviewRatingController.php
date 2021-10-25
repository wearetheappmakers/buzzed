<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Requests\ReviewRatingRequest;
use JWTAuth;
use DB;
use App\Models\ReviewRating;
use App\Models\Product;

class ReviewRatingController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->product_slug)
        {
            return response()->json(['success' =>false, 'message' => 'required: product_slug']);
        }
        $product_id = Product::where('slug', $request->product_slug)->pluck('id')->first();        
        $data = ReviewRating::with('customer','vendor')->where('product_id', $product_id)->orderBy('id',"DESC")->get();
        // dd(url('/storage/uploads/users/Medium'));
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value->customer->profile_image = url('/storage/uploads/users/Medium').'/'.$value->customer->image;
                $value->vendor->profile_image = !empty($value->vendor->image) ? url('/storage/uploads/users/Medium').'/'.$value->vendor->image : '';
            }
        }
         

        if($data)
        {
            if (count($data)==0) {
                return response()->json(['success' => true, 'message' => 'Review Data','data' => 0]);
            }else{
                return response()->json(['success' => true, 'message' => 'Review Data','data' => $data]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }
    public function add(ReviewRatingRequest $request)
    {
    	$user = JWTAuth::user();
        
        $param = $request->all();
        $param['customer_id']= $user->id;
        // dd($param);
        $reviewrating = ReviewRating::create($param);
        if($reviewrating)
        {
            return response()->json(['success' => true, 'message' => 'Review Added successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }
    public function edit(Request $request)
    {
        if(!$request->id)
        {
            return response()->json(['success' =>false, 'message' => 'required: reviewrating_id']);
        }
        $user = JWTAuth::user();
        
        $param = $request->all();
        $param['customer_id']= $user->id;
        
        $reviewrating = ReviewRating::where('id',$request->id)->update($param);
        if($reviewrating)
        {
            return response()->json(['success' => true, 'message' => 'Review Updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }
    public function delete(Request $request)
    {
        if(!$request->id)
        {
            return response()->json(['success' =>false, 'message' => 'required: reviewrating_id']);
        }
        $reviewrating = ReviewRating::where('id',$request->id)->delete();

        if($reviewrating)
        {
            return response()->json(['success' => true, 'message' => 'Review remove successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }
}