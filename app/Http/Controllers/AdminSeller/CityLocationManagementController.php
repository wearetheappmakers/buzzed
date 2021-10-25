<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Countries;
use App\Models\State;
use App\Models\Cities;
use DataTables;
use DB;
use Hash;

class CityLocationManagementController extends Controller
{
	public function __construct(Cities $model)
    {
        $this->view = 'city';
        $this->route = 'city';
        $this->viewName = 'City';
        $this->model =  $model;
    }

    public function index(Request $request){
        
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        

        if ($request->ajax()) {
            $query = Cities::latest()->get();

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
                    $country = Countries::where('id',$row->country_id)->value('name');
                    return $country;
                })
                ->addColumn('states', function ($row) {
                    $state = State::where('id',$row->state_id)->value('name');
                    return $state;
                })
                ->addColumn('singlecheckbox', function ($row) {
                    $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
                    return $schk;
                })

                ->rawColumns(['checkbox','country','state','singlecheckbox','action'])
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
        $data['states'] = State::where('status',1)->get();

        return view('admin.general.add_form')->with($data);
    }

    public function store(Request $request)
    {
        $param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        $country = Cities::create($param);

        if ($country){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function edit(Request $request,$id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Cities::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['countries'] = Countries::where('status',1)->get();
        $data['states'] = State::where('status',1)->get();
        
        return view('admin.general.edit_form', compact('data'));
    }

    public function update(Request $request)
    {
        $param = $request->all();
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        $Cities = Cities::findOrFail($request->id);
        $Cities->name = $param['name'];
        $Cities->country_id = $param['country_id'];
        $Cities->state_id = $param['state_id'];
        $Cities->status = $param['status'];
        $Cities->save();
        
        if ($Cities){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function destory(Request $request)
    {
        $result = Cities::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}