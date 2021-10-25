<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserWishlist;
use App\Models\Size;
use App\Http\Requests\UserWishlistRequest;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use JWTAuth;

class UserWishlistController extends Controller
{
	public function index(UserWishlistRequest $request)
	{
		$params = $request->all();
                $params['customer_id'] = JWTAuth::user()->id;
                $check_wish_list = UserWishlist::where([['customer_id',JWTAuth::user()->id],['product_id',$params['product_id']]])->first();
            if (empty($check_wish_list)) {
                   
                $data = UserWishlist::create($params);

                if($data)
                {
                	return response()->json(['success' => 1, 'message' => 'Product Add to Wishlist Successfully.'], 200); 
                }else{
                	return response()->json(['success' => 0, 'message' => 'Something went wrong'], 200); 
                } 
            }else{
                return response()->json(['success' => 0, 'message' => 'Iteam already in wishlist'], 200); 
            }
	}

        public function details(Request $request)
        {
            $details = UserWishlist::with('products', 'colors', 'sizes')->where('customer_id', JWTAuth::user()->id)->get();
            $userwishlist_array = array();


            if (!empty($details)) {
                    foreach ($details as $key => $detail) {

                            $products= Product::with('product_images.colors', 'product_prices.currencies')->where('id',$detail['products']['id'])->get()->toarray();

                                    if (!empty($products)) {

                                            foreach ($products as $key => $product) {

                                                    if (!empty($product['product_images'])) {
                                                            
                                                            $image = $product['product_images'][0]['image'];
                                                    }else{
                                                           $image = URL::to('/').'/'.'storage/uploads/product/Medium/20200918095718643200fT5Sx.jpg' ;
                                                    }

                                                    if (!empty($product['product_prices'])) {
                                                           $price = $product['product_prices'][0]['price'];
                                                           $wholesale_price = $product['product_prices'][0]['wholesale_price'];
                                                    }



                                                   $userwishlist = [
                                                                    'id'=> $detail['id'],
                                                                    'customer_id'=> $detail['customer_id'],
                                                                    'product_id' => $detail['products']['id'],
                                                                    'product_name' => $detail['products']['name'],
                                                                    'product_slug' => $detail['products']['slug'],
                                                                    'product_short_description' => $detail['products']['short_description'],
                                                                    'product_description' => $detail['products']['description'],
                                                                    'product_code' => $detail['products']['product_code'],
                                                                    'product_type' => $detail['products']['product_type'],
                                                                    'product_sku' => $detail['products']['sku'],
                                                                    'product_moq' => $detail['products']['moq'],
                                                                    'image' => $image,
                                                                    'price'=>$price,
                                                                    'wholesale_price'=>$wholesale_price,
                                                                    
                                                    ];
                                                    

                                                    array_push($userwishlist_array, $userwishlist);
                                            }
                                    }
                           
                    }
            }

            if($details->count()>0)
            {
                    return response()->json(['success' => 1, 'data' => $userwishlist_array], 200); 
            }else{
                    return response()->json(['success' => 0, 'message' => 'No Product found in your wishlist'], 200); 
            }
        }

        public function destory(Request $request){
             $UserWishlist = UserWishlist::where('id',$request->get('id'))->delete();

             if ($UserWishlist == 1) {
                 return response()->json(['success' => 1,'message' => 'Item remove from wishlist successfully'], 200); 
             }else{
                 return response()->json(['success' => 0,'message' => 'Something went wrong!'], 200); 
             }
        }
}