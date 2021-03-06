<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ImageHelper;
use DataTables;
use App\Http\Requests\ColorRequest;
use DB;

class StaffController extends Controller
{
    public function __construct(Staff $s)
    {
        $this->view = 'staff';
        $this->route = 'staff';
        $this->viewName = 'Staff';
        $this->model = $s;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = $this->model->get();
            // echo "<pre>";
            // print_r($query);
            // exit;
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route,'delete' => route('admin.'.$this->route.'.destory')])->render();
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

        $data['module']= $this->viewName;
        $data['url']= route('admin.'.$this->route . '.index');
        $data['create']= route('admin.'.$this->route . '.create');

        return view('adminseller.'.$this->view . '.index')->with($data);
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
        // echo "Sd";
        // exit;
        // dd($request->all());
        $param = $request->all();
        $status=empty($request->status)? 0 : $request->status;
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);
        unset($param['status']);

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/users/"));
            $param['image']= $name;
        }

        $color = $this->model->create($param);
        $color->status=$status;
        $color->save();

        if ($color){
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
        $data['edit'] = $this->model->findOrFail($id);
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
        $user = $this->model->findOrFail($id);
        $status=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method'],$param['status']);
        $param['password'] = isset($param['spassword']) ? bcrypt($param['spassword']) : bcrypt(12345678);

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, 'Product', storage_path("app/public/uploads/users/"), $user->image);
            $param['image']= $name;
        }
        
        $color = $this->model->where('id', $id)->first();
        $color->status=$status;
        $color->update($param);
        
        if ($color){
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
    public function destory(Request $request)
    {
        $result = $this->model->where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
        
    }
}
