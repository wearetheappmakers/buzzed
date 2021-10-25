<?php

namespace App\Http\Controllers\AdminSeller;
use App\Models\ReviewRating;
use App\Models\Product;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DB;
use App\User;
use App\Http\Controllers\Controller;
// use App\Http\Requests\ReviewRatingRequest;
use App\Helpers\ImageHelper;
use Mail;

class ReviewratingController extends Controller
{
    public function __construct(ReviewRating $s)
    {
        $this->view = 'reviewrating';
        $this->route = 'reviewrating';
        $this->viewName = 'ReviewRating';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = ReviewRating::get();
			
			return Datatables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.reviewrating','delete' => route('admin.'.$this->route.'.destory')])->render();
					return $btn;
                })
                ->addColumn('product', function ($row) {
                    $pname = Product::where('id',$row->product_id)->value('name');
                    return $pname;
                })
                ->addColumn('vendor', function ($row) {
                    $vendor = User::where('id',$row->vendor_id)->value('fname');
                    return $vendor;
                })
                ->addColumn('buyer', function ($row) {
                    $buyer = User::where('id',$row->customer_id)->value('fname');
                    return $buyer;
                })
                ->addColumn('singlecheckbox', function ($row) {
                    $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id, 'status' => $row->status])->render();
                    return $schk;
                })
				->addColumn('checkbox', function ($row) {
					$chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
					return $chk;
				})
                
				->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
				->rawColumns(['checkbox', 'singlecheckbox','action','product','vendor','buyer'])
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        $data['edit'] = ReviewRating::findOrFail($id);
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
        unset($param['_token'],$param['_method'],$param['id']);
        dd($param);
        $result = ReviewRating::where('id',$request->id)->update($param);

        if ($result){
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
        $result = ReviewRating::where('id',$request->id)->delete();

        if ($result){
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false]);
        }
    }
}
