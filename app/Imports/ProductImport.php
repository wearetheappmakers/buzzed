<?php

namespace App\Imports;

use App\Models\OptionValue;
use App\Models\ProductOptionValue;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductPrice;
use App\Models\Color;
use App\Models\Discount;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductInventory;
use App\Models\ProductLot;
use App\Models\Size;
use App\Seller;
use DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // dump($row);
        $product_id = $this->addProduct($row);
        $product = Product::find($product_id);

        $category = $this->Category($product, $row);
        $option = $this->Options($product, $row);

        $size_array = $this->Size($product, $row);

        $color_array = $this->Color($product, $row);
        
        $product_inventory = $this->ProductInventory($product,$size_array,$color_array, $row);

        $product_price = $this->ProductPrice($product,$size_array,$color_array, $row);

        $product_discount = $this->ProductDiscount($product, $row);
        return $product;

        // return $product;
    }

    public static function addProduct($row) {
        // dump($row);
        $product = Product::where('sku',  $row['sku_id'])->first();
        // $products= Product::get()->toArray();
        // echo "<pre>";
        
        // exit;

        if($row['colour_name'] == '' && $row['size'] == '') {
            $product_type = 1;
        } elseif($row['colour_name'] == ''&& $row['size'] != '') {
            $product_type = 2;
        }elseif($row['colour_name'] != '' && $row['size'] == '') {
            $product_type = 3;
        }else{
            $product_type = 4;
        }
        if(!$product) {
            $product = new Product();
            $product->sku = $row['sku_id'];
        }
        $product->product_code = $row['product_code'];
        $product->name = $row['product_title'];
        $product->description = $row['description'];
        if($row['maximum_order_quantity'] != '') {
            $product->moq = $row['maximum_order_quantity'];
        }
       
        if($row['hsn_code']) {
            $product->hsn_code = $row['hsn_code'];
        }
        $product->product_type = $product_type ;
        $product->status = 1;
        // $product->deleted_at = NULL;
        try {
            $product->save();
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
        // dd($product);
        $product_id = $product->id;
        return $product_id;
    }

    public static function Options($product, $row) {
        $option_id = [
            1 => 'estimated_delivery_days',
            2 => 'occasion',
            3 => 'material',
            4 => 'item_weight',
            5 => 'length',
            6 => 'width',
            7 => 'height',
            8 => 'product_shape',
            9 => 'layer',
            10 => 'embossed',
            11 => 'printeddesign',
            12 => 'design',
            14 => 'recommended_use',
            15 => 'is_disposable',
            16 => 'is_multiuse',
            17 => 'is_dishwasher_safe',
            18 => 'is_microwave_safe',
            19 => 'condition',
            20 => 'manufacturer',
            21 => 'country_of_origin',
            22 => 'property',
            23 => 'lengthpacking',
            24 => 'widthpacking',
            25 => 'heightpacking'];

        $option_id_array = [];
        foreach($option_id as $o_id=>$o_name) {
            if($row[$o_name] != '') {
                $option = OptionValue::
                where('name', $row[$o_name])
                ->where('option_id', $o_id)
                ->first();

                if(!$option) {
                    $option = new OptionValue();
                    $option->name =  $row[$o_name];
                    $option->option_id = $o_id;
                }
                $option->status = 1;
                $option->deleted_at = NULL;
                $option->save();

                $option_id_array[] = $option['id'];
                  
            }
        }
        // echo "<pre>";
        // print_R($option_id_array);
        // exit;
        $product->optionvalues()->sync($option_id_array, true);
    }

    public static function Category($product, $row) {
         $category  = Category::where('name', $row['main_category'])->whereNull('parent_id')->first();
        if(!$category) {
            $category = new Category();
            $category->name = $row['main_category'];            
        }
        $category->status=1;
        $category->deleted_at=NULL;
        $category->save();
        $cat_id_array = [$category['id']];

        $sub_category  = Category::where('name', $row['sub_category_1'])->where('parent_id', $category['id'])->first();
        if(!$sub_category) {
            $sub_category = new Category();
            $sub_category->name = $row['sub_category_1'];
        }
        $sub_category->parent_id = $category['id'];
        $sub_category->status=1;
        $sub_category->deleted_at=NULL;
        $sub_category->save();
        $cat_id_array[] = $sub_category['id'];

        $sub_category_2  = Category::where('name', $row['sub_category_2'])->where('parent_id', $sub_category['id'])->first();
        if(!$sub_category_2) {
            $sub_category_2 = new Category();
            $sub_category_2->name = $row['sub_category_2'];
        }
        $sub_category_2->parent_id = $sub_category['id'];
        $sub_category_2->status=1;
        $sub_category_2->deleted_at=NULL;
        $sub_category_2->save();
        $cat_id_array[] = $sub_category_2['id'];

        $product->categories()->sync($cat_id_array ,true);
    }

    public static function Size($product, $row) {
        $size_array = [];
        if($row['size'] == '') {
            $sizes = [1];
        } else {
            $sizes = explode(',', $row['size']); 
        } 
                   
        foreach($sizes  as $size_n) {
            $size = Size::where('name', trim($size_n))
                ->first();
            if(!$size) {
                $size = new Size();
                $size->name =  trim($size_n);
            }
            $size->status = 1;
            $size->deleted_at = NULL;
            $size->save();
            $size_array[] = $size['id'];
        }
        $product->sizes()->sync($size_array, true);
        return $size_array;
    }

    public static function Color($product, $row) {
        $color_array = [];
        $colors_map = [];
        // dd($row['color_map']);
        if($row['colour_name'] == '') {
            // dd('Hello');
            $colors = [1];
        } else {
            // dd('HI');
            $colors = explode(',', $row['colour_name']); 
            $colors_map = explode(',', $row['color_map']);
            // dd($colors_map);
        } 
            
        foreach($colors as $key => $color_n) {
            // dd($colors_map[$key]);
            $color = Color::where('name', trim($color_n))
                ->first();
            if(!$color) {
                $color = new Color();
                $color->name =   trim($color_n);
            }
            $color->status = 1;
            $color->deleted_at = NULL;
            $color->save();
            $color_array[] = ['color_id' => $color['id'], 'color_map' => isset($colors_map[$key]) ? $colors_map[$key] : NULL ];
        }
        $product->colors()->sync($color_array, true);
       return $color_array;
    }

    public static function ProductInventory($product,$size_array,$color_array, $row) {

        if($row['quantity'] == '') {
            $quantity = [0];
        } else {
            $quantity =  explode(',', $row['quantity']); 
        } 
         
        foreach($color_array as $clr) {
            foreach($size_array as $key=>$sz){
                $product_inventory = ProductInventory::
                where('size_id', $sz)
                ->where('color_id', $clr['color_id'])
                ->where('product_id', $product['id'])
                ->first();

                if(!$product_inventory) {
                    $product_inventory = new ProductInventory();
                    $product_inventory->size_id =  $sz;
                    $product_inventory->color_id = $clr['color_id'];
                    $product_inventory->product_id = $product['id'];
                }
                $product_inventory->inventory = $quantity[$key];
                $product_inventory->min_order_qty = 1;
                $product_inventory->save();
            }
        }
    }


    public static function ProductPrice($product,$size_array,$color_array, $row) {
        foreach($color_array as $clr) {
            foreach($size_array as $key=>$sz){
                $product_price = ProductPrice::
                where('size_id', $sz)
                ->where('color_id', $clr['color_id'])
                ->where('product_id', $product['id'])
                ->where('currency_id', 1)
                ->first();

                if(!$product_price) {
                    $product_price = new ProductPrice();
                    $product_price->size_id =  $sz;
                    $product_price->color_id = $clr['color_id'];
                    $product_price->product_id = $product['id'];
                    $product_price->currency_id = 1;
                }
                $product_price->price = ($row['mrp'] != '' ? $row['mrp'] : 0);
                $product_price->save();
            }
        }
    }

    public static function ProductDiscount($product, $row) {
        if($row['off'] != '') {
            $today = Carbon::now()->format('Y-m-d H:i:s');
            $discount = Discount::where('discount_per', trim($row['off']))
            ->where('discount_start_date', '<=', $today)
            ->where('discount_end_date', '=', '2030-08-17 12:00:00')
            ->first();
            if(!$discount) {
                $discount = new Discount();
                $discount->discount_start_date = $today;
                $discount->discount_end_date = '2030-08-17 12:00:00';
                $discount->discount_per = trim($row['off']);
                $discount->save(); 
            }
            $product->discounts()->sync([$discount->id], true);
        } 
    }

    public function rules(): array
    {
        return [
            '*.product_title' => 'required',
            '*.sku_id' => 'required',
            '*.main_category' => 'required',
            '*.sub_category_1' => 'required',
            '*.sub_category_2' => 'required',
            '*.mrp'=>'required',
            '*.quantity' => 'required',
            '*.estimated_delivery_days' => 'required',
            '*.description' => 'required',
            '*.material'=>'required',
            '*.size'=>'required',
            '*.item_weight'=>'required',
            '*.length'=>'required',
            '*.width'=>'required',
            '*.height'=>'required',
            '*.country_of_origin'=>'required',
        ];
    }
}