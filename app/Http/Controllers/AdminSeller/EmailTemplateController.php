<?php
namespace App\Http\Controllers\AdminSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Countries;
use App\Models\Category;
use App\Models\State;
use App\Models\Cities;
use App\Models\Brand;
use App\Models\TopDeals;
use App\Models\Offer;
use App\Models\EmailTemplate;
use App\Helpers\ImageHelper;
use DataTables;
use DB;
use Hash;

class EmailTemplateController extends Controller
{
	public function __construct(Cities $model)
    {
        $this->view = 'emailtemplate';
        $this->route = 'emailtemplate';
        $this->viewName = 'Email Template';
        $this->model =  $model;
    }

    public function index(Request $request){
        
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        

        if ($request->ajax()) {
            $query = EmailTemplate::where('deleted_at', NULL)->latest()->get();
            
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
        return view('adminseller.'.$this->view . '.index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function edit(Request $request,$id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = EmailTemplate::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['categories'] = Category::where([['status',1],['parent_id',NULL]])->get();
        
        return view('admin.general.edit_form', compact('data'));
    }

    public function update(Request $request)
    {
        $param = $request->all();
        $type= 'Product';
        $param['status'] = isset($param['status']) ? $param['status'] : 0;
        unset($param['_token'], $param['id'],$param['_method']);

        $brand = EmailTemplate::findOrFail($request->id);
        $brand->update($param);
        
        if ($brand){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function destory(Request $request)
    {
        $result = EmailTemplate::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}