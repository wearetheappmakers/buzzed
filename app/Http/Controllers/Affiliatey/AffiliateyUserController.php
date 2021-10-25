<?php

namespace App\Http\Controllers\Affiliatey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AffiliateUser;
use App\referralLink;
use App\productComm;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\Product;
use DB;
use App\Models\OrderStatus;
use App\userComm;
use Carbon\Carbon;

class AffiliateyUserController extends Controller
{
    public function AffiliateyLogin(Request $request){

        if ($request->isMethod('post')) {
            $data = $request->all();
            $user = AffiliateUser::where('email',$data['email'])->first();
            if(isset($user) && $user->status == 1){
                if (Auth::guard('AffUser')->attempt(['email' => $data['email'], 'password' => $data['password']]) ) {
                    $admin = Auth::guard('AffUser')->user();

                    Session::put('username', $admin->name);
                    // if (Session::get('old_url')) {
                    //     $url = Session::get('old_url');
                    //     return Redirect::to($url);
                    // } else {
                        return redirect('/Userdashboard');
                    // }

                } else {
                    return redirect('/AffiliateyLogin')->with('worngpass', 'Invalid Email Or Password');
                }
            } else {
                return redirect('/AffiliateyLogin')->with('worngpass', 'Admin not approve your profile');
            }
        }

        return view('AffiliateyView.login');
    }

    public function AffiliateyRegister(Request $request){

        if ($request->isMethod('post')) {
            $rules = ([
                'name' => 'required',
                'address' => 'required',
                'email' => 'required|unique:affiliate_users,email',
                'password' => 'required',
                'phone' => 'required',
                'bankAcName' => 'required',
                'bankAcNumber' => 'required',
                'IFSC' => 'required',
                'bankName' => 'required',
                // 'status' => 'required',
            ]);
            $message = ([
                "name.required" => "Please Enter Name ",
                "address.required" => "Please Enter Address ",
                "email.required" => "Please Enter Email",
                "password.array" => "Please Enter Password",
                "phone.required" => "Please Enter Phone ",
                "bankAcName.required" => "Please Enter Bank Accounter Name ",
                "bankAcNumber.required" => "Please Enter Bank Accounter Number ",
                "IFSC.required" => "Please Enter IFSC ",
                "bankName.required" => "Please Enter Bank Name ",
                // "status.required" => "Please Enter price ",
            ]);
            
            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                $messages = $validator->messages();
                return redirect()->back()->withErrors($messages);
            }
            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
            $referral = substr(str_shuffle($str_result), 0, 10); 
            AffiliateUser::create([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'bankAcName' => $request->bankAcName,
                'bankAcNumber' => $request->bankAcNumber,
                'IFSC' => $request->IFSC,
                'bankName' => $request->bankName,
                'referral_id' => $referral,
                // 'status' => $status,
            ]);

            return redirect('/AffiliateyLogin')->with('logout', 'Register Successfully!');

        }

        return view('AffiliateyView.registration');

    }

    public function dashboard(Request $request){
        $product = Product::with('product_images')->get();

        return view('AffiliateyView.dashboard',compact('product'));
    }

    public function getLink($id){
        $product = Product::where('id',$id)->first();
        $user = Auth::guard('AffUser')->user();

        referralLink::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'link' => 'https://shrayati.com/category.html?slug='.$product->slug.'?refe_id='.$user->referral_id,
        ]);
        return redirect()->back()->with('add','Referral link generate successfully!');

    }

    public function showLink(){
        $link = referralLink::get();

        return view('AffiliateyView.referralLink',compact('link'));
    }

    public function showProduct(Request $request){
        $product = Product::get();

        return view('AffiliateyView.showproduct',compact('product'));
    }

    public function addcom(Request $request){

        $rules = ([
            'product_id' => 'required',
            'comm' => 'required',
        ]);
        $message = ([
            "product_id.required" => "Please select product ",
            "comm.required" => "Please Enter commision ",
        ]);
        
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages);
        }

        productComm::create([
            'product_id' => $request->product_id,
            'comm' => $request->comm,
        ]);
        
        return response()->json(['success' => 'Product commission add successfully!']);

    }

    public function showuser(Request $request){

        $user = AffiliateUser::get();

        return view('AffiliateyView.showuser',compact('user'));

    }

    public function userapproved($id){
        $user = AffiliateUser::findOrfail($id);
        // dd($user->status);
        if($user->status == 1)
        {
            $user->update([
                'status' => 0,
            ]);
            return redirect()->back()->with('apuser','Affiliate user Disapproved.');
        }else{
            $user->update([
                'status' => 1,
            ]);
            return redirect()->back()->with('apuser','Affiliate user approved.');
        }

    }

    public function logout()
    {
        session()->forget('username');
        Auth::guard('AffUser')->logout();

        return redirect('/AffiliateyLogin')->with('logout', 'Logout Successfully!');
    }

    public function showrefforder(){

        $refforder = DB::table('user_comms')->select('order_headers.*','user_comms.*', DB::raw('SUM(user_comms.amount) As total'))
            ->leftJoin('order_headers', 'user_comms.order_id', '=', 'order_headers.id')
            ->groupBy('user_comms.order_id')
            ->get();
        $order_status = OrderStatus::where('status', 1)->get();
        return view('AffiliateyView.showorder',compact('refforder','order_status'));
    }

    public function showreforder($id){
        $refforder = DB::table('user_comms')->where('user_id',$id)->select('order_headers.*','user_comms.*', DB::raw('SUM(user_comms.amount) As total'))
            ->leftJoin('order_headers', 'user_comms.order_id', '=', 'order_headers.id')
            ->groupBy('user_comms.order_id')
            ->get();

        $order_status = OrderStatus::where('status', 1)->get();
        return view('AffiliateyView.showreforder',compact('refforder','order_status'));
        
    }

    public function viewAffiliateyDetail($id){
        $refforder = DB::table('affiliate_users')->where('id',$id)
            ->first();
        return view('AffiliateyView.viewAffiliateyDetail',compact('refforder'));
        
    }
    public function commissionhistory(Request $request,$id)
    {
        $data['data'] = DB::table('user_comms')->where('user_id',$id)->get();

        return view('AffiliateyView.showcommision')->with($data);
    }
    public function viewfunds(Request $request,$id)
    {
        $data['data'] = DB::table('funds')->where('user_id',$id)->orderBy('id','DESC')->get();
        $data['get_user_id'] = $id;
        return view('AffiliateyView.viewfunds')->with($data);
    }
    public function savefunds(Request $request)
    {
        // dd($request->all());
        DB::table('funds')->insert(['user_id'=>$request->user_id,'amount'=>$request->amount]);

        return response()->json(['status'=>1,'message'=>'Amount added successfully.']);
    }
    public function updatefunds(Request $request)
    {
        // dd($request->all());
        // DB::table('funds')->update(['user_id'=>$request->user_id,'amount'=>$request->amount]);
        DB::table('funds')->where('id',$request->table_id)->update(['amount'=>$request->amount]);   
        return response()->json(['status'=>1,'message'=>'Amount updated successfully.']);
    }
    public function peddingCommision()
    {
        $user = Auth::guard('AffUser')->user();
        $data['total_pending'] = DB::table('user_comms')->where([['user_id',$user->id],['status',0]])->get();
        return view('AffiliateyView.peddingCommision')->with($data);
        
    }

    public function approvedCommision()
    {
        $user = Auth::guard('AffUser')->user();
        $data['total_approved'] = DB::table('user_comms')->where([['user_id',$user->id],['status',1]])->get();
        return view('AffiliateyView.approvedCommision')->with($data);
        
    }

    public function totalCommision()
    {
        $user = Auth::guard('AffUser')->user();
        $data['total_commision'] = DB::table('user_comms')->where('user_id',$user->id)->get();
        return view('AffiliateyView.totalCommision')->with($data);
    }

    public function totalFund()
    {
        $user = Auth::guard('AffUser')->user();
        $data['total_funds'] = DB::table('funds')->where('user_id',$user->id)->get();
        return view('AffiliateyView.totalFund')->with($data);
    }
}
