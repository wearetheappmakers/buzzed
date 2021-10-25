<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LocationController extends Controller
{
    public function state(Request $request)
    {
        if($request->country_id)
        {
            $data = States::where('country_id',$request->country_id)->select('id as state_id','name')->get();
            // dd($data);
            return response()->json(['success' => 1, 'message' => $data],200);
        } else {
            return response()->json(['success' => 1, 'message' => 'Provide proper country_id'],400);
        }
    }
    public function cities(Request $request)
    {
        if($request->state_id)
        {
            $data = Cities::where('state_id',$request->state_id)->where('country_id',$request->country_id)->select('id as city_id','name')->get();
            // dd($data);
            return response()->json(['success' => 1, 'message' => $data],200);
        } else {
            return response()->json(['success' => 1, 'message' => 'Provide proper country_id'],400);
        }
    }
}