<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\ImageOptimize;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use App\Http\Requests\ImageOptimizeRequest;
use DB;
class ImageOptimizeController extends Controller
{
    public function __construct(ImageOptimize $s)
    {
        $this->view = 'image_optimize';
        $this->route = 'image_optimize';
        $this->viewName = 'ImageOptimize';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i_o = ImageOptimize::get();
        $i_o_array = [];
        foreach($i_o as $i) {
            $i_o_array[$i['module_name']][] = [
                'thumb_folder' => $i['thumb_folder'],
                'width' => $i['width'],
                'height' => $i['height'],
            ];
        }
        // echo "<pre>";
        // print_r($i_o_array);
        // exit;
        return view('adminseller.'.$this->view . '.index', compact('i_o_array'));
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
    public function store(ImageOptimizeRequest $request)
    {
        // dd($request->module_name);
        foreach($request->thumb_folder as $key => $value)
        {
            if((isset($request->width[$key])) && (isset($request->height[$key])))
            
            $image = ImageOptimize::create([
                'module_name'=>$request->module_name,
                'thumb_folder'=>$value,
                'width'=>$request->width[$key],
                'height'=>$request->height[$key]
                ]);   
        }
        // dd($request->all());
        if ($image){
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
        $data['edit'] = ImageOptimize::findOrFail($id);
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
    public function update(ImageOptimizeRequest $request, $id)
    {
        $param = $request->all();
        unset($param['_token'], $param['_method']);

        $image = ImageOptimize::where('id', $id);
        $image->update($param);

        if ($image){
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
