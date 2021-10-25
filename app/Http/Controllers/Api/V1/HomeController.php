<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Offer;
use App\Models\Contact;
use App\Models\Settings;
use App\Models\Testimonial;
use App\Models\UserCart;
use Mail;
use JWTAuth;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Banner::where('type', 'Banner')->where('status',1)->get();
        $top_selling = Product::with('categories')->where('status',1)->orderBy('selling','DESC')->take(6)->get();
        $features_product = Product::with('product_images')->where('status',1)->latest()->get();
        $topdeals = Product::with('product_images','product_prices.currencies','colors','sizes')->where([['status',1],['topdeals',1]])->latest()->get();
        $topdeals_for_user = Product::with('product_images')->where([['status',1],['topdeals',1]])->take(6)->latest()->get();
        $offer = Offer::where([['status',1]])->latest()->get();
        $Settings = GeneralSetting::first();

        // $data['top_categories'] = array();

        if (!empty($topdeals)) {
            foreach ($topdeals as $product => $value) {
                if (!empty($value->product_prices)) {
                   foreach ($value->product_prices as $key => $pp) {
                       $pp->save_price = $pp->price - $pp->wholesale_price;
                       $pp->off_on_deal = round(($pp->save_price*100)/$pp->price);
                       $pp->wholesale_priceINR = $pp->wholesale_price;
                   }
                }

                if (!empty($value->colors)) {
                    foreach ($value->colors as $key => $cc) {
                        if ($cc->pivot['product_id'] == $value->id) {
                            $value->color_id = $cc->id;
                        }
                    }
                }

                if (!empty($value->sizes)) {
                    foreach ($value->sizes as $key => $size) {
                        if ($size->pivot['product_id'] == $value->id) {
                            $value->size_id = $size->id;
                        }
                    }
                }
            }
        }

        // $mobile_slider = Banner::where('type', 'Mobile-Banner')->where('status',1)->get();
        // $homebanner = Banner::where('type', 'Home-Banner')->where('status',1)->get();

        // $cat_left = Banner::where('type', 'Home-Category-Right')->where('status',1)->get();
        // $cat_right = Banner::where('type', 'Home-Category-Left')->where('status',1)->get();

        // $category = Category::whereNull('parent_id')->where('status',1)->get();

        // $product = Product::with('categories','colors','product_images','sizes','product_prices','tag')->orderBy('id', 'desc')->take(8)->where('is_home',1)->where('status',1)->get();

        // $testinomial = Testimonial::get();
        
        // $blog = Blog::where('is_home', 1)->where('status',1)->get();
        
        $data['banner'] = $banner;
        $data['features_product'] = $features_product;
        $data['top_categories'] = $top_selling;
        $data['topdeals'] = $topdeals;
        $data['best_delas'] = $topdeals_for_user;
        $data['offer'] = $offer;
        $data['settings'] = $Settings;
        $data['cart_count'] = UserCart::where('customer_id',JWTAuth::user()->id)->count();
       
        return response()->json(['success' => 1, 'records' => $data], 200);  
    }
    public function get(Request $request){

        if(!$request->name){
            return response()->json(['success' => 0, 'records' => 'required: name'], 500);
        }
        if(!$request->email){
            return response()->json(['success' => 0, 'records' => 'required: email'], 500);
        }
        if(!$request->phone){
            return response()->json(['success' => 0, 'records' => 'required: phone'], 500);
        }
        if(!$request->message){
            return response()->json(['success' => 0, 'records' => 'required: message'], 500);
        }
        if(!$request->prefres){
            return response()->json(['success' => 0, 'records' => 'required: prefres'], 500);
        }
        $param = $request->all();
        $data = Contact::create($param);


        $email = Settings::where('name','admin_email')->value('value');

        Mail::send('contact', $param, function($message) use ($email) {
            $message->to($email);
            $message->subject('Contact Detail');
            
        });
        if($data){
            return response()->json(['success' => 1, 'records' => 'Confirmed'], 200);
        }else{
            return response()->json(['success' => 0, 'records' => 'Something went wrong'], 500);
        }
    }

    public function offres(Request $request){
        $offer = Offer::where([['status',1]])->latest()->get();
        $ids = array();
        $slugs = array();


        if (!empty($offer)) {
            foreach ($offer as $key => $value) {
                $slug = $value->category_slug;
                array_push($slugs, $slug);
                $category = Category::where('slug',$slug)->first();
                $categories_ids = Category::where('parent_id',$category->id)->select('id')->get()->all();

                    if (!empty($categories_ids)) {
                        foreach ($categories_ids as $key => $value) {
                            array_push($ids, $value->id);
                        }
                    }
            }

           $data = Product::with('product_images','categories')->where('status',1);

           $data = $data->whereHas('categories' ,  function($q) use($slugs,$ids) {
                if (!empty($ids)) {
                    $q->whereIn('id',array_unique($ids));
                }
            });
      

            $data = $data->latest()->get();

        }else{
            $data = [];
        }

        if($data){
            return response()->json(['success' => 1, 'records' => $data ], 200);
        }else{
            return response()->json(['success' => 0, 'records' => $data ], 500);
        }
    }
}