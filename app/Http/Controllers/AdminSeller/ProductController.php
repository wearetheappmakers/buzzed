<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use App\Models\SizeChart;
use App\Models\Color;
use App\Models\Brand;
use App\Models\ProductBrand;
use App\Models\Category;
use App\Models\UpdateRecords;
use App\Models\OptionValue;
use App\Models\Option;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\Title1;
use App\Models\Title2;
use App\Models\Title3;
use Session;
use Illuminate\Http\Response;
use DataTables;
use App\User;
use Carbon\Carbon;
use App\Http\Requests\ProductRequest;
use DB;
use Auth;
use App\Models\ProductInventory;
use App\Models\ProductLot;
use App\Helpers\ImageHelper;
use App\Models\Discount;
use App\Imports\ProductImport;
use Excel;

class ProductController extends Controller
{
    public function __construct(Product $s)
    {
        $this->view = 'product';
        $this->route = 'product';
        $this->viewName = 'Product';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $query = Product::get();
            // echo "<pre>";
            // print_r($query);
            // exit;

            return Datatables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.product','delete' => route('admin.'.$this->route.'.destory')])->render();
                    return $btn;
                })
                ->addColumn('checkbox', function ($row) {
                    $chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
                    return $chk;
                })
                ->addColumn('vendor', function ($row) {
                    $name = User::where([['status',1],['role',1],['id',$row->vendor_id]])->value('fname');
                    return $name;
                })
                ->addColumn('singlecheckbox', function ($row) {
                    $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id, 'status' => $row->status])->render();
                    return $schk;
                })
                ->addColumn('product_price', function ($row) {
                    $price = ProductPrice::where('product_id',$row->id)->get();
                    $schk = view('admin.layout.product_price')->with([
                        'id' => $row->id, 
                        'price' => isset($price) ? $price : ''])->render();
                    return $schk;
                })
                ->addColumn('selling_product_price', function ($row) {
                    $sprice = ProductPrice::where('product_id',$row->id)->get();
                    $schk = view('admin.layout.selling_product_price')->with([
                        'id' => $row->id, 
                        'price' => isset($sprice) ? $sprice : ''])->render();
                    return $schk;
                })
                ->addColumn('deals', function ($row) {
                    $topdeals = view('admin.layout.topdeals')->with(['id' => $row->id, 'status' => $row->topdeals])->render();
                    return $topdeals;
                })
                ->addColumn('type', function ($row) {
                    if($row->type == 0)
                    {
                        $schk = 'Both';
                    }elseif($row->type == 1){
                        $schk = 'Online';
                    }elseif($row->type == 2)
                    {
                        $schk = 'Offline';
                    }
                    return $schk;
                })
                ->setRowClass(function () {
                    return 'row-move';
                })
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
                ->rawColumns(['checkbox', 'vendor','product_price','selling_product_price','singlecheckbox','deals', 'action','type'])
                ->make(true);
        }
        return view('adminseller.' . $this->view . '.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route('admin.'.$this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['vendors'] = User::where([['status',1],['role',1]])->get();
        $data['brands'] = Brand::where('status',1)->get();

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // dd($request->all());
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['product_brand']);
        $product = Product::create($param);

        if ($request->product_brand) {
           ProductBrand::create(['product_id',$product->id,'brand_id' => $request->product_brand]);
        }else{
             ProductBrand::create(['product_id',$product->id, 'brand_id' => 1]);
        }

        if ($product){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Product::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['categories'] = Category::tree();
        $data['sizes'] = Size::where('id','!=',1)->get();
        $data['sizechart'] = SizeChart::get();
        $data['colors'] = Color::where('id','!=',1)->get();
        $data['options'] = Option::get();
        $data['images'] = DB::table('product_images')->where('product_id',$id)->get();
        $data['title1'] = DB::table('title1')->where('product_id',$id)->first();
        $data['vendors'] = User::where([['status',1],['role',1]])->get();
        $data['brands'] = Brand::where('status',1)->get();

        // dd($data['title1']);
        // foreach ($data['options'] as $key => $option) {
        //     dd($option->option_values->toArray());
        // }
		return view('adminseller.product.edit', compact('data'));
    }
    public function updateSizechart(Request $request)
    {
        $update = DB::table('products')
        ->where('id',$request->product_id)
        ->update(['sizechart'=>$request->sizechart ?? NULL]);

        if($update){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $param = $request->all();
        // dd($param);
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method'],$param['product_brand']);

        $product = Product::where('id', $id);

        $product->update($param);

        if ($product){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateCategory(Request $request) {
        $param = $request->all();
        $product = Product::findOrFail($param['product_id']);

        $product->categories()->sync($param['product']['category'],true);

        $res['status'] = 'success';
        $res['message'] = 'Category Save successfully';
        return response()->json($res);
    }
    public function updateColor(Request $request)
    {
        $param = $request->all();
        $product = Product::findOrFail($param['product_id']);
        if(isset($param['product']['color_id']))
        {
        $product->colors()->sync($param['product']['color_id'], true);
         $res['status'] = 'success';
        $res['message'] = 'Color Save successfully';
        } else {
             $res['status'] = 'error';
        $res['message'] = 'Please Select color';
        }
        // dd($product);
       
        return response()->json($res);
    }
    public function updateSize(Request $request)
    {
        $param = $request->all();
        $product = Product::findOrFail($param['product_id']);

        $product->sizes()->sync($param['product']['size_id'], true);

        $res['status'] = 'success';
        $res['message'] = 'Size Save successfully';
        return response()->json($res);
    }
    
    public function update_general(Request $request)
    {
        // dd($request->all());
        $param = $request->all();
        unset($param['_token'],$param['product_brand']);
        if(!isset($request->is_home))
        {
            $param['is_home'] = 0;
        }

        if ($request->product_brand) {
           DB::table('product_brand')->where('product_id',$request->id)->update(['brand_id' => $request->product_brand]);
        }

        $product = Product::where('id', $request->id);
        $product->update($param);
        // dd($product);
        if ($product){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }
    public function title1product(Request $request)
    {
       
       dd('jhil');
        $is_saved = $request->has('is_saved');
        if($is_saved)
        {
          
               $param = $request->all();
            // dd($param);
            unset($param['_token'],$param['is_saved']);
            $data = Title1::where('product_id',$request->product_id)->first();
            if($data){
                if ($request->hasFile('image')) {
                    $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image']= $name;
                }
                $product = Title1::where('product_id',$request->product_id)->update($param);
            }else{
                if ($request->hasFile('image')) {
                    $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image']= $name;
                }
                $product = Title1::create($param);
            }
            return response()->json(['status'=>'success']);
            
        } else{
      
            $data['edit'] = DB::table('title1')->where('product_id',$request->product_id)->first();
            $data['product_id'] = Product::where('id',$request->product_id)->value('id');
            // dd($data['edit']);
            return view('adminseller.product.title1')->with($data);
        }
    }
    public function title2product(Request $request)
    {
        $is_saved = $request->has('is_saved');
        if($is_saved)
        {
          
               $param = $request->all();
            // dd($param);
            unset($param['_token'],$param['is_saved']);
            $data = Title2::where('product_id',$request->product_id)->first();
            if($data){
                $product = Title2::where('product_id',$request->product_id)->update($param);
            }else{
                $product = Title2::create($param);

            }

            return response()->json(['status'=>'success']);
            
        } else{
      
            $data['edit'] = DB::table('title2')->where('product_id',$request->product_id)->first();
            $data['product_id'] = Product::where('id',$request->product_id)->value('id');
            // dd($data['product_id']);
            return view('adminseller.product.title2')->with($data);
        }
    }
    public function title3product(Request $request)
    {
        $is_saved = $request->has('is_saved');
        if($is_saved)
        {
          
            $param = $request->all();
            // dd($param);
            unset($param['_token'],$param['is_saved']);
            $data = Title3::where('product_id',$request->product_id)->first();
            if($data){
                if ($request->hasFile('image')) {
                    $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image']= $name;
                }
                if ($request->hasFile('image1')) {
                    $name = ImageHelper::saveUploadedImage(request()->image1, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image1']= $name;
                }
                $product = Title3::where('product_id',$request->product_id)->update($param);
            }else{
                if ($request->hasFile('image')) {
                    $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image']= $name;
                }
                if ($request->hasFile('image1')) {
                    $name = ImageHelper::saveUploadedImage(request()->image1, 'Product', storage_path("app/public/uploads/product/"));
                    $param['image1']= $name;
                }
                $product = Title3::create($param);

            }

            return response()->json(['status'=>'success']);
            
        } else{
      
            $data['edit'] = DB::table('title3')->where('product_id',$request->product_id)->first();
            $data['product_id'] = Product::where('id',$request->product_id)->value('id');
            // dd($data['product_id']);
            return view('adminseller.product.title3')->with($data);
        }
    }
    public function tagproduct(Request $request)
    {
        $is_saved = $request->has('is_saved');
        if($is_saved)
        {
          
            $param = $request->all();
            // dd($param);
            unset($param['_token'],$param['is_saved']);
            $data = Tag::where('product_id',$request->product_id)->first();
            if($data){
                
                $product = Tag::where('product_id',$request->product_id)->update($param);
            }else{
                
                $product = Tag::create($param);

            }

            return response()->json(['status'=>'success']);
            
        } else{
      
            $data['edit'] = DB::table('tag')->where('product_id',$request->product_id)->first();
            $data['product_id'] = Product::where('id',$request->product_id)->value('id');
            // dd($data['product_id']);
            return view('adminseller.product.tag')->with($data);
        }
    }
    public function image_general(Request $request)
    {
        // dd($request->all());
        $param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;
        unset($param['_token']);

        if ($request->hasFile('image')) {
			$name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/product/"));
            $param['image']= $name;
        }
        $image = ProductImage::create($param);
        $image->save();

       return view('adminseller.product.image_display',compact('image'));
    }

    public function inventory_update(Request $request)
    {
        $is_saved = $request->has('is_saved');
        if(!$is_saved)
        {
            $product = Product::findOrFail($request->product_id);
            // dd($product->toArray());
            $selected_lot = [];
            $selected_lot1 = [];
            foreach($product->product_inventories as $lot){
                $selected_lot[$lot['color_id']][$lot['size_id']] = $lot['inventory'];
                $selected_lot1[$lot['color_id']][$lot['size_id']] = $lot['min_order_qty'];
            }
            // dd($selected_lot,$selected_lot1);
            return view('adminseller.product.inventory_tab',compact('product','selected_lot','selected_lot1'));
        } else{
            // dd($request->all());
            $product = Product::findOrFail($request->product_id);
            $params = $request->all();
            $old_data = ProductInventory::where('id',$request->id)->value('inventory');
            if ($request->type == 'add') {
                 $module = 'product inventory add';
            }else{
                $module = 'product inventory remove';
            }
            $save_array = [];
            foreach($params['min_order_qty'] as $color_id=>$min_qty) {
                foreach($min_qty as $size_id=>$qty) {
                    $save_array[$color_id.'_'.$size_id] = new ProductInventory([
                        'product_id' => $request->product_id,
                        'color_id' => $color_id,
                        'size_id' => $size_id,
                        'min_order_qty' => $qty,
                        'inventory' => isset($params['quantity'][$color_id][$size_id])? $params['quantity'][$color_id][$size_id] : 0,
                        // 'inventory_offline' => isset($params['quantity_offline'][$color_id][$size_id])? $params['quantity_offline'][$color_id][$size_id] : 0,
                    ]);
                }
            }
            $product->product_inventories()->delete();

            if (Auth::guard('vendor')->check()) {
                UpdateRecords::create([
                    'user_id'=> Auth::guard('vendor')->user()->id,
                    'role' => 'vendor',
                    'product_id' => $request->product_id,
                    'module' => $module,
                    'old_data' => $old_data,
                    'new_data' => $request->value
                ]);
            }else{
                UpdateRecords::create([
                    'user_id'=> Auth::guard('admin')->user()->id,
                    'product_id' => $request->product_id,
                    'module' => $module,
                    'old_data' => $old_data,
                    'new_data' => $request->value
                ]);
            }
            $product->product_inventories()->saveMany($save_array, true);

            return response()->json(['status'=>'success']);
        }
    }
    public function option_update(Request $request)
    {
        $param = $request->all();
        $option_id = $param['product']['option_id'];
        
        $option_id=array_filter($option_id);
        $param = $request->all();
        $product = Product::findOrFail($param['product_id']);

        $product->optionvalues()->sync($option_id, true);

        $res['status'] = 'success';
        $res['message'] = 'Option Save successfully';
        return response()->json($res);
    }

    public function lot_inventory_update(Request $request)
    {
        $is_saved = $request->has('is_saved');
        if(!$is_saved)
        {
            $product = Product::findOrFail($request->product_id);

            $selected_lot = [];
            foreach($product->product_lots as $lot){
                $selected_lot[$lot['color_id']][$lot['size_id']] = $lot['inventory'];
            }
            // dd($selected_lot);
            return view('adminseller.product.lot_tab',compact('product', 'selected_lot'));
        } else{
            // dd($request->all());
            $product = Product::findOrFail($request->product_id);
            $params = $request->all();
            $save_array = [];
            foreach($params['quantity'] as $color_id=>$quantity) {
                 foreach($quantity as $size_id=>$qty) {
                    $save_array[$color_id.'_'.$size_id] = new ProductLot([
                        'product_id' => $request->product_id,
                        'color_id' => $color_id,
                        'size_id' => $size_id,
                        'inventory' => isset($params['quantity'][$color_id][$size_id])? $params['quantity'][$color_id][$size_id] : 0,
                    ]);
             }
            }
            // foreach($params['quantity'] as $color_id=>$quantity) {
            //     $lot=[];
            //     foreach($quantity as $size=>$qty) {
            //         $lot[]= $size.'-'.$qty;
            //     }
            //          $lot=implode(' | ',$lot);
            //         $save_array[$color_id]= new ProductLot([
            //             'product_id' => $request->product_id,
            //             'color_id' => $color_id,
            //             'lot' => $lot,
            //         ]);
            // }
            $product->product_lots()->delete();
            $product->product_lots()->saveMany($save_array, true);

            return response()->json(['status'=>'success']);
        }
    }
    public function get_color_popup($id, Request $request)
    {
        if($request->isMethod('post')) {
            $product_image = ProductImage::find($id);
            $product_image->color_id = $request->get('color_id');
            $product_image->save();

            $color_name = $product_image->colors->name;
            return response()->json(['status'=>'success', 'message'=>'Image Color Added Successfully.', 'color_name'=>$color_name, 'id'=>$id]);
        } else {
            $product = Product::findOrFail($request->get('product_id'));
            $color_id = $request->get('color_id'); 
            
            return view('adminseller.product.image_color_popup',compact('product', 'color_id', 'id'));
        }      
    }
    public function get_discount_popup(Request $request)
    {
        $product = explode(',', $request->get('id'));
		// dd($id_array);
        $get_discount = Discount::where('deleted_at',NULL)->select('id','discount_per')->get();
        $discounts = Discount::whereNull('discount_code')
            ->whereNull('discount_for')
            ->where('status', 1)
            ->get();
        // dd($get_discount);
        return view('adminseller.product.product_discount_popup',compact('get_discount','discounts','product'));
        
    }
    public function price_update(Request $request)
    {
        // echo "Sdfsdf";
        // exit;
        $is_saved = $request->has('is_saved');
        if(!$is_saved)
        {
            // echo "<pre>";
            // echo "SDFsf";
            // exit;
            // dd('if');
            $product = Product::findOrFail($request->product_id);
            //findOrFail($request->product_id);
            // dd($product);
            $selected_lot = [];
            $selected_lot_whole_sale = [];
            $selected_lot_whole_sale_quantity = [];
            foreach($product->product_prices as $lot){
                $selected_lot[$lot['color_id']][$lot['size_id']] = $lot['price'];
                $selected_lot_whole_sale[$lot['color_id']][$lot['size_id']] = $lot['wholesale_price'];
                $selected_lot_whole_sale_quantity[$lot['color_id']][$lot['size_id']] = $lot['wholesale_quantity'];
            }
            // dd($selected_lot);
            return view('adminseller.product.price_tab',compact('product', 'selected_lot', 'selected_lot_whole_sale','selected_lot_whole_sale_quantity'));
        } else{
            // dd($request->all());
            $product = Product::findOrFail($request->product_id);
            $params = $request->all();
            $save_array = [];
            foreach($params['price'] as $color_id=>$price) {
                 foreach($price as $size_id=>$qty) {
                    $save_array[$color_id.'_'.$size_id] = new ProductPrice([
                        'product_id' => $request->product_id,
                        'currency_id' =>1,
                        'color_id' => $color_id,
                        'size_id' => $size_id,
                        'price' => isset($params['price'][$color_id][$size_id])? $params['price'][$color_id][$size_id] : 0,
                        // 'price_offline' => isset($params['price'][$color_id][$size_id])? $params['price'][$color_id][$size_id] : 0,
                        // 'wholesale_quantity' => isset($params['wholesale_quantity'][$color_id][$size_id])? $params['wholesale_quantity'][$color_id][$size_id] : 0,
                        'tax_type' => isset($params['tax'][$color_id][$size_id])? $params['tax'][$color_id][$size_id] : 0,
                        'wholesale_price' => isset($params['wholesale_price'][$color_id][$size_id])? $params['wholesale_price'][$color_id][$size_id] : 0,
                        // 'wholesale_price_offline' => isset($params['wholesale_price'][$color_id][$size_id])? $params['wholesale_price'][$color_id][$size_id] : 0,
                    ]);
             }
            }
            $product->product_prices()->delete();
            if (Auth::guard('vendor')->check()) {
                UpdateRecords::create([
                    'user_id'=> Auth::guard('vendor')->user()->id,
                    'role' => 'vendor',
                    'product_id' => $request->product_id,
                    'module' => 'product price'
                ]);
            }else{
                UpdateRecords::create([
                    'user_id'=> Auth::guard('admin')->user()->id,
                    'product_id' => $request->product_id,
                    'module' => 'product price'
                ]);
            }
            $product->product_prices()->saveMany($save_array, true);

            return response()->json(['status'=>'success']);
        }
    }

    public function product_price_update(Request $request){
        $param = $request->all();
        unset($param['_token']);
        $old_data = ProductPrice::where('id',$request->id)->value('price');
        $update = ProductPrice::where('id',$request->id)->update($param);

        if (Auth::guard('vendor')->check()) {
                UpdateRecords::create([
                    'user_id'=> Auth::guard('vendor')->user()->id,
                    'role' => 'vendor',
                    'product_id' => $request->product_id,
                    'module' => 'product price',
                    'old_data' => $old_data,
                    'new_data' => $request->price
                ]);
            }else{
                UpdateRecords::create([
                    'user_id'=> Auth::guard('admin')->user()->id,
                    'product_id' => $request->product_id,
                    'module' => 'product price',
                    'old_data' => $old_data,
                    'new_data' => $request->price
                ]);
            }

        if ($update) {
            return response()->json(['status'=>'success']);
        }else{
             return response()->json(['status'=>'error']);
        }
    }

    public function product_priceselling_update(Request $request){
        $param = $request->all();
        unset($param['_token']);

        $old_data = ProductPrice::where('id',$request->id)->value('wholesale_price');
        $update = ProductPrice::where('id',$request->id)->update($param);

        if (Auth::guard('vendor')->check()) {
                UpdateRecords::create([
                    'user_id'=> Auth::guard('vendor')->user()->id,
                    'role' => 'vendor',
                    'product_id' => $request->product_id,
                    'module' => 'product selling price',
                    'old_data' => $old_data,
                    'new_data' => $request->wholesale_price
                ]);
            }else{
                UpdateRecords::create([
                    'user_id'=> Auth::guard('admin')->user()->id,
                    'product_id' => $request->product_id,
                    'module' => 'product selling price',
                    'old_data' => $old_data,
                    'new_data' => $request->wholesale_price
                ]);
            }

        if ($update) {
            return response()->json(['status'=>'success']);
        }else{
             return response()->json(['status'=>'error']);
        }
    }

    public function product_inventory_update(Request $request){
        
        $update = ProductInventory::findOrFail($request->id);
        $old_data = ProductInventory::where('id',$request->id)->value('inventory');
        
        if ($request->type == 'add') {
           $update->inventory = $update->inventory + $request->value;
           $module = 'product inventory add';
        }else{
            $update->inventory = $update->inventory - $request->value;
            $module = 'product inventory remove';
        }
       
        $update->save();
        
        if (Auth::guard('vendor')->check()) {
                UpdateRecords::create([
                    'user_id'=> Auth::guard('vendor')->user()->id,
                    'role' => 'vendor',
                    'product_id' => $request->product_id,
                    'module' => $module,
                    'old_data' => $old_data,
                    'new_data' => $request->value
                ]);
            }else{
                UpdateRecords::create([
                    'user_id'=> Auth::guard('admin')->user()->id,
                    'product_id' => $request->product_id,
                    'module' => $module,
                    'old_data' => $old_data,
                    'new_data' => $request->value
                ]);
            }

        if ($update) {
            return response()->json(['status'=>'success']);
        }else{
             return response()->json(['status'=>'error']);
        }
    }

    public function updateDiscount(Request $request) {
        if($request->isMethod('post')) {
            // dd('inif');
            $param = $request->all();
            $product = Product::findOrFail($param['product_id']);
            $discount_array = [];
            $message = "Discount Remove Successfully.";
            if($param['discount'] != '') {
                $discount_array = [$param['discount']];
                $message = "Discount Apply Successfully.";
            }
            $product->discounts()->sync($discount_array,true);
            return response()->json(['status'=>'success', 'message'=>$message]);
        } else {
            // dd('else');
            $today =  Carbon::now()->format('Y-m-d H:i:s');
            $product = Product::findOrFail($request->product_id);
            // $discounts = Discount::whereNull('discount_code')
            // ->whereNull('discount_for')
            // ->where('status', 1)
            // ->get();
            $discounts = Discount::where('status', 1)
            ->get();

            // dd($discounts);
            
            return view('adminseller.product.discount_tab',compact('product', 'discounts'));
        }
    }

    public function importProduct(Request $request) {
        // dd($request->file());
        if($request->ajax() && $request->isMethod('post')){
            Excel::import(new ProductImport, $request->file('product_excel'));
            return response()->json(['status'=>'success']);
        } else {
            return view('adminseller.product.import_product');
        }
    }

    public function destory(Request $request)
    {
        $result = Product::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
        
    }

    public function vendorproduct(Request $request){
    	if ($request->ajax()) {
            $query = Product::where('vendor_id',Auth::guard('vendor')->user()->id)->get();
            
            return Datatables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'vendor.product','delete' => route('admin.'.$this->route.'.destory')])->render();
                    return $btn;
                })
                ->addColumn('checkbox', function ($row) {
                    $chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
                    return $chk;
                })
                ->addColumn('vendor', function ($row) {
                    $name = User::where([['status',1],['role',1],['id',$row->vendor_id]])->value('fname');
                    return $name;
                })
                ->addColumn('product_price', function ($row) {
                    $price = ProductPrice::where('product_id',$row->id)->get();
                    $schk = view('admin.layout.product_price')->with([
                        'id' => $row->id, 
                        'price' => isset($price) ? $price : ''])->render();
                    return $schk;
                })
                ->addColumn('selling_product_price', function ($row) {
                    $sprice = ProductPrice::where('product_id',$row->id)->get();
                    $schk = view('admin.layout.selling_product_price')->with([
                        'id' => $row->id, 
                        'price' => isset($sprice) ? $sprice : ''])->render();
                    return $schk;
                })
                ->addColumn('deals', function ($row) {
                    $topdeals = view('admin.layout.topdeals')->with(['id' => $row->id, 'status' => $row->topdeals])->render();
                    return $topdeals;
                })
                ->addColumn('visibility', function ($row) {
                    // $topdeals = view('admin.layout.topdeals')->with(['id' => $row->id, 'status' => $row->topdeals])->render();
                    return 0;
                })
                ->addColumn('singlecheckbox', function ($row) {
                    $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id, 'status' => $row->status])->render();
                    return $schk;
                })
                ->addColumn('type', function ($row) {
                    if($row->type == 0)
                    {
                        $schk = 'Both';
                    }elseif($row->type == 1){
                        $schk = 'Online';
                    }elseif($row->type == 2)
                    {
                        $schk = 'Offline';
                    }
                    return $schk;
                })
                ->setRowClass(function () {
                    return 'row-move';
                })
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
                ->rawColumns(['checkbox', 'vendor','product_price','deals','selling_product_price','singlecheckbox','visibility','action','type'])
                ->make(true);
        }
        return view('adminseller.' . $this->view . '.index');
    }

    public function product_price_history(Request $request,$id){
        $data['id'] = $id;
        if ($request->ajax()) {
            $query = UpdateRecords::where('product_id',$id)->get();
            // $query = Product::where('vendor_id',Auth::guard('vendor')->user()->id)->get();
            
            return Datatables::of($query)
                ->addColumn('date', function ($row) {
                    $date = date('d-m-Y',strtotime($row->created_at));
                    return $date;
                })
                ->addColumn('name', function ($row) {
                    if ($row->user_id == 1) {
                        $name = 'admin';
                    }else{
                        $name = User::where([['status',1],['id',$row->user_id]])->value('fname').' (vendor)';
                    }
                    return $name;
                })
                
                
                ->rawColumns(['date','name'])
                ->make(true);
        }
        return view('adminseller.' . $this->view . '.history')->with($data);
    }
}