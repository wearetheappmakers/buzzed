<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Settings;


class HomeController extends Controller
{
	public function chartgetdata(Request $request)
	{
		$today_order = DB::table('order_headers')->where('created_at',today())->count();
		$month_order = DB::table('order_headers')->whereMonth('created_at', '=', date('m'))->count();

		return response()->json(array($today_order, $month_order));
	}
    public function changeMultipleStatus(Request $request)
	{
		// dd($request->all());
		$table_name = $request->get('table_name');
		$param = $request->get('param');
		$id_array = explode(',', $request->get('id'));
		// $params = explode(',', $request->get('params'));
		// dd($table_name);
		// return;
		try {

			if ($param == 0) {
				foreach ($id_array as $id) {
					// dd($id);
					DB::table($table_name)->where('id', $id)
						->update([
							$request->field => 0,
						]);
				}
			} elseif ($param == 1) {
				foreach ($id_array as $id) {
					// dd($id);
					DB::table($table_name)->where('id', $id)
						->update([
							$request->field => 1,
						]);
				}
			}

			if($table_name == 'settings') {
				$all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
				file_put_contents(base_path() .'/config/common.php',  '<?php return ' . var_export($all_setting, true) . ';');
			}

			$res['status'] = 'Success';
			$res['message'] = 'Status Change successfully';
		} catch (\Exception $ex) {
			$res['status'] = 'Error';
			$res['message'] = 'Something went wrong.';
		}
		return response()->json($res);
	}

	public function deleteMultiple(Request $request)
	{
		$table_name = $request->get('table_name');
		$id_array = explode(',', $request->get('id'));
		// dd($id_array);
		// return;
		try {
			if ($request->has('folder_name')) {
				foreach ($id_array as $id) {
					$records = DB::table($table_name)->where('id', $id)->first();
					if ($records->image != '' && $records->image) {
						try {
							// ImageHelper::deleteModuleMultipleImage($records->image, storage_path() . "/app/public/uploads/banner/");
						} catch (\Exception $ex) {
						}
					}
					if($table_name == 'product_images') {
						DB::table($table_name)->where('id', $id)->delete();
					}else {
						DB::table($table_name)->where('id', $id)->delete();
					}
				}
			} else {
				DB::table($table_name)->whereIn('id', $id_array)->delete();
			}

			if($table_name == 'settings') {
				DB::table($table_name)->whereIn('id', $id_array)->delete();
				$all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
				file_put_contents(base_path() .'/config/common.php',  '<?php return ' . var_export($all_setting, true) . ';');
			}
			$res['status'] = 'Success';
			$res['message'] = 'Deleted successfully';
		} catch (\Exception $ex) {
			
			$res['status'] = 'Error';
			$res['message'] = $ex->getMessage();//'Kindly delete child element.';
		}
		return response()->json($res);
	}

	public function discountMultiple(Request $request)
	{
		
		$id_array = explode(',', $request->get('id'));
		dd($id_array);
		
		
	}

	public function changeOrder(Request $request) {
        if ($request->ajax()) {
            $table_name = $request->get('table_name');
            $ids = $request->get('row');
            foreach ($ids as $key => $value) {
			     DB::table($table_name)->where('id', $value)
					->update([
						'order' => ($key),
					]);
            }
		}
		$res['status'] = 'Success';
		$res['message'] = 'Order Change successfully';
        return response()->json($res);
    }
}
