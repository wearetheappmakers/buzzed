<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Admin;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DB;
use Illuminate\Support\Facades\Hash;

class PermissionController extends Controller
{
    public function __construct(Admin $s)
    {
        $this->view = 'permission';
        $this->route = 'permission';
        $this->viewName = 'Permission';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Admin::get();
            // echo "<pre>";
            // print_r($query);
            // exit;
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.permission'])->render();
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
                
				->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
				->rawColumns(['checkbox', 'singlecheckbox','action'])
				->make(true);
		} 
        return view('adminseller.'.$this->view . '.index');
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

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->all();
        $param['viewpassword'] = $param['password'];
        $param['password'] = Hash::make($request->password);

        $permission = Admin::create($param);
        $permission->save();

        if ($permission){
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
        $data['edit'] = Admin::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        
		return view('admin.general.edit_form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = $request->all();
        if($request->password)
        {
            $param['viewpassword'] = $param['password'];
            $param['password'] = Hash::make($request->password);
        }else{
            unset($param['password']);
        }
        unset($param['_token'], $param['_method']);
        // dd($param);
        
        $param['products'] = isset($request->products) ? 1 : 0;
        $param['inventory'] = isset($request->inventory) ? 1 : 0;
        $param['orders'] = isset($request->orders) ? 1 : 0;
        $param['banner'] = isset($request->banner) ? 1 : 0;
        $param['blog'] = isset($request->blog) ? 1 : 0;
        $param['affliate'] = isset($request->affliate) ? 1 : 0;

        $permission = Admin::where('id', $id)->first();
        $permission->update($param);
        
        if ($permission){
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
}
