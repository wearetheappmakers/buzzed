<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ProductInventory;
use DataTables;
use DB;
use App\Models\UpdateRecords;
use App\Models\OrderLine;

class InventoryController extends Controller
{
    
    public function index(Request $request)
    {
        $data['get_data'] = DB::table('product_inventories as pi')
        ->leftJoin('products as pp','pp.id','pi.product_id')
        ->leftJoin('colors as cc','cc.id','pi.color_id')
        ->leftJoin('sizes as ss','ss.id','pi.size_id')
        ->where('pi.status',1)
        ->select('pi.*','cc.name as color_name','ss.name as size_name','pp.name as product_name')
        ->get();
        
        return view('adminseller.inventory.index')->with($data);
    }

    public function update(Request $request)
    {
        $update_inventory = $request->update_inventory;
        foreach ($update_inventory as $key => $value) {
            $inventory = DB::table('product_inventories')
            ->where('id',$key)
            ->value('inventory');
            $inventory = $value + $inventory;
            $updated = DB::table('product_inventories')
            ->where('id',$key)
            ->update(['inventory'=>$inventory]);
        }

        return response()->json(['status'=>'success']);
    }
    public function indexoffline(Request $request)
    {
        $data['get_data'] = DB::table('product_inventories as pi')
        ->leftJoin('products as pp','pp.id','pi.product_id')
        ->leftJoin('colors as cc','cc.id','pi.color_id')
        ->leftJoin('sizes as ss','ss.id','pi.size_id')
        ->where('pp.type','!=',1)
        ->where('pi.status','=',1)
        ->select('pi.*','cc.name as color_name','ss.name as size_name','pp.name as product_name')
        ->get();

        return view('adminseller.inventory.indexoffline')->with($data);
    }
    public function updateoffline(Request $request)
    {
        $update_inventory = $request->update_inventory;
        foreach ($update_inventory as $key => $value) {
            $inventory = DB::table('product_inventories')
            ->where('id',$key)
            ->value('inventory_offline');
            $inventory = $value + $inventory;
            $updated = DB::table('product_inventories')
            ->where('id',$key)
            ->update(['inventory_offline'=>$inventory]);
        }

        return response()->json(['status'=>'success']);
    }
    public function report(Request $request)
    {
        $data['get_data'] = DB::table('product_inventories as pi')
        ->leftJoin('products as pp','pp.id','pi.product_id')
        ->leftJoin('colors as cc','cc.id','pi.color_id')
        ->leftJoin('sizes as ss','ss.id','pi.size_id')
        ->where('pi.status','=',1)
        ->select('pi.*','cc.name as color_name','ss.name as size_name','pp.name as product_name')
        ->get();

        return view('adminseller.inventory.report')->with($data);
    }

    public function history(Request $request,$id)
    {

        $data['history'] = OrderLine::where('cancle_status',0)
                        ->leftJoin('users as user','user.id','order_lines.customer_id')
                        ->where('product_id',$id)
                        ->select('order_lines.*','user.*','order_lines.created_at as order_create','order_lines.id as orderid')
                        ->get();

        $data['records'] = UpdateRecords::where('product_id',$id)->get();

        return view('adminseller.inventory.history')->with($data);
    }
}
