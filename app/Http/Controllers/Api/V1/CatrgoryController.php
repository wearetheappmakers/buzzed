<?php
namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CustomeHelper;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\Option;
use DB;

class CatrgoryController extends Controller
{
    public function index()
    {
        $data = Category::newtree();
        return response()->json(['success' => 1, 'records' => $data], 200);
    }
    public function category(Request $request)
    {
    	

        if($request->category_id == 0)
        {
            $today = Carbon::now()->format('Y-m-d H:i:s');
            $data = Product::with('product_images.colors', 'product_prices.currencies')
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
                    ])->paginate(12);
                    
            // $products = json_decode($data, true);
                    // dd($products);

            
            return response()->json(['success' => 1, 'records' => $data], 200);   
        }

        if(!($request->category_id)){
            return response()->json(['success'=>0,'records'=>'required category_id'],500);
        }

    	$data = DB::table('product_categories')->where('category_id',$request->category_id)->get();
    	foreach ($data as $key => $value) {
    		// $value['products'] =[];
    		// dd($value->product_id);
    		$value->product_id = Product::with('product_images')->where('id',$value->product_id)->first();
    		// $dd->toArray();
    		// $value['product_id'] = $dd->toArray();
    	}

        return response()->json(['success' => 1, 'records' => $data], 200);
    }
}
 