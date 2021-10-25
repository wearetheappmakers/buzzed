<?php

namespace App\Http\Controllers\AdminSeller;
use App\Models\Settings;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{
    public function __construct(Settings $s)
    {
        $this->view = 'settings';
        $this->route = 'settings';
        $this->viewName = 'Settings';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Settings::get();
			
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.settings'])->render();
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
    public function create()
    {
        $data['url'] = route('admin.'.$this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
    //    dd($data);

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingsRequest $request)
    {
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;

        $size = Settings::create($param);
        if ($size){
            $all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
            file_put_contents(base_path() .'/config/common.php',  '<?php return ' . var_export($all_setting, true) . ';');
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
        $data['edit'] = Settings::findOrFail($id);
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
    public function update(SettingsRequest $request, $id)
    {
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method']);
        
        $settings = Settings::where('id', $id);
        $settings->update($param);

        if ($settings){
            $all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
            file_put_contents(base_path() .'/config/common.php',  '<?php return ' . var_export($all_setting, true) . ';');
			
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