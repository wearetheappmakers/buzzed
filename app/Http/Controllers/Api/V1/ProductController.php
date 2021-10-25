<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CustomeHelper;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\Option;
use App\Models\Color;
use App\Models\Category;
use App\Models\Size;
use App\Models\Brand;
use App\Models\UserWishlist;
use App\Models\UserCart;
use DB;
use JWTAuth;
use App\Models\OrderHeader;
use App\Models\ReviewRating;
use App\Models\OptionValue;

class ProductController extends Controller
{
    public function index(Request $request,$cat_slug)
    {
        // dd($request->colors);
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $category = Category::where('slug',$cat_slug)->first();
        $ids = array();
        $categories_ids = Category::where('parent_id',$category->id)->select('id')->get()->all();

            if (!empty($categories_ids)) {
                foreach ($categories_ids as $key => $value) {
                    array_push($ids, $value->id);
                }
            }

        if($cat_slug == "all"){
            $data = Product::with('product_images.colors', 'product_prices.currencies','tag')
            ->with([
                    'categories'=> function($q) {
                        $q->select('id','name');
                    },  'colors'=> function($q) {
                        $q->select('id', 'name', 'code');
                    }, 'discounts'=> function($q) use($today){
                        // $q->select('id', 'discount_per');
                        $q->where('discount_start_date', '<', $today);
                        $q->where('discount_end_date', '>', $today);
                    }, 'sizes' => function($q) {
                        $q->where('id','name');
                    },'product_prices' => function($q) {
                        $q->select('*');
                        // $q->where('option_id', 1);
                    }
                    ]);    
        } else {

            $data = Product::with('product_images.colors', 'product_prices.currencies','tag')
            ->with([
                    'categories'=> function($q) {
                        $q->select('id','name');
                    },  'colors'=> function($q) {
                        $q->select('id', 'name', 'code');
                    }, 'discounts'=> function($q) use($today){
                        // $q->select('id', 'discount_per');
                        $q->where('discount_start_date', '<', $today);
                        $q->where('discount_end_date', '>', $today);
                    }, 'sizes' => function($q) {
                        $q->where('id','name');
                    },'product_prices' => function($q) {
                        $q->select('*');
                        // $q->where('option_id', 1);
                    }
                    ])->whereHas('categories' ,  function($q) use($cat_slug,$category,$ids) {
                       if (isset($category->parent_id)) {
                            $q->where('slug',$cat_slug);                        
                        }else{
                            $q->whereIn('id',$ids);
                        }

                    });
        }

                    if($request->colors && $request->colors != '') {
                        $colors = explode(",",$request->colors);
                        $data->whereHas('colors' ,  function($q) use($colors) {
                                    $q->whereIn('slug',$colors);
                                });
                    }
                    if($request->size && $request->size != '') {
                        $sizes = explode(",",$request->size);
                        $data->whereHas('sizes' ,  function($q) use($sizes) {
                                    $q->whereIn('id',$sizes);
                                });
                    }
                    if($request->material && $request->material != '') {
                        $material = explode(",",$request->material);
                        $data->whereHas('optionvalues' ,  function($q) use($material) {
                                    $q->whereIn('slug',$material);
                                });
                    }
                    if($request->layer && $request->layer != '') {
                        $layer = explode(",",$request->layer);
                        $data->whereHas('optionvalues' ,  function($q) use($layer) {
                                    $q->whereIn('slug',$layer);
                                });
                    }
                    if($request->design && $request->design != '') {
                        $design = explode(",",$request->design);
                        $data->whereHas('optionvalues' ,  function($q) use($design) {
                                    $q->whereIn('slug',$design);
                                });
                    }
                    if($request->property && $request->property != '') {
                        $property = explode(",",$request->property);
                        $data->whereHas('optionvalues' ,  function($q) use($property) {
                                    $q->whereIn('slug',$property);
                                });
                    }
                     if($request->startprice && $request->startprice != '' && $request->endprice && $request->endprice != '') {
                                // $price = explode("-",$request->price);
                                $min_price = $request->startprice;
                                $max_price = $request->endprice;
                             
                        if($max_price != '')
                        {

                                   $data->whereHas('product_prices' ,  function($q) use($min_price,$max_price) {
                                                $q->where('price','>=',$min_price);
                                                $q->where('price','<=',$max_price);
                                            }); 
                                
                        }else{
                                        $data->whereHas('product_prices' ,  function($q) use($min_price) {
                                                $q->where('price','>=',$min_price);
                                            });

                    }
                }
         if(isset($request->az)){
                        // dd('az');
                        $data = $data->orderBy('name');
                     }elseif(isset($request->za)){
                        // dd('za');
                        $data = $data->orderBy('name','DESC');
                     }else{
                        // dd('else');
                        $data = $data->orderBy('id','DESC');
                     }

                    //  if(isset($request->oldest)){

                    //     $data = $data->orderBy('id');

                    // }

                     
                     $data = $data->where('status',1)->where('type','!=',2)->paginate(12)
                     ->toJson();
        $products = json_decode($data, true);
                    
        $product_array = [];
        foreach($products['data'] as $product) {
            $product_image = [];
            $color_array = [];
            $product_price =[];
            // dd($product['colors']);

            foreach($product['colors'] as $colors) {
                $color_array[$colors['id']]['color_name'] = $colors['name'];
            }
           
            // dd($product['product_images']);
            foreach($product['product_images'] as $p_i) {
               $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
            }
            // dd($product_image);
            // dd($product['discounts']);
            $discount_per = 0;
            if(isset($product['discounts'][0])) {
                $discount_per =$product['discounts'][0]['discount_per'];
            }
            // $currency_price = CustomeHelper::currencyRate();
            // dd($product['discounts'][0]['discount_per']);
            $currency = Currency::where('status', 1)->get()->toArray();
            foreach($product['product_prices'] as $pp) {
               $product_cur = $pp['currencies']['value'];
               // dd($product_cur);
                // echo "<pre>";
                // print_r($currency);
                // print_R($pp['currencies']);
                // exit;
                if(!isset($product_price[$pp['color_id']])) {
                    $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                    foreach ($currency as  $cur) {
                        $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                        $wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price']);
                        // $price = number_format((float) ($pp['price'] / $rate),2);
                        $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                        $product_wholesale_price[$pp['color_id']]['wholesale_price']['wholesale_price'.$cur['value']] = $wholesale_price;
                        
                        $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                        $format_wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price'], 'money');
                        $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                        $product_wholesale_price[$pp['color_id']]['wholesale_price']['format_wholesale_price'.$cur['value']] = $format_wholesale_price;
                   
                    }
                    if($discount_per != 0 ) {
                        $discount_price = ($pp['price'] * $discount_per) / 100;
                        $discount_wholesale_price = ($pp['wholesale_price'] * $discount_per) / 100;
                        $discounted_price = $pp['price']-$discount_price ;
                        $discounted_wholesale_price = $pp['wholesale_price']-$discount_wholesale_price ;
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = $discounted_price;
                        $product_wholesale_price[$pp['color_id']]['discount_wholesale_price']['discount_wholesale_price'] = $discounted_wholesale_price;
                        foreach ($currency as  $cur) {
                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price);
                            $d_wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_wholesale_price);
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = $d_price;
                            $product_wholesale_price[$pp['color_id']]['discount_wholesale_price']['discount_wholesale_price'.$cur['value']] = $d_wholesale_price;

                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price, 'money');
                            $d_wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_wholesale_price, 'money');
                            $product_price[$pp['color_id']]['discount_price']['format_discount_price'.$cur['value']] = $d_price;
                            $product_wholesale_price[$pp['color_id']]['discount_wholesale_price']['format_discount_wholesale_price'.$cur['value']] = $d_wholesale_price;
                        }
                    } else {
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = 0;
                        $product_wholesale_price[$pp['color_id']]['discount_wholesale_price']['discount_wholesale_price'] = 0;
                        foreach ($currency as  $cur) {
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = 0;  
                            $product_wholesale_price[$pp['color_id']]['discount_wholesale_price']['discount_wholesale_price'.$cur['value']] = 0;  
                        }
                    }
                }              
            }
            // dd($product_price);
            // echo "<pre>";
            // dump($product_image);
          

            $price_color_image_array = [];
            if(count($product['colors']) > 0) {
                $i = 0;
                foreach($product['colors'] as $key=>$price_color_image) {
                    // dump($product_image);
                    $color_id = $price_color_image['id'];
                    // dump($product_image);
                    // $imagevalue = '';
                    // if ($product_image[$color_id]['image']) {
                    //     $imagevalue = isset($product_image[$color_id]['image']) ? $product_image[$color_id]['image']: [];
                    // }else{
                    //     $imagevalue = '';
                    // }
                    $price = $product_price[$color_id]['price']['price'];
                    $wholesale_price =  $product_wholesale_price[$color_id]['wholesale_price']['wholesale_priceINR'];
                    $save_price = (int)$price - (int)$wholesale_price;
                    $price_color_image_array[] = [
                         'color_id'=>$color_id,
                         'price'=>$product_price[$color_id]['price'],
                         'wholesale_price'=>$product_wholesale_price[$color_id]['wholesale_price'],
                         'save_price'=> isset($save_price) ? $save_price : 0,
                         // 'discount_price'=>$product_price[$color_id]['discount_price'],
                         // 'discount_wholesale_price'=>$product_wholesale_price[$color_id]['discount_wholesale_price'],
                         'color_name'=>$price_color_image['name'],
                         // 'image'=>$imagevalue,
                         'image'=>isset($product_image[$color_id]['image']) ? $product_image[$color_id]['image']: [],
                     ];
                     // dd($product_image[$color_id]['image']);
                        // dump(isset($product_image[$color_id]['image'][0]));
                     if($i == 0){
                        $product_image = isset($product_image[$color_id]['image'][0]) ? $product_image[$color_id]['image'][0]: 0;
                    }
                    $i++;
                    
                }
            } else {

                $i = 0;
                $image_array= [];
                foreach($product_image as $image) {
                    $image_array = $image['image'];
                    // dd($image_array);
                    if($i == 0){
                        $product_image = isset($image_array[0]) ? $image_array[0]: 0;

                    }
                    $i++;
                }
                $price_color_image_array = [
                    'color_id'=>1,
                    'price'=>$product_price[1]['price'],
                    'price'=>$product_wholesale_price[1]['wholesale_price'],
                    'discount_price'=>$product_price[1]['discount_price'],
                    'discount_wholesale_price'=>$product_wholesale_price[1]['discount_wholesale_price'],
                    'color_name'=>"no",
                    'image'=>$image_array,
                ];

            }

            $sizes = Product::with('sizes')->where('id',$product['id'])->first();
            $tag = Product::with('tag')->where('id',$product['id'])->first();
            $product_inventory = Product::with('product_inventories')->where('id',$product['id'])->first();
           
            $product_array[] = [
                'name' => $product['name'],
                'id' => $product['id'],
                'description' => $product['description'],
                'slug' => $product['slug'],
                'discount_per' => $discount_per,
                'image' => !empty($product_image) ? $product_image : '',
                'colors' => $price_color_image_array,
                'sizes' => $sizes->sizes,
                'tag' => $tag->tag,
                'product_inventory' => $product_inventory->product_inventory,
            ];
        }
        $products['data'] = $product_array;
        $products['cart_count'] = UserCart::where('customer_id',JWTAuth::user()->id)->count();
        return response()->json(['success' => 1, 'records' => $products ], 200);    
    }
    public function search(Request $request){
     $exs=explode(",",$request->search);
        $search = $request->search;
        $today = Carbon::now()->format('Y-m-d H:i:s');

        $product_data = Product::with('product_images.colors', 'product_prices.currencies','tag')
            ->with([ 'brand' => function($query) use ($search) {
                $query->where('name', "like", '%'.$search.'%');
              },
                'categories' => function($query) use ($search) {
                    $query->where('name', "like", '%'.$search.'%');
              }
          ])->get();

        $search_ids = array();
                
        foreach ($product_data as $key => $value) {
            if (!$value->brand->isEmpty()) {
                array_push($search_ids, $value->id);
            }
            if (!$value->categories->isEmpty()) {
                array_push($search_ids, $value->id);
            }
        }

        $data = Product::with('product_images.colors', 'product_prices.currencies','tag')
           
            ->with([
                    'categories'=> function($q) use($search) {
                        $q->select('id','name');
                        $q->orWhere('name','LIKE','%'.$search.'%');
                    },  
                    'colors'=> function($q) {
                        $q->select('id', 'name', 'code');
                    }, 
                    'discounts'=> function($q) use($today){
                        // $q->select('id', 'discount_per');
                        $q->where('discount_start_date', '<', $today);
                        $q->where('discount_end_date', '>', $today);
                    }, 
                    'sizes' => function($q) {
                        $q->where('id','name');
                    },
                    'product_prices' => function($q) {
                        $q->select('*');
                        // $q->where('option_id', 1);
                    },
                    'brand'=>function($q) use($search) {
                        $q->select('id','name');
                        $q->orWhere('name','LIKE','%'.$search.'%');
                    }
                    ]);
                    if (!empty($search_ids)) {
                       $data->whereIn('id',$search_ids);
                    }else{
                        $data->where('name','LIKE','%'.$search.'%');
                    }

                     $data = $data->where('status',1)->where('type','!=',2)->paginate(12)
                     ->toJson();
                     
        $products = json_decode($data, true);


        $product_array = [];
        foreach($products['data'] as $product) {
            $product_image = [];
            $color_array = [];
            $product_price =[];
            // dd($product['colors']);
            foreach($product['colors'] as $colors) {
                $color_array[$colors['id']]['color_name'] = $colors['name'];
            }
            // dd($color_array);
            // dd($product['product_images']);
            foreach($product['product_images'] as $p_i) {
               $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
            }
            // dd($product_image);
            // dd($product['discounts']);
            $discount_per = 0;
            if(isset($product['discounts'][0])) {
                $discount_per =$product['discounts'][0]['discount_per'];
            }
            // $currency_price = CustomeHelper::currencyRate();
            // dd($product['discounts'][0]['discount_per']);
            $currency = Currency::where('status', 1)->get()->toArray();
            foreach($product['product_prices'] as $pp) {
               $product_cur = $pp['currencies']['value'];
               // dd($product_cur);
                // echo "<pre>";
                // print_r($currency);
                // print_R($pp['currencies']);
                // exit;
                if(!isset($product_price[$pp['color_id']])) {
                    $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                    foreach ($currency as  $cur) {
                        $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                        $wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price']);
                        // $price = number_format((float) ($pp['price'] / $rate),2);
                        $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                        $product_wholesale_price[$pp['color_id']]['wholesale_price']['wholesale_price'.$cur['value']] = $wholesale_price;
                        
                        $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                        $format_wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price'], 'money');
                        $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                        $product_wholesale_price[$pp['color_id']]['wholesale_price']['format_wholesale_price'.$cur['value']] = $format_wholesale_price;
                   
                    }
                    
                    // foreach ($currency as  $cur) {
                    //     $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                    //     // $price = number_format((float) ($pp['price'] / $rate),2);
                    //     $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                        
                    //     $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                    //     $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                   
                    // }
                    if($discount_per != 0 ) {
                        $discount_price = ($pp['price'] * $discount_per) / 100;
                        $discounted_price = $pp['price']-$discount_price ;
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = $discounted_price;
                        foreach ($currency as  $cur) {
                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price);
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = $d_price;

                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price, 'money');
                            $product_price[$pp['color_id']]['discount_price']['format_discount_price'.$cur['value']] = $d_price;
                        }
                    } else {
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = 0;
                        foreach ($currency as  $cur) {
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = 0;  
                        }
                    }
                }              
            }
            
            // echo "<pre>";
            // print_R($product_image);
            // exit;
            $price_color_image_array = [];
            if(count($product['colors']) > 0) {
                $i = 0;
                foreach($product['colors'] as $key=>$price_color_image) {
                    $color_id = $price_color_image['id'];
                    $price = $product_price[$color_id]['price']['price'];
                    $wholesale_price =  $product_wholesale_price[$color_id]['wholesale_price']['wholesale_priceINR'];
                    $save_price = (int)$price - (int)$wholesale_price;


                     $price_color_image_array[] = [
                         'color_id'=>$color_id,
                         'price'=>isset($product_price[$color_id]['price']) ? $product_price[$color_id]['price'] : [],
                         'wholesale_price'=> isset($product_wholesale_price[$color_id]['wholesale_price']) ? $product_wholesale_price[$color_id]['wholesale_price'] : [], 
                         'save_price'=> isset($save_price) ? $save_price : 0,
                         // 'discount_price'=>isset($product_price[$color_id]['discount_price']) ? $product_price[$color_id]['discount_price'] : [],
                         'color_name'=>$price_color_image['name'],
                         'image'=>isset($product_image[$color_id]['image']) ? $product_image[$color_id]['image']: [],
                     ];
                     // dd($product_image[$color_id]['image']);
                     if($i == 0){
                        $product_image = isset($product_image[$color_id]['image'][0]) ? $product_image[$color_id]['image'][0]: 0;
                    }
                    $i++;
                    
                }
            } else {
                $i = 0;
                $image_array= [];
                foreach($product_image as $image) {
                    $image_array = $image['image'];
                    // dd($image_array);
                    if($i == 0){
                        $product_image = isset($image_array[0]) ? $image_array[0]: 0;;

                    }
                    $i++;
                }
                $price_color_image_array = [
                    'color_id'=>1,
                    'price'=>$product_price[1]['price'],
                    'discount_price'=>$product_price[1]['discount_price'],
                    'color_name'=>"no",
                    'image'=>$image_array,
                ];

            }
            $sizes = Product::with('sizes')->where('id',$product['id'])->first();
            $tag = Product::with('tag')->where('id',$product['id'])->first();
            $product_inventory = Product::with('product_inventories')->where('id',$product['id'])->first();
            // dd($price_color_image_array);

            $product_array[] = [
                'name' => $product['name'],
                'id' => $product['id'],
                'description' => $product['description'],
                'slug' => $product['slug'],
                'discount_per' => $discount_per,
                'image' => isset($product_image) ? $product_image : 0,
                'colors' => $price_color_image_array,
                'sizes' => $sizes->sizes,
                'tag' => $tag->tag,
                'product_inventory' => $product_inventory->product_inventory,
                'brand' => isset($product['brand'][0]['name']) ? $product['brand'][0]['name'] : '',
            ];
        }
        $products['data'] = $product_array;
        return response()->json(['success' => 1, 'records' => $products], 200);

    }
    public function allproduct()
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $data = Product::with('product_images.colors', 'product_prices.currencies','tag')
            ->with([
                    'categories'=> function($q) {
                        $q->select('id','name');
                    },  'colors'=> function($q) {
                        $q->select('id', 'name', 'code');
                    }, 'discounts'=> function($q) use($today){
                        // $q->select('id', 'discount_per');
                        $q->where('discount_start_date', '<', $today);
                        $q->where('discount_end_date', '>', $today);
                    }
                    ])->paginate(18)->where('status',1)->where('type','!=',2)
                    ->toJson();
        $products = json_decode($data, true);
                    // dd($products);

        $product_array = [];
        foreach($products['data'] as $product) {
            $product_image = [];
            $color_array = [];
            $product_price =[];
            // dd($product['colors']);
            foreach($product['colors'] as $colors) {
                $color_array[$colors['id']]['color_name'] = $colors['name'];
            }
            // dd($color_array);
            // dd($product['product_images']);
            foreach($product['product_images'] as $p_i) {
               $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
            }
            // dd($product_image);
            // dd($product['discounts']);
            $discount_per = 0;
            if(isset($product['discounts'][0])) {
                $discount_per =$product['discounts'][0]['discount_per'];
            }
            // $currency_price = CustomeHelper::currencyRate();
            // dd($product['discounts'][0]['discount_per']);
            $currency = Currency::where('status', 1)->get()->toArray();
            foreach($product['product_prices'] as $pp) {
               $product_cur = $pp['currencies']['value'];
                // echo "<pre>";
                // print_r($currency);
                // print_R($pp['currencies']);
                // exit;
                if(!isset($product_price[$pp['color_id']])) {
                    $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                    foreach ($currency as  $cur) {
                        $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                        // $price = number_format((float) ($pp['price'] / $rate),2);
                        $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                        
                        $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                        $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                   
                    }
                    if($discount_per != 0 ) {
                        $discount_price = ($pp['price'] * $discount_per) / 100;
                        $discounted_price = $pp['price']-$discount_price ;
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = $discounted_price;
                        foreach ($currency as  $cur) {
                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price);
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = $d_price;

                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price, 'money');
                            $product_price[$pp['color_id']]['discount_price']['format_discount_price'.$cur['value']] = $d_price;
                        }
                    } else {
                        $product_price[$pp['color_id']]['discount_price']['discount_price'] = 0;
                        foreach ($currency as  $cur) {
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = 0;  
                        }
                    }
                }              
            }
            // dd($product_price);
            // echo "<pre>";
            // print_R($product_image);
            // exit;
            $price_color_image_array = [];
            if(count($product['colors']) > 0) {
                foreach($product['colors'] as $key=>$price_color_image) {
                    $color_id = $price_color_image['id'];
                   
                     $price_color_image_array[] = [
                         'color_id'=>$color_id,
                         'price'=>$product_price[$color_id]['price'],
                         'discount_price'=>$product_price[$color_id]['discount_price'],
                         'color_name'=>$price_color_image['name'],
                         'image'=>isset($price_color_image[$color_id]['image']) ? $price_color_image[$color_id]['image']: [],
                     ];
                }
            } else {
                $image_array= [];
                foreach($product_image as $image) {
                    $image_array = $image['image'];
                }
                $price_color_image_array = [
                    'color_id'=>1,
                    'price'=>$product_price[1]['price'],
                    'discount_price'=>$product_price[1]['discount_price'],
                    'color_name'=>"no",
                    'image'=>$image_array,
                ];
            }
            // dd($price_color_image_array);
            $product_array[] = [
                'name' => $product['name'],
                'description' => $product['description'],
                'slug' => $product['slug'],
                'discount_per' => $discount_per,
                'colors' => $price_color_image_array,
            ];
        }
        $products['data'] = $product_array;
        return response()->json(['success' => 1, 'records' => $products], 200);    
    }
    public function detail($product_slug,$id)
    {
        $user_product_id = $id;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $product = Product::with('optionvalues','tag')->where('slug', $product_slug)->first();
        // dd($product);
        $product_image = [];
        $color_array = [];
        $product_price =[];

        foreach($product['colors'] as $colors) {
            $color_array[$colors['id']]['color_name'] = $colors['name'];
        }
        // dd($color_array);
        
        // dd($product['product_inventories']->toArray());
        $product_inventory = [];
        foreach($product['product_inventories'] as $pi) {
            $product_inventory[$pi['color_id']]['size'][] = [
                'size_id' => $pi['size_id'],
                'name'=>$pi['sizes']['name'],
                'min_qty'=>$pi['min_order_qty'],
                'qty' => $pi['inventory'],
                'used' => $pi['used'],
            ];
        }
        // dd($product_inventory);
        // dd($product['product_lots']->toArray());
        // $product_lots = [];
        // if(count($product['product_lots']) > 0) {
        //     foreach($product['product_lots'] as $pl) {
        //         // echo $product_lots[$pl['color_id']];
        //         // exit;
        //         if(!isset($product_lots[$pl['color_id']])) {
        //             $product_lots[$pl['color_id']]['lot'] = '';
        //             $product_lots[$pl['color_id']]['lot_quantity'] = 0;
        //         }
        //         $product_lots[$pl['color_id']]['lot'] .= $pl['sizes']['name'] .'-'. $pl['inventory'] .' | ';
        //         $product_lots[$pl['color_id']]['lot_quantity'] += $pl['inventory'];
        //     }            
        // } 
        
        // dd($product_lots);
        foreach($product['product_images'] as $p_i) {
           $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
        }

        $discount_per = 0;
        if(isset($product['discounts'][0])) {
            $discount_per =$product['discounts'][0]['discount_per'];
        }
        // dd($discount_per);
        $currency = Currency::where('status', 1)->get()->toArray();
        
        foreach($product['product_prices'] as $pp) {
            $product_cur = $pp['currencies']['value'];
            // dd($pp['currencies']['value']);
            if(!isset($product_price[$pp['color_id']])) {
                $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                $product_price[$pp['color_id']]['wholesale_price']['wholesale_price'] = $pp['wholesale_price'];
                // $product_price[$pp['color_id']]['wholesale_quantity']['wholesale_quantity'] = $pp['wholesale_quantity'];
                // dd($pp);
                foreach ($currency as $cur) {
                    $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                    $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                    
                    $wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price']);
                    $product_price[$pp['color_id']]['wholesale_price']['wholesale_price'.$cur['value']] = $wholesale_price;

                    $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                    $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;

                    $format_price1 = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price'], 'money');
                    $product_price[$pp['color_id']]['wholesale_price']['format_price'.$cur['value']] = $format_price1;
                }
                if($discount_per != 0 ) {
                    $discount_price = ($pp['price'] * $discount_per) / 100;
                    $discounted_price = $pp['price']-$discount_price ;
                    $product_price[$pp['color_id']]['discount_price']['discount_price'] = $discounted_price;
                    foreach ($currency as  $cur) {
                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price);
                            $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = $d_price;

                            $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price, 'money');
                            $product_price[$pp['color_id']]['discount_price']['format_discount_price'.$cur['value']] = $d_price;
                        }
                } else {
                    $product_price[$pp['color_id']]['discount_price']['discount_price'] = 0;
                     foreach ($currency as  $cur) {
                        $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = 0;  
                    }
                }
            }              
        }
        
       

      
        $price_color_image_array = [];
        if(count($product['colors']) > 0) {
            foreach($product['colors'] as $key=>$price_color_image) {
                $color_id = $price_color_image['id'];
                $price = $product_price[$color_id]['price']['price'];
                $wholesale_price =  $product_price[$color_id]['wholesale_price']['wholesale_priceINR'];
                $save_price = (int)$price - (int)$wholesale_price;


                 $price_color_image_array[] = [
                     'color_id'=>$color_id,
                     'price'=>$product_price[$color_id]['price'],
                     // 'wholesale_quantity'=>$product_price[$color_id]['wholesale_quantity'],
                     'wholesale_price'=>$product_price[$color_id]['wholesale_price'],
                     'save_price'=> isset($save_price) ? $save_price : 0,
                     'discount_price'=>$product_price[$color_id]['discount_price'],
                     'color_name'=>$price_color_image['name'],
                     'image'=>isset($price_color_image[$color_id]['image']) ? $price_color_image[$color_id]['image']: [],
                    //  'lot' => isset($product_lots[$color_id]['lot']) ? trim($product_lots[$color_id]['lot'], ' | '): [],
                    //  'lot_quantity' => isset($product_lots[$color_id]['lot_quantity']) ? $product_lots[$color_id]['lot_quantity']:0,
                     'size' => isset($product_inventory[$color_id]['size']) ? $product_inventory[$color_id]['size']: [],
                    ];
            }
        } else {
            $image_array= [];
            foreach($product_image as $image) {
                $image_array = $image['image'];
            }
            $price_color_image_array[] = [
                'color_id'=>1,
                'price'=>$product_price[1]['price'],
                // 'wholesale_quantity'=>$product_price[1]['wholesale_quantity'],
                'wholesale_price'=>$product_price[1]['wholesale_price'],
                'discount_price'=>$product_price[1]['discount_price'],
                'color_name'=>"no",
                'image'=>$image_array,
                // 'lot' => isset($product_lots[1]['lot']) ? trim($product_lots[1]['lot'], ' | '): [],
                'size' => isset($product_inventory[1]['size']) ? $product_inventory[1]['size']: [],
            ];
        }
        $data = Product::with('product_images','optionvalues.options','title1','title2','title3','tag','product_inventories')->where('slug', $product_slug)->first();
        // dd($data);
        $product_array[] = [
            // 'product_id' => $product['id'],
            // 'seller_id' => $product['seller_id'],
            // 'name' => $product['name'],
            // // 'lot_wise' => $product['is_lotwise_display'] == 1 ? 1 : 0,
            // 'description' => $product['description'],
            // 'short_description' => $product['short_description'],
            // 'slug' => $product['slug'],
            // 'discount_per' => $discount_per,
            'colors' => $price_color_image_array,
            // 'optionvalues' => $data->optionvalues,
        ];
        $relatedproduct = [];
        $final_detail = [];
        $getproduct = Product::where('slug',$product_slug)->value('id');
        $getproduct_category = Product::with('categories')->where('slug',$product_slug)->first();
        $getcategory = DB::table('product_categories')->where('product_id',$getproduct)->get();
        // dd($getcategory);
        $final_array = [];
        foreach ($getcategory as $key => $value) {
            // dd($value->product_id);
            $newproducts = DB::table('product_categories as pc')
            ->leftJoin('products as pp','pp.id','pc.product_id')
            ->where('pp.type','!=',2)
            ->where('pp.status',1)
            ->where([['pc.category_id',$value->category_id],['pc.product_id','!=',$getproduct]])
            ->get();
            // dd($newproducts);

            array_push($final_array,$newproducts);
        }
        $duplicate = [];
        // dd($final_array);
        
        foreach ($final_array as $key2 => $value2) {
        // dd($value2);
            foreach ($value2 as $key => $value) {
                if ($key!=0) {
                   // dd($value);
                }

                if (empty($duplicate)) {
                    array_push($duplicate,$value->product_id);
                    $getdetail = Product::with('product_images','categories', 'product_prices', 'optionvalues','tag','product_inventories')->where([['id',$value->product_id],['slug','!=',$product_slug]])->first();
                    array_push($final_detail,$getdetail);
                    if ($key!=0) {
                       // dd($final_detail);
                    }
                }

                if (!in_array($value->product_id, $duplicate)) {
                    $getdetail = Product::with('product_images','categories', 'product_prices', 'optionvalues','tag','product_inventories')->where([['id',$value->product_id],['slug','!=',$product_slug]])->first();
                    array_push($final_detail,$getdetail);
                    array_push($duplicate,$value->product_id);
                }
                if ($key!=0) {
                    // dd($duplicate);
                }
            }
            
            // foreach ($final_array as $keys => $values) {
            //     if(($values = []) || ($values->product_id != $getdetail->id))
            //     {
                    
            //     }
            // }
        }
        // dd($final_detail);
        $final = [];
        $date = Date('d F, Y', strtotime('+7 days'));

        $releted_product_data = Product::with('product_images.colors', 'product_prices.currencies');
        if (isset($getproduct_category->categories[0]->parent_id)) {
            $id = $getproduct_category->categories[0]->parent_id;
            $releted_product_data->with([ 
                'categories' => function($query) use ($id) {
                    $query->where('parent_id', $id);
              }
          ]);
        }else{
            $id = $getproduct_category->categories[0]->id;
            $releted_product_data->with([ 
                'categories' => function($query) use ($id) {
                    $query->where('id', $id);
              }
          ]);
        }
        $releted_product_data = $releted_product_data->where('slug','!=',$product_slug)->get();
        // dd($product_slug);
        $wishlist = UserWishlist::where([['customer_id',JWTAuth::user()->id],['product_id',$user_product_id]])->get()->all();
        
        if (empty($wishlist)) {
            $data['wishlist'] = 0;
        }else{
            $data['wishlist'] = 1;
        }

        $records[] = [
            'product' => $data,
            'estimated_delivery_date' => $date,
            'product_rating' => (int)ReviewRating::where('product_id',$data['id'])->avg('rating'),
        ];
        if(isset($id))
        {
            $order_detail = OrderHeader::where('customer_id',$id)->orderBy('id','DESC')->get();
        }else{
            $order_detail = [];
        }
       
        // $product = Product::where('slug', $product_slug)->firstOrFail();
        
        return response()->json(['success' => 1, 'records' => $records, 'order_detail' => $order_detail ,'colors' => $price_color_image_array,'related_products'=>$releted_product_data ,'cart_count' => UserCart::where('customer_id',JWTAuth::user()->id)->count()], 200);
    }

    public function getCategoryId($id = '',$parant_id = ''){

        if (empty($parant_id)) { 
            Category::where('id',$id)->get();
        }
    }

    

    public function applyfilter(Request $request,$cat_slug){
       if($request->sub_catslug) {
            $category_array = explode(",",$request->sub_catslug);
        } else {
            $category_array = [];
        }
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $categoryarray = explode(",",$request->catslug);
        $brand = explode(",",$request->brand);
        $startprice = $request->startprice;
        $endprice = $request->endprice;
        
     
            $data = Product::with('product_images.colors', 'product_prices.currencies')
                ->with([
                        'categories'=> function($q) {
                            $q->select('id','name');
                        },
                        'brand'=> function($q) {
                            $q->select('id','name');
                        },
                          'colors'=> function($q) {
                            $q->select('id', 'name', 'code');
                        }, 'discounts'=> function($q) use($today){
                            // $q->select('id', 'discount_per');
                            $q->where('discount_start_date', '<', $today);
                            $q->where('discount_end_date', '>', $today);
                        }
                        ])
                        
                        ->orWhereHas('categories' ,  function($q) use($categoryarray,$category_array) {
                            
                            if (!empty($category_array)) {
                                 $q->whereIn('slug',$category_array);
                            }else{
                                $ids = Category::whereIn('slug',$categoryarray)->select('id')->get()->each(function($row){
                                    $row->setHidden(['backend_image', 'backend_banner_image','image_full_path','banner_image_full_path']);
                                })->toArray();
    
                                $subids = Category::whereIn('parent_id',$ids)->select('id')->get()->each(function($row){
                                    $row->setHidden(['backend_image', 'backend_banner_image','image_full_path','banner_image_full_path']);
                                })->toArray();

                             $q->whereIn('id',$subids);
                            }                      
                        })
                        ->orWhereHas('brand' ,  function($q) use($brand) {
                            $q->whereIn('name',$brand);                        
                        })
                        
                        ->orWhereHas('product_prices' ,  function($q) use($startprice,$endprice) {
                            $q->whereBetween('price',array($startprice,$endprice));
                        });

                         // if($request->price_high_to_low) {
                         //   $data = $data->orWhereHas('product_prices' ,  function($q) use($startprice,$endprice) {
                         //        $q->orderBy('price','DESC');
                         //    });
                         // }

                         // if($request->price_low_to_high) {
                         //   $data = $data->orWhereHas('product_prices' ,  function($q) use($startprice,$endprice) {
                         //        $q->orderBy('price','DESC');
                         //    });
                         //   dd($data->get()->toArray());
                         // }
                       
                        $data = $data->where('status',1)
                        ->paginate(100)
                        ->toJson();

                        
            
            $products = json_decode($data, true);
            // dd($products);
            

            $product_array = [];
            foreach($products['data'] as $product) {
                $product_image = [];
                $color_array = [];
                $product_price =[];
                // dd($product['colors']);
                foreach($product['colors'] as $colors) {
                    $color_array[$colors['id']]['color_name'] = $colors['name'];
                }
                // dd($color_array);
                // dd($product['product_images']);
                foreach($product['product_images'] as $p_i) {
                   $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
                }
                // dd($product_image);
                // dd($product['discounts']);
                $discount_per = 0;
                if(isset($product['discounts'][0])) {
                    $discount_per =$product['discounts'][0]['discount_per'];
                }
                // dd($product['discounts']);
                // $currency_price = CustomeHelper::currencyRate();
                // dd($product['discounts'][0]['discount_per']);
                $currency = Currency::where('status', 1)->get()->toArray();
                foreach($product['product_prices'] as $pp) {
                   $product_cur = $pp['currencies']['value'];
                    // echo "<pre>";
                    // print_r($currency);
                    // print_R($pp['currencies']);
                    // exit;
                    if(!isset($product_price[$pp['color_id']])) {
                        $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                        foreach ($currency as  $cur) {
                            $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                        //    echo "<pre>";
                        //    print_r($price);
                        //    exit;
                            // $price = number_format((float) ($pp['price'] / $rate),2);
                            $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                            
                            $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                        //    echo $format_price;
                        //    exit;
                            $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                       
                        }
                        // echo "<pre>";
                        // print_r($product_price);
                        // exit;
                        if($discount_per != 0 ) {
                           
                            $discount_price = ($pp['price'] * $discount_per) / 100;
                            $discounted_price = $pp['price']-$discount_price ;
                            $product_price[$pp['color_id']]['discount_price']['discount_price'] = $discounted_price;
                            foreach ($currency as  $cur) {
                                $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price);
                                $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = $d_price;

                                $d_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $discounted_price, 'money');
                                $product_price[$pp['color_id']]['discount_price']['format_discount_price'.$cur['value']] = $d_price;
                            }
                        } else {
                            $product_price[$pp['color_id']]['discount_price']['discount_price'] = 0;
                            foreach ($currency as  $cur) {
                                $product_price[$pp['color_id']]['discount_price']['discount_price'.$cur['value']] = 0;  
                        //    echo "Sad";
                        //    exit;
                            }
                        }
                    }              
                }
                // dd($product_price);
                // echo "<pre>";
                // print_R($product_image);
                // exit;
                $price_color_image_array = [];
                if(count($product['colors']) > 0) {
                    foreach($product['colors'] as $key=>$price_color_image) {
                        $color_id = $price_color_image['id'];
                       
                         $price_color_image_array[] = [
                             'color_id'=>$color_id,
                             'price'=>$product_price[$color_id]['price'],
                             'discount_price'=>$product_price[$color_id]['discount_price'],
                             'color_name'=>$price_color_image['name'],
                             'image'=>isset($product_image[$color_id]['image']) ? $product_image[$color_id]['image']: [],
                         ];
                    }
                } else {
                    $image_array= [];
                    foreach($product_image as $image) {
                        $image_array = $image['image'];
                    }
                    $price_color_image_array = [
                        'color_id'=>1,
                        'price'=>$product_price[1]['price'],
                        'discount_price'=>$product_price[1]['discount_price'],
                        'color_name'=>"no",
                        'image'=>$image_array,
                    ];
                }
                // dd($price_color_image_array);
                $product_array[] = [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'slug' => $product['slug'],
                    'discount_per' => $discount_per,
                    'colors' => $price_color_image_array,
                    'price'=> isset($product['product_prices'][0]['wholesale_price']) ? $product['product_prices'][0]['wholesale_price'] : 0
                ];
            }

            $priw = array_column($product_array, 'price');
            
            
                if(isset($request->price_low_to_high) && $request->price_low_to_high == 1)

                {

                    array_multisort($priw, SORT_ASC, $product_array);

                }elseif(isset($request->price_high_to_low) && $request->price_high_to_low == 1)

                {
                    array_multisort($priw, SORT_DESC, $product_array);
                }
       
        $products['data'] = $product_array;
        $products['cart_count'] = UserCart::where('customer_id',JWTAuth::user()->id)->count();
        return response()->json(['success' => 1, 'records' => $products], 200); 
    }

    public function getFilter(Request $request,$cat_slug) {
        
        $sizes = Size::select('sizes.name', 'sizes.id')
        ->addSelect(\DB::raw('products.name as product_name'))
        ->join('product_sizes', function($join) {
            $join->on('product_sizes.size_id', '=', 'sizes.id'); 
        })->join('products', function($join) {
            $join->on('products.id', '=', 'product_sizes.product_id'); 
        })->join('product_categories', function($join) {
            $join->on('products.id', '=', 'product_categories.product_id');
        })->join('categories', function($join) use($cat_slug){
            $join->on('categories.id', '=', 'product_categories.category_id')
            ->where('categories.slug', $cat_slug); 
        })
        ->where('sizes.id','!=',1)
        ->get();

        $size_array = [];
        foreach($sizes as $size) {
            $size_array[$size['name']] =$size;
        }
        $newarraysize = [];
        foreach ($size_array as $key => $value) {
            $new = $value->toArray();
            array_push($newarraysize,$new);
        }

        $category = Category::where('parent_id',NULL)->get();
        $sub_category = Category::where('parent_id','!=',NULL)->get();
        $brands = Brand::get();

        return response()->json([
            'success' => 1, 
            'records' => [
                'sizes' => $newarraysize,
                'category' => $category,
                'sub_category' => $sub_category,
                'brands' => $brands,
            ]], 200);
    }
}
