<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use DB;
class UserController extends Controller
{
    public function __construct(User $s)
    {
        $this->view = 'customer';
        $this->route = 'customer';
        $this->viewName = 'Customer';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type)
    {
        $data['type'] = $type;
        if ($request->ajax()) {
			if ($type == 'all') {
                $query = User::where('role',0)->latest()->get();
            }else{
			 $query = User::where([['status', $type],['role',0]])->latest()->get();
            }
			
			return Datatables::of($query)
				->addColumn('singlecheckbox', function ($row) {
					$schk = view('admin.layout.activecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
					return $schk;
                })
				->rawColumns(['singlecheckbox'])
				->make(true);
		}
        return view('adminseller.user.index')->with($data);
    }
    public function change_status(Request $request)
    {
     
		$table_name = $request->get('table_name');
		$param = $request->get('param');
		$id_array = explode(',', $request->get('id'));

		try {

			if ($param == 0) {
				foreach ($id_array as $id) {
					DB::table($table_name)->where('id', $id)
						->update([
							'status' => 1,
						]);
				}
			} elseif ($param == 1) {
				foreach ($id_array as $id) {
					DB::table($table_name)->where('id', $id)
						->update([
							'status' => 0,
						]);
				}
			}

			$res['status'] = 'Success';
			$res['message'] = 'Status Change successfully';
		} catch (\Exception $ex) {
			$res['status'] = 'Error';
			$res['message'] = 'Something went wrong.';
		}
		return response()->json($res);
	
    }
}
