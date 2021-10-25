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
use App\Helpers\ImageHelper;
use DataTables;
use DB;
use Hash;

class OfferController extends Controller
{
	public function __construct(Cities $model)
    {
        $this->view = 'offer';
        $this->route = 'offer';
        $this->viewName = 'Offer';
        $this->model =  $model;
    }

    public function index(Request $request){
        
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        

        if ($request->ajax()) {
            $query = Offer::where('deleted_at', NULL)->latest()->get();
            
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
                ->editColumn('image', function ($row) {
                    return view('admin.layout.image')->with(['image'=>$row->image,'folder_name'=>'banner']);
                    
                })
                ->setRowClass(function () {
                    return 'row-move';
                })
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
                ->rawColumns(['checkbox', 'singlecheckbox','action','image'])
                ->make(true);
        }
        return view('adminseller.'.$this->view . '.index');
    }

    public function create()
    {
        $data['url'] = route('admin.'.$this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['countries'] = Countries::where('status',1)->get();
        $data['states'] = State::where('status',1)->get();
        $data['categories'] = Category::where([['status',1]])->get();

        return view('admin.general.add_form')->with($data);
    }

    public function store(Request $request)
    {
        $param = $request->all();
        $type = 'Product';
        $param['status'] = isset($param['status']) ? $param['status'] : 0;

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/banner/"));
            $param['image']= $name;
        }

        $brand = Offer::create($param);

        if ($brand){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function edit(Request $request,$id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Offer::findOrFail($id);
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

        $brand = Offer::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/banner/"), $brand->image);
            $param['image']= $name;
        }
        $brand->update($param);
        
        if ($brand){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function destory(Request $request)
    {
        $result = Offer::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}