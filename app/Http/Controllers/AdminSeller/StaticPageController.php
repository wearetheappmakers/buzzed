<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use App\Http\Requests\StaticPageRequest;
use App\Helpers\ImageHelper;

class StaticPageController extends Controller
{
    public function __construct(StaticPage $s)
    {
        $this->view = 'static-page';
        $this->route = 'static-page';
        $this->viewName = 'StaticPage';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,Request $request)
    {
        if ($request->ajax()) {
			$query = StaticPage::where('deleted_at', NULL)->where('type',$type)->get();
			
			
			return Datatables::of($query)
				->addColumn('action', function ($row) use($type) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.static-page','type'=>$type])->render();
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
                    return view('admin.layout.image')->with(['image'=>$row->image,'folder_name'=>"page"]);
                    
                })
                ->editColumn('banner_image', function ($row) {
                    return view('admin.layout.image')->with(['image'=>$row->banner_image,'folder_name'=>"page"]);
                    
				})
				->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
				->rawColumns(['checkbox', 'singlecheckbox','action','image','banner_image'])
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

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type,StaticPageRequest $request)
    {
        $param = $request->all();
        $param['type'] = $type;
        $param['status']=empty($request->status)? 0 : $request->status;

        if ($request->hasFile('image')) {
			$name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/page/"));
            $param['image']= $name;
        }
        if ($request->hasFile('banner_image')) {
			$name = ImageHelper::saveUploadedImage(request()->banner_image, 'Main-Banner', storage_path("app/public/uploads/page/"));
            $param['banner_image']= $name;
        }
        $staticpage = StaticPage::create($param);
   
        $staticpage->save();
        if ($staticpage){
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
    public function edit($id,$type)
    {
        // dd($id);
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = StaticPage::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['type']=$type;
        // dd($data);
		return view('admin.general.edit_form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaticPageRequest $request, $id)
    {
        $param = $request->all();
        $type= $param['type'];
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method'],$param['type']);

        if ($request->hasFile('image')) {
			$name = ImageHelper::saveUploadedImage(request()->image, $type, storage_path("app/public/uploads/page/"));
            $param['image']= $name;
        }
        if ($request->hasFile('banner_image')) {
			$name = ImageHelper::saveUploadedImage(request()->banner_image, 'Main-Banner', storage_path("app/public/uploads/page/"));
            $param['banner_image']= $name;
        }
        $staticpage = StaticPage::where('id', $id);
        $staticpage->update($param);
        
        if ($staticpage){
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
