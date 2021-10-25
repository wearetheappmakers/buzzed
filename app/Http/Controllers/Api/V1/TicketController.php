<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Http\Requests\TicketRequest;
use JWTAuth;
use DB;

class TicketController extends Controller
{
    public function add(TicketRequest $request)
    {
    	$user = JWTAuth::user();
        
        $param = $request->all();
        $param['customer_id']= $user->id;
        $param['ticket_number'] = time();
        // dd($param);
        $param = DB::table('tickets')->insert(['customer_id' => $user->id, 'order_id' => $param['order_id'], 'ticket_number' => time(), 'fullname' => $param['fullname'], 'email' => $param['email'], 'number' => $param['number'], 'problem_description' => $param['problem_description'], 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);

        
        return response()->json(['success' => true, 'message' => 'Ticket created successfully', 'data' => $param]);
    }
}