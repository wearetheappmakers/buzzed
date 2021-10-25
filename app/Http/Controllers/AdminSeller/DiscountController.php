<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use Carbon\Carbon;
use DataTables;

class DiscountController extends Controller
{
    public function __construct(Discount $s)
    {
        $this->view = 'discount';
        $this->route = 'discount';
        $this->viewName = 'Discount Master';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Discount::get();
            // echo "<pre>";
            // print_r($query);
            // exit;
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.discount','delete' => route('admin.'.$this->route.'.destory') ])->render();
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
                ->addColumn('discount_code', function ($row) {
					$schk = $row->discount_code ? $row->discount_code :'-';
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

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->all();
        // echo "<pre>";
        // print_R( $param );
        // exit;
        // $param['discount_start_date'] = Carbon::parse($param['discount_start_date'])->format('Y-m-d H:i:s');
        // $param['discount_end_date'] = Carbon::parse($param['discount_end_date'])->format('Y-m-d H:i:s');
        $status=empty($request->status)? 0 : $request->status;
        unset($param['status']);

        $discount = Discount::create($param);
        $discount->status=$status;
        $discount->save();

        if ($discount){
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
        $data['edit'] = Discount::findOrFail($id);
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
    public function update(Request $request, $id)
    {
        $param = $request->all();
        $param['status']=empty($request->status)? 0 : $request->status;
        unset($param['_token'], $param['_method']);

        // $param['discount_start_date'] = Carbon::parse($param['discount_start_date'])->format('Y-m-d H:i:s');
        // $param['discount_end_date'] = Carbon::parse($param['discount_end_date'])->format('Y-m-d H:i:s');
        
        $discount = Discount::where('id', $id);
        $discount->update($param);

        if ($discount){
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
        $result = Discount::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}
