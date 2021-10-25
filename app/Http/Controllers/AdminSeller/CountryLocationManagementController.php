<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Countries;
use DataTables;
use DB;
use Hash;

class CountryLocationManagementController extends Controller
{
	public function __construct(Countries $model)
    {
        $this->view = 'country';
        $this->route = 'country';
        $this->viewName = 'Country';
        $this->model =  $model;
    }

	public function index(Request $request){
		
		$data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;

		if ($request->ajax()) {
			$query = Countries::latest()->get();

			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route,'delete' => route('admin.'.$this->route.'.destory') ])->render();
					return $btn;
				})
				->addColumn('checkbox', function ($row) {
					$chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
					return $chk;
				})
				->addColumn('singlecheckbox', function ($row) {
					$schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
					return $schk;
                })

				->rawColumns(['checkbox', 'singlecheckbox','action'])
				->make(true);
		} 
        return view('adminseller.'.$this->view . '.index')->with($data);
	}

	public function create()
    {
    	$data['url'] = route('admin.'.$this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;

        return view('admin.general.add_form')->with($data);
    }

    public function store(Request $request)
    {
    	$param = $request->all();
    	$param['status'] = isset($param['status']) ? $param['status'] : 0;

    	$country = Countries::create($param);

        if ($country){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }

    public function edit(Request $request,$id)
    {
    	$data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Countries::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        
		return view('admin.general.edit_form', compact('data'));
    }

    public function update(Request $request)
    {
    	$param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        $country = Countries::findOrFail($request->id);
        $country->name = $param['name'];
        $country->phonecode = $param['phonecode'];
        $country->status = $param['status'];
        $country->save();
        
        if ($country){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }

    public function destory(Request $request)
    {
    	$result = Countries::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}