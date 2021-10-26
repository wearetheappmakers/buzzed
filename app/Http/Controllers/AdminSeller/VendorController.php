<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Membership;
use DataTables;
use DB;
use Hash;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function __construct(User $s)
    {
        $this->view = 'vendors';
        $this->route = 'vendors';
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
                $query = User::where('role',1)->latest()->get();
            }else{
			 $query = User::where([['status', $type],['role',1]])->latest()->get();
            }
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route,'delete' => route('admin.'.$this->route.'.destory') ])->render();
					return $btn;
				})
				->addColumn('singlecheckbox', function ($row) {
					$schk = view('admin.layout.activecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
					return $schk;
                })
				->rawColumns(['singlecheckbox','action'])
				->make(true);
		}
		$data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        return view('adminseller.vendors.index')->with($data);
    }

    public function create()
    {
        $data['url'] = route('admin.' . $this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['index'] = route('admin.' . $this->route . '.index','all');

        return view('adminseller.vendors.create')->with($data);
    }

    public function store(Request $request)
    {
        $param = $request->all();
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);
        $param['role'] = 1;
        unset($param['amount']);
        unset($param['payment_type']);

        $customer = User::create($param);

        if ($customer){
            Membership::create([
                'customer_id' => $customer->id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'validity' => Carbon::now()->addYear(),
            ]);
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
      
    }

    public function edit(Request $request,$id)
    {
    	$data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = User::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['index'] = route('admin.' . $this->route . '.index','all');
        $data['membership'] = Membership::where('customer_id',$id)->latest()->first();

		return view('adminseller.vendors.edit')->with($data);
    }

    public function update(Request $request)
    {
        $param = $request->all();
        $password = User::findOrFail($request->id);
        unset($param['_token']);
        unset($param['id']);
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);

    	$vendor = User::where('id',$request->id)->update($param);

        if ($vendor){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}

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

    public function show($id)
    {
        //
    }

    public function destory(Request $request)
    {
        $result = User::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}
