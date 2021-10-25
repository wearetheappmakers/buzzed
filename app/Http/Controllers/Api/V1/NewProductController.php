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
use App\Models\Size;
use DB;
use App\Models\OrderHeader;

class NewProductController extends Controller
{
    public function index(Request $request,$cat_slug)
    {
        // dd($request->colors);
        $today = Carbon::now()->format('Y-m-d H:i:s');
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
                    ])->whereHas('categories' ,  function($q) use($cat_slug) {
                        $q->where('slug',$cat_slug);                        
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

                     
                     $data = $data->where('status',1)->where('type','!=',2)->paginate(12)
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
               // dd($product_cur);
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
                $i = 0;
                foreach($product['colors'] as $key=>$price_color_image) {
                    $color_id = $price_color_image['id'];
                   
                     $price_color_image_array[] = [
                         'color_id'=>$color_id,
                         'price'=>$product_price[$color_id]['price'],
                         'discount_price'=>$product_price[$color_id]['discount_price'],
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
            ];
        }
        $products['data'] = $product_array;
        return response()->json(['success' => 1, 'records' => $products], 200);    
    }
    public function search(Request $request){

        $search = $request->search;
        $today = Carbon::now()->format('Y-m-d H:i:s');
       
            $data = Product::with('product_images.colors', 'product_prices.currencies','tag')
            ->with([
                    'categories'=> function($q) use($search) {
                        $q->select('id','name');
                        $q->orWhere('name','LIKE','%'.$search.'%');
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
                    ])
                    ->where('name','LIKE','%'.$search.'%');
            
                    
                     
                     $data = $data->where('status',1)->paginate(12)->where('type','!=',2)
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
               // dd($product_cur);
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
                $i = 0;
                foreach($product['colors'] as $key=>$price_color_image) {
                    $color_id = $price_color_image['id'];
                   
                     $price_color_image_array[] = [
                         'color_id'=>$color_id,
                         'price'=>$product_price[$color_id]['price'],
                         'discount_price'=>$product_price[$color_id]['discount_price'],
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
            ];
        }
        $products['data'] = $product_array;
        return response()->json(['success' => 1, 'records' => $products], 200);

    }
   
    public function detail($product_slug, $id)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $product = Product::where('slug', $product_slug)->firstOrFail();
        // dd($product->toArray());
        $size = DB::table('product_sizes')->where('product_id',$product->id)->get();
        foreach ($size as $key => $value) {
            // dd($value->product_id);
            $value->sizes = DB::table('sizes')->where('id',$value->size_id)->first();
        }
        // dd($size);

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
        // dd($product_lots);
        foreach($product['product_images'] as $p_i) {
           $product_image[$p_i['color_id']]['image'][] = $p_i['image'];
        }
        // dd($product_image);
        $discount_per = 0;
        if(isset($product['discounts'][0])) {
            $discount_per =$product['discounts'][0]['discount_per'];
        }
        // dd($discount_per);
        $currency = Currency::where('status', 1)->get()->toArray();
        
        foreach($product['product_prices'] as $pp) {
            $product_cur = $pp['currencies']['value'];
            // dd($pp['currencies']['value']);
            // dd($pp);
            if(!isset($product_price[$pp['color_id']])) {
                $product_price[$pp['color_id']]['price']['price'] = $pp['price'];
                $product_wholesale_price[$pp['color_id']]['wholesale_price']['wholesale_price'] = $pp['wholesale_price'];
                // dd($pp);
                foreach ($currency as $cur) {
                    $price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price']);
                    $wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price']);
                    $product_price[$pp['color_id']]['price']['price'.$cur['value']] = $price;
                    $product_wholesale_price[$pp['color_id']]['wholesale_price']['wholesale_price'.$cur['value']] = $wholesale_price;
                        
                    $format_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['price'], 'money');
                    $format_wholesale_price = CustomeHelper::convertCurrency($product_cur, $cur['value'], $pp['wholesale_price'], 'money');
                    $product_price[$pp['color_id']]['price']['format_price'.$cur['value']] = $format_price;
                    $product_wholesale_price[$pp['color_id']]['wholesale_price']['format_wholesale_price'.$cur['value']] = $format_wholesale_price;
                }
                // dd($discount_per);
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
                    $product_price[$pp['color_id']]['discount_price'] = 0;
                    $product_wholesale_price[$pp['color_id']]['discount_wholesale_price'] = 0;
                    // dd($product_price);
                     foreach ($currency as  $cur) {
                        $product_price[$pp['color_id']]['discount_price'] = 0;
                        $product_wholesale_price[$pp['color_id']]['discount_wholesale_price'] = 0;
                    }
                    // dd($product_price);
                }
            }              
        }
        
       
        // dd($product_price);
      // dd($product['colors']->toArray());
        $price_color_image_array = [];
        if(count($product['colors']) > 0) {
            foreach($product['colors'] as $key=>$price_color_image) {
                $color_id = $price_color_image['id'];
                // dd($price_color_image['image']);
                 $price_color_image_array[] = [
                     'color_id'=>$color_id,
                     'price'=>$product_price[$color_id]['price'],
                     'wholesale_price'=>$product_wholesale_price[$color_id]['wholesale_price'],
                     'discount_price'=>isset($product_price[$color_id]['discount_price']) ? $product_price[$color_id]['discount_price'] : [],
                     'discount_wholesale_price'=>isset($product_wholesale_price[$color_id]['discount_wholesale_price']) ? $product_wholesale_price[$color_id]['discount_wholesale_price'] : [],
                     'color_name'=>$price_color_image['name'],
                     'image'=>isset($product_image[$color_id]['image']) ? $product_image[$color_id]['image']: [],
                     // 'lot' => isset($product_lots[$color_id]['lot']) ? trim($product_lots[$color_id]['lot'], ' | '): [],
                     // 'lot_quantity' => isset($product_lots[$color_id]['lot_quantity']) ? $product_lots[$color_id]['lot_quantity']:0,
                     'size' => isset($product_inventory[$color_id]['size']) ? $product_inventory[$color_id]['size']: [],
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
                'wholesale_price'=>$product_wholesale_price[1]['wholesale_price'],
                'discount_price'=>$product_price[1]['discount_price'],
                'discount_wholesale_price'=>$product_wholesale_price[1]['discount_wholesale_price'],
                'color_name'=>"no",
                'image'=>$image_array,
                // 'lot' => isset($product_lots[1]['lot']) ? trim($product_lots[1]['lot'], ' | '): [],
                'size' => isset($product_inventory[1]['size']) ? $product_inventory[1]['size']: [],
            ];
        }
        $data = Product::with('categories','title1','title2','title3','tag','optionvalues.options','product_inventories')->where('slug', $product_slug)->first();
        // dd($product['']);
        $product_array[] = [
            'product_id' => $product['id'],
            // 'sellers' => Product::with('sellers')->where('slug', $product_slug)->first(),
            // 'categories' => Product::with('categories')->where('slug', $product_slug)->first(),
            'name' => $product['name'],
            'product_code' => $product['product_code'],
            // 'lot_wise' => $product['is_lotwise_display'] == 1 ? 1 : 0,
            'description' => $product['description'],
            'short_description' => $product['short_description'],
            'slug' => $product['slug'],
            'discount_per' => $discount_per,
            'size' => $size,
            'size_chart' => ($product['sizechart']) ? env('APP_URL').'/storage/uploads/sizechart/Big/'.$product['sizechart'] : NULL,
            'colors' => $price_color_image_array,
            'optionvalues' => $data->optionvalues,
            'categories' => $data->categories,
            'title1' => $data->title1,
            'title2' => $data->title2,
            'title3' => $data->title3,
            'tag' => $data->tag,
            'product_inventory' => $data->product_inventory,
        ];
        
        // return response()->json(['success' => 1, 'records' => $product_array], 200);
        $relatedproduct = [];
        $final_detail = [];
        $getproduct = Product::where('slug',$product_slug)->value('id');
        $getcategory = DB::table('product_categories')->where('product_id',$getproduct)->get();
        // dd($getcategory);
        $final_array = [];
        foreach ($getcategory as $key => $value) {
            // dd($value->product_id);
            // $newproducts = DB::table('product_categories')->where([['category_id',$value->category_id],['product_id','!=',$getproduct]])->get();
            // dd($newproducts);
            $newproducts = DB::table('product_categories as pc')
            ->leftJoin('products as pp','pp.id','pc.product_id')
            ->where('pp.type','!=',2)
            ->where('pp.status',1)
            ->where([['pc.category_id',$value->category_id],['pc.product_id','!=',$getproduct]])
            ->get();
            
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
        if(isset($id))
        {
            $check = DB::table('order_headers as oh')
            ->leftJoin('order_lines as ol','ol.order_header_id','oh.id')
            ->where('ol.product_id',$product->id)
            ->where('oh.customer_id',$id)
            ->orderBy('oh.id','DESC')
            ->first();
            // dd($check);
            if(isset($check))
            {
                $order_detail = 1;
                $order_header_id = $check->id;
            }else{
                $order_detail = 0;
                $order_header_id = NULL;
            }
        }else{
            $order_detail = 0;
            $order_header_id = NULL;
        }
        $records[] = [
            'product' => $product_array[0],
            'order_detail' => $order_detail,
            'order_header_id' => $order_header_id,
            'estimated_delivery_date' => $date
        ];
        
       
        // $product = Product::where('slug', $product_slug)->firstOrFail();

        return response()->json(['success' => 1, 'records' => $records,'related_records'=>$final_detail], 200);
    }

    public function getFilter(Request $request,$cat_slug) {
        // dd('aa');

        // dd($request->all());
        if ($cat_slug == 'all') {
            $option_value = Option::with('option_values')        
                        ->whereIn('id', [3, 9, 12, 22])->get();
        }
        else{
        $option_value = Option::with('option_values.products.categories')
                        // ->whereHas('option_values.products' ,  function($q) use($seller_id) {
                        //     $q->where('seller_id',$seller_id);                        
                        // })
                        ->whereHas('option_values.products.categories' ,  function($q) use($cat_slug) {
                            $q->where('slug',$cat_slug);                        
                        })         
                        ->whereIn('id', [3, 9, 12, 22])->get();
                        // dd($option_value);
        }

        $material = 0;
        $layer = 0;
        $design = 0;
        $property = 0;        
     
        foreach ($option_value as $key => $value) {
          // $val = $value->toArray();
            // $value->toArray();
            if ($value->id == 3) {
                $material = $value;
            }
            if ($value->id == 9) {
                $layer = $value;
            }
            if ($value->id == 12) {
                $design = $value;
            }
            if ($value->id == 22) {
                $property = $value;
            }
           
        }
            $colors = Color::select('colors.slug','colors.id','colors.name')
            ->addSelect(\DB::raw('products.name as product_name'))
            ->addSelect(\DB::raw('categories.name as category_name'))
            ->join('product_colors', function($join) {
                $join->on('product_colors.color_id', '=', 'colors.id'); 
              })->join('products', function($join){
                $join->on('products.id', '=', 'product_colors.product_id'); 
              })->join('product_categories', function($join) {
                $join->on('products.id', '=', 'product_categories.product_id');
              })->join('categories', function($join) use($cat_slug){
                $join->on('categories.id', '=', 'product_categories.category_id')
                ->where('categories.slug', $cat_slug); 
              })
            
            ->get();


            // $newcolor = [];
            // $xyz = [];
            // array_push($xyz, $colors);
            // dd($colors);
            // $testolor = array_unique(array_map('serialize',$colors));
            // dd($testolor);
            // $newcolor =  array_map("unserialize", array_unique(array_map("serialize", $colors),SORT_REGULAR));
            
            // dd($newcolor);
            $color_array = [];
            foreach($colors as $color) {
                $color_array[$color['name']] =$color;
            }
            // dd($color_array['black']);
            // $count = 0;
            $newarraycolor = [];
            foreach ($color_array as $key => $value) {
                // dd($value->toArray());
                $new = $value->toArray();
                array_push($newarraycolor,$new);
                // $newarray[$count] = $value;
            }
            // dd($newarray);
             $sizes = Size::select('sizes.name', 'sizes.id')
            ->addSelect(\DB::raw('products.name as product_name'))
            // ->addSelect(\DB::raw('categories.name as category_name'))
            ->join('product_sizes', function($join) {
                $join->on('product_sizes.size_id', '=', 'sizes.id'); 
              })->join('products', function($join) {
                $join->on('products.id', '=', 'product_sizes.product_id'); 
              })->join('product_categories', function($join) {
                $join->on('products.id', '=', 'product_categories.product_id');
              })
             
            ->get();

            $size_array = [];
            foreach($sizes as $size) {
                $size_array[$size['name']] =$size;
            }

            $newarraysize = [];
            foreach ($size_array as $key => $value) {
                // dd($value->toArray());
                $new = $value->toArray();
                array_push($newarraysize,$new);
                // $newarray[$count] = $value;
            }

            return response()->json(['success' => 1, 'records' => ['sizes' => $newarraysize,'colour'=>$newarraycolor,'material'=>$material['option_values'], 'layer'=>$layer['option_values'], 'design'=>$design['option_values'], 'property'=>$property['option_values']]], 200);
        // return response()->json(['success' => 1, 'records' => ['filter_1'=>$filter_1, 'filter_2'=>$filter_2]], 200);
    }
}
