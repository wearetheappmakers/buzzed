<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategories;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use App\Http\Requests\BlogRequest;
use DB;
use App\Helpers\ImageHelper;

class BlogController extends Controller
{
    public function __construct(Blog $s)
    {
        $this->view = 'blog';
        $this->route = 'blog';
        $this->viewName = 'Blog';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Blog::get();
            // echo "<pre>";
            // print_r($query);
            // exit;
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.blog'])->render();
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
        $data['blogcategories'] = BlogCategories::get();
        // dd($data['blogcategories']);
        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        // echo "Sd";
        // exit;
        // dd($request->all());
        $param = $request->all();
        $status=empty($request->status)? 0 : $request->status;
        unset($param['status']);

        if ($request->hasFile('image')) {
			$image = ImageHelper::saveUploadedImage(request()->image, 'Blog-Image', storage_path("app/public/uploads/blog/"));
            $param['image']= $image;
            // dd($name);
        }
        if ($request->hasFile('banner_image')) {
			$banner_image = ImageHelper::saveUploadedImage(request()->banner_image, 'Blog-Banner', storage_path("app/public/uploads/blogbanner/"));
            $param['banner_image']= $banner_image;
            // dd($name);
        }
        $blog = Blog::create($param);
        $blog->status=$status;
        $blog->save();

        if ($blog){
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
        $data['edit'] = Blog::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['blogcategories'] = BlogCategories::get();
        // dd($data['blogcategories']);
		return view('admin.general.edit_form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $id)
    {
        $param = $request->all();
        dd($param);
        $status=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method'],$param['status']);
         if ($request->hasFile('image')) {
			$image = ImageHelper::saveUploadedImage(request()->image, 'Blog-Image', storage_path("app/public/uploads/blog/"));
            $param['image']= $image;
            // dd($name);
        }
        if ($request->hasFile('banner_image')) {
			$banner_image = ImageHelper::saveUploadedImage(request()->banner_image, 'Blog-Banner', storage_path("app/public/uploads/blogbanner/"));
            $param['banner_image']= $banner_image;
            // dd($name);
        }
        $blog = Blog::where('id', $id)->first();
        $blog->status=$status;
        $blog->update($param);
        
        if ($blog){
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
