<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use App\Http\Requests\ColorRequest;
use DB;

class RazorpayController extends Controller
{
	 public function pay() {
        return view('pay');
    }

    public function dopayment(Request $request) {
        //Input items of form
        $input = $request->all();
        // dd($input);
        // Please check browser console.
        print_r($input);
        exit;
    }

}