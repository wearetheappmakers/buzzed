<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Requests\BannerRequest;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ImageHelper;
use DataTables;
use DB;

class BannerController extends Controller
{
    public function __construct(Banner $s)
    {
        $this->view = 'banner';
        $this->route = 'banner';
        $this->viewName = 'Banner';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,Request $request)
    {
        
        if ($request->ajax()) {
			$query = Banner::where('deleted_at', NULL)->where('type',$type)->get();
			
			
			return Datatables::of($query)
				->addColumn('action', function ($row) use($type) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.banner','type'=>$type,'delete' => route('admin.'.$this->route.'.destory',$row->id)])->render();
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
                ->editColumn('image', function ($row) use($type) {
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
        return view('adminseller.'.$this->view . '.index', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['url'] = route('admin.'.$this->route . '.store',array('type'=>$type));
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['type'] = $type;
        // dd($data['url']);
        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, BannerRequest $request)
    {

        $param = $request->all();
        $param['type'] = $type;
        $status=empty($request->status)? 0 : $request->status;
        unset($param['status']);

        if ($request->hasFile('image')) {
			$name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/banner/"));
            $param['image']= $name;
        }
        $banner = Banner::create($param);
        $banner->status=$status;
        $banner->save();
        
        if ($banner){
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
    public function edit( $id, $type)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Banner::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['type']=$type;
        
		return view('admin.general.edit_form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        $param = $request->all();
        $type= $param['type'];
        $status=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method'],$param['status'],$param['type']);
        
        $banner = Banner::where('id', $id)->first();
        $banner->status=$status;
        
        if ($request->hasFile('image')) {
			$name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/banner/"), $banner->image);
            $param['image']= $name;
        }
        $banner->update($param);

        if ($banner){
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
        $result = Banner::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}
