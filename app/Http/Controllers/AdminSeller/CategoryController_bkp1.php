<?php

namespace App\Http\Controllers\AdminSeller;;

use App\Models\Category;
use App\Models\SellerCategory;
use App\Imports\CategoryImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCategoryRequest;
use App\Helpers\ImageHelper;
use DataTables;
use Auth;
use Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
     protected $categoryRepository;
    public function __construct(Category $model)
    {
        $this->view = 'category';
        $this->route = 'category';
        $this->viewName = 'Category';
        $this->model =  $model;
    }
    
    public function index(Request $request)
    {
       
         
        if ($request->ajax()) {
            $category_level = $this->model->treeList();
            $order = implode(',', array_keys($category_level));
            $query = Category::where('deleted_at', NULL);
            if($order != ''){
                $query->orderByRaw("FIELD(id, ".$order.")");
                }
			$query->get();
			
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route ])->render();
					return $btn;
				})
			    ->addColumn('name', function ($row) use($category_level){
					return html_entity_decode($category_level[$row->id]);
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
		
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        
        return view('adminseller.'.$this->view . '.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route('admin.' . $this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['categories_select'] = $this->getCategory();

        return view('admin.general.add_form')->with($data);
    }
    
    public function getCategory() {
         $category_level = $this->model->treeList();
        //  dd($category_level);
         return  $category_level ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCategoryRequest $request)
    {
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;
        
        if ($request->hasFile('banner_image')) {
            $name = ImageHelper::saveUploadedImage(request()->banner_image, 'Category Banner', storage_path("app/public/uploads/category/"));
            $param['banner_image'] = $name;
        }
                
        $category = Category::create($param);
        $category->position = $category->id;
        $category->order = $category->id;
        $category->save();

        if ($category){
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
        $data['edit'] = Category::findOrFail($id);
        $data['url'] = route('admin.' . $this->route . '.update', [$this->view => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['categories_select'] = $this->getCategory();
        
		return view('admin.general.edit_form', compact('data'));//->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveCategoryRequest $request, $id)
    {
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method']);

        if($param['parent_id'] == '') {
            $param['parent_id'] = NULL;
        }
        // echo "<pre>";
        // print_r($param);
        // exit;
        $category = Category::where('id', $id)->first();
        $category->slug = null;
        if(Auth::guard('seller')->check())
        {
            $seller_image = SellerCategory::where('seller_id', Auth::user()->id)->where('category_id', $category->id)->first();
            $param1=[];
            if ($request->hasFile('image')) {
                $name = ImageHelper::saveUploadedImage(request()->image, 'Category', storage_path("app/public/uploads/category/"), ($seller_image ? $seller_image->image : ''));
                $param1['image'] = $name;
            }
            if ($request->hasFile('banner_image')) {
                $name = ImageHelper::saveUploadedImage(request()->banner_image, 'Category Banner', storage_path("app/public/uploads/category/"),  ($seller_image ? $seller_image->banner_image : ''));
                $param1['banner_image'] = $name;
            }
            if($seller_image) {
                $seller_image->update($param1);
            } else {
                $param1['category_id'] = $category->id;
                $seller_category = SellerCategory::create($param1); 
            } 
            return response()->json(['status'=>'success']);
            unset($param['image'], $param['banner_image']);
        } else {
            if ($request->hasFile('image')) {
                $name = ImageHelper::saveUploadedImage(request()->image, 'Category', storage_path("app/public/uploads/category/"), $category->image);
                $param['image'] = $name;
            }
            if ($request->hasFile('banner_image')) {
                $name = ImageHelper::saveUploadedImage(request()->banner_image, 'Category Banner', storage_path("app/public/uploads/category/"), $category->banner_image);
                $param['banner_image'] = $name;
            }
        }
        
        
        $category->update($param);
          
        if ($category){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
        //   echo "<pre>";
        // print_r($request->all());
        // exit;
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
    
    public function treeView(Request $request) {
        
        $category_tree = $this->model->tree();
       
        return view('adminseller.category.tree_view', compact('category_tree'));
    }

    public function importCategory(Request $request) {
        if($request->ajax() && $request->isMethod('post')){ 
            Excel::import(new CategoryImport, $request->file('category_excel'));
            return response()->json(['status'=>'success']);
        } 
    }
}
