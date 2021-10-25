<?php

namespace App\Http\Controllers;

use App\Models\States;
use App\Models\Cities;
use App\Models\Countries;
use App\Partners;
use App\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DB;

class RegistrationController extends Controller
{
    public function register()
    {
        $data['countries'] = Countries::get();
        // $data['states'] = States::with('countries')->get();
        // dd($data['states']);
        return view('registration')->with($data);
    }
    public function save(Request $request)
    {
        // dd($request->all());
        $param = $request->all();
        if($request->no_of_partner_value){
            $partner_name = $param['partner_name'];
        }
        $param['password'] = bcrypt($request->password);
        unset($param['_token'],$param['partner_name']);
        $register = Customer::create($param);
     
        if(isset($partner_name)){
            foreach($partner_name as $key => $row)
            {
                Partners::create(['master_id'=>$register->id,'partner_name'=>$row]);
            }
        }
        if ($register){
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}
    }
    public function get_states(Request $request)
    {
        $country_id = $request->country_id;
        // dd($country_id);
        $data['states'] = States::where('country_id',$country_id)->get();
        // dd($data['states']);

        $html = "<option value=''>Select</option>";
		foreach ($data['states'] as $key => $row) {
			$html.="<option value='" . $row->id . "'>" . $row->name . "</option>";
		}
		echo $html;
    }
    public function get_cities(Request $request)
    {
        $state_id = $request->state_id;
        $data['cities'] = Cities::with('states')->where('state_id',$state_id)->get();
        // dd($data['cities']);

        $html = "<option value=''>Select</option>";
		foreach ($data['cities'] as $key => $row) {
			$html.="<option value='" . $row->id . "'>" . $row->name . "</option>";
		}
		echo $html;
    }
    public function thankyou()
    {
        return view('thankyou');
    }
}