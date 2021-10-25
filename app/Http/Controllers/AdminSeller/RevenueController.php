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
use App\Models\OrderLine;
use App\Models\EmailTemplate;
use App\Helpers\ImageHelper;
use App\Helpers\ProductPrice;
use DataTables;
use DB;
use Hash;
use Carbon\Carbon;

class RevenueController extends Controller
{
	public function __construct(Cities $model)
    {
        $this->view = 'revenue';
        $this->route = 'revenue';
        $this->viewName = 'Revenue Report';
        $this->model =  $model;
    }

    public function index(Request $request){
        
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['vendors'] = User::where('role',1)->get();
        

        // if ($request->ajax()) {
        //     $query = EmailTemplate::where('deleted_at', NULL)->latest()->get();
            
        //     return Datatables::of($query)
        //         //  ->addColumn('action', function ($row) {
        //         //     $btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.'.$this->route,'delete' => route('admin.'.$this->route.'.destory') ])->render();
        //         //     return $btn;
        //         // })

        //         ->addColumn('checkbox', function ($row) {
        //             $chk = view('admin.layout.checkbox')->with(['id' => $row->id])->render();
        //             return $chk;
        //         })
        //         ->addColumn('singlecheckbox', function ($row) {
        //             $schk = view('admin.layout.singlecheckbox')->with(['id' => $row->id , 'status'=>$row->status])->render();
        //             return $schk;
        //         })

        //         ->rawColumns(['checkbox', 'singlecheckbox','action','name'])
        //         ->make(true);
        // }
        return view('adminseller.'.$this->view . '.index')->with($data);
    }

    public function report(Request $request)
    {
        $date = explode('-', $request->date);
        $from = Carbon::parse($date[0]);
        $to = Carbon::parse($date[1]);
        $commision = User::where('id',$request->vendor_id)->value('commission');
        $dates = [];

        for($d = $from; $d->lte($to); $d->addDay()) {
            $dates[] = $d->format('Y-m-d');
        }

        $order_lines = OrderLine::leftjoin('products','products.id','order_lines.product_id')
                                // ->leftjoin('product_prices','product_prices.product_id','products.id')
                                ->select('products.*','order_lines.*')
                                ->where('products.vendor_id',$request->vendor_id)
                                ->whereBetween('order_lines.created_at',[date('Y-m-d',strtotime($date[0])), date('Y-m-d',strtotime($date[1]))])
                                ->get();

        $final_report = [];

        foreach ($order_lines as $key => $value) {
            if (in_array(date('Y-m-d',strtotime($value->created_at)), $dates)) {
                $qty = OrderLine::where('product_id',$value->product_id)
                                ->whereDate('created_at','=',date('Y-m-d',strtotime($value->created_at)))->count();
                $tax = 0;
                // ['size_id',$value->size_id]           
             
                if ($value->product_taxtype == 1) {
                    if (strlen($value->product_tax) < 2) {
                        $pointv = 1 + ($value->product_tax/10);
                    }else{
                        $pointv = 1 + ($value->product_tax/100);
                    }
                     
                   $tax = ($qty*$value->price) / $pointv;
                }else{
                    $tax = ($qty*$value->price) + ((($qty*$value->price)*$value->product_tax)/100);
                }

                array_push($final_report, array(
                    'date' => date('Y-m-d',strtotime($value->created_at)),
                    'product' => $value->name,
                    'product_id' => $value->product_id,
                    'qty' => $qty,
                    'price_with_gst' => round($tax,2)
                ));

            }
        }

        $final_report = array_unique($final_report,SORT_REGULAR);

        // $final_report = sort($final_report, 'date',SORT_ASC);

       $this->array_sort_by_column($final_report, 'date');
       $total = 0;

        $html = '<table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">

                        <thead>

                            <tr>

                                <th>Sr. No</th>

                                <th>Date</th>

                                <th>Product</th>

                                <th>Qty sold</th>

                                <th>Price Incl GST</th>

                            </tr>

                        </thead>

                        <tbody>';
        if (!empty($final_report)) {
                      
            foreach ($final_report as $key => $value) {
                $total = $total + $value['price_with_gst'];
                $html .= '<tr>
                <td>'.($key + 1).'</td>
                <td>'.$value['date'].'</td>
                <td>'.$value['product'].'</td>
                <td>'.$value['qty'].'</td>
                <td>'.$value['price_with_gst'].'</td>
                </tr>';
            }
            
        }else{
            $html .= '<tr>
                <td>No data found!</td>
                </tr>';
        }

        $html .= '</tbody>

                    </table>';

        return response()->json(['success'=> true,'data' => $html,'total' => $total, 'commision' => $commision, 'to_be_taken' => round(($total*$commision)/100,2) ]);
        
    }

    function array_sort_by_column(&$array, $column, $direction = SORT_DESC) {
        $reference_array = array();

        foreach($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }

        array_multisort($reference_array, $direction, $array);
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