<?php

namespace App\Http\Controllers\AdminSeller;
use App\Models\Ticket;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Helpers\ImageHelper;
use Mail;

class TicketController extends Controller
{
    public function __construct(Ticket $s)
    {
        $this->view = 'ticket';
        $this->route = 'ticket';
        $this->viewName = 'Ticket';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Ticket::get();
			
			return Datatables::of($query)
				// ->addColumn('action', function ($row) {
				// 	$btn = view('admin.layout.actionbtnpermission')->with(['id' => $row->id, 'route' => 'admin.ticket'])->render();
				// 	return $btn;
    //             })
                ->addColumn('action', function ($row) {
                    $btn = '<a style="background: skyblue" title="View details" href="'.route('admin.ticket.edit',$row->id) .'">Reply</a>';
					return $btn;
				})
                 ->editColumn('status', function($row) {
                    if($row->status == 1)
                        return 'active';
                    else
                        return 'Answered';

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
    //    dd($data);

        return view('admin.general.add_form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $param = $request->all();
         if ($request->hasFile('image')) {
			$image = ImageHelper::saveUploadedImage(request()->image, 'Ticket', storage_path("app/public/uploads/ticket/"));
            $param['image']= $image;
            // dd($name);
        }
        $param['ticket_number'] = time();
        // dd($param['ticket_number']);
        $ticket = Ticket::create($param);
        $data = $ticket->toArray();
        // dd($data['email']);
        // $data = array('email'=>$param['email']);
        Mail::send('mail.ticket', $data, function($message) use($data) {
            $message->to($data['email']);
            $message->subject('Ticket Details');
        });
        $module_name = config('common');
        // dd($module_name);
        Mail::send('mail.ticket', $data, function($message) use($module_name) {
            $message->to($module_name['admin_email']);
            $message->subject('Ticket Details');
        });
        if ($ticket){
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
        $data['edit'] = Ticket::findOrFail($id);
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
        unset($param['_token'], $param['_method']);
        
        $ticket = Ticket::where('id', $id);
        $ticket->update($param);
        $data = $param;
        // dd($data);
        $module_name = config('common');
        // dd($module_name);
        Mail::send('mail.ticket', $data, function($message) use($module_name) {
            $message->to($module_name['admin_email']);
            $message->subject('Ticket Details');
        });
        Mail::send('mail.ticket', $data, function($message) use($data) {
            $message->to($data['email']);
            $message->subject('Ticket Details');
        });

        if ($ticket){
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
