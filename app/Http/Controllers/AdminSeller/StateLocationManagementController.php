<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Countries;
use App\Models\State;
use DataTables;
use DB;
use Hash;

class StateLocationManagementController extends Controller
{
	public function __construct(State $model)
    {
        $this->view = 'state';
        $this->route = 'state';
        $this->viewName = 'State';
        $this->model =  $model;
    }

    public function index(Request $request){
        
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;

        if ($request->ajax()) {
            $query = State::with('country')->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route,'delete' => route('admin.'.$this->route.'.destory') ])->render();
                    return $btn;
                })
                ->addColumn('checkbox', function ($row) {
                    $chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
                    return $chk;
                })
                ->addColumn('country', function ($row) {
                    $country = $row->country->name;
                    return $country;
                })
                ->addColumn('singlecheckbox', function ($row) {
                    $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
                    return $schk;
                })

                ->rawColumns(['checkbox','country','singlecheckbox','action'])
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
        $data['countries'] = Countries::where('status',1)->get();

        return view('admin.general.add_form')->with($data);
    }

    public function store(Request $request)
    {
        $param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        $country = State::create($param);

        if ($country){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function edit(Request $request,$id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = State::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['countries'] = Countries::where('status',1)->get();
        
        return view('admin.general.edit_form', compact('data'));
    }

    public function update(Request $request)
    {
        $param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        $state = State::findOrFail($request->id);
        $state->name = $param['name'];
        $state->country_id = $param['country_id'];
        $state->status = $param['status'];
        $state->save();
        
        if ($state){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function destory(Request $request)
    {
        $result = State::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}