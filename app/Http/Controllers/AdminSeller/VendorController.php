<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Membership;
use App\Models\MembershipAmount;
use App\Helpers\ImageHelper;
use App\Imports\UsersExport;
use DataTables;
use DB;
use Hash;
use Excel;
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
                $query = User::where('role',1)->latest();
            }else{
			 $query = User::where([['status', $type],['role',1]])->latest();
            }
			return Datatables::of($query)
				->addColumn('action', function ($row) {

                    if (\Auth::guard('admin')->check()) {
                          $route = 'admin.'.$this->route;
                    }

                    if (\Auth::guard('manager')->check()) {
                         $route = 'manager.'.$this->route;
                    }

					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => $route,'delete' => route('admin.'.$this->route.'.destory') ])->render();
					return $btn;
				})
                ->editColumn('image', function ($row) use($type) {
                    return view('admin.layout.image')->with(['image'=>$row->image,'folder_name'=>'users']);
                    
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

        if (\Auth::guard('admin')->check()) {
             $data['create'] = route('admin.'.$this->route . '.create');
             $data['export'] = route('admin.'.$this->route . '.export');
        }

        if (\Auth::guard('manager')->check()) {
             $data['create'] = route('manager.'.$this->route . '.create');
             $data['export'] = route('manager.'.$this->route . '.export');
        }

        return view('adminseller.vendors.index')->with($data);
    }

    public function create()
    {
        

        if (\Auth::guard('admin')->check()) {
             $data['url'] = route('admin.' . $this->route . '.store');
             $data['index'] = route('admin.' . $this->route . '.index','all');
        }

        if (\Auth::guard('manager')->check()) {
             $data['url'] = route('manager.' . $this->route . '.store');
             $data['index'] = route('manager.' . $this->route . '.index','all');
        }

        $data['membershipamount'] = MembershipAmount::where('status',1)->get()->all();
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        

        return view('adminseller.vendors.create')->with($data);
    }

    public function store(Request $request)
    {
        $param = $request->all();
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);
        $param['role'] = 1;

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/users/"));
            $param['image']= $name;
        }

        if ($request->validity_duration == 6) {
            $validity = Carbon::now()->addMonths(6);
        }

        if ($request->validity_duration == 12) {
            $validity = Carbon::now()->addYear();
        }

        $param['validity_date'] = $validity;

        $customer = User::create($param);

        unset($param['payment_type']);
        unset($param['amount']);

        if ($customer){
            Membership::create([
                'customer_id' => $customer->id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'validity' => $validity,
                'validity_duration' => $request->validity_duration,
            ]);
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
      
    }

    public function edit(Request $request,$id)
    {
        if (\Auth::guard('admin')->check()) {
            $data['url'] = route('admin.' . $this->route . '.update');
            $data['index'] = route('admin.' . $this->route . '.index','all');
        }

        if (\Auth::guard('manager')->check()) {
            $data['url'] = route('manager.' . $this->route . '.update');
            $data['index'] = route('manager.' . $this->route . '.index','all');
        }

        $data['membershipamount'] = MembershipAmount::where('status',1)->get()->all();
    	$data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = User::findOrFail($id);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['membership'] = Membership::where('customer_id',$id)->latest()->first();

		return view('adminseller.vendors.edit')->with($data);
    }

    public function update(Request $request)
    {
        $param = $request->all();
        $user = User::findOrFail($request->id);
        unset($param['_token']);
        unset($param['id']);
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/users/"), $user->image);
            $param['image']= $name;
        }

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

    public function export(Request $request){
        return Excel::download(new UsersExport, 'users.csv');
    }
}
