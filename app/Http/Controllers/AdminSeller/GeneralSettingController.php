<?php

namespace App\Http\Controllers\AdminSeller;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use App\Http\Requests\ColorRequest;
use App\Helpers\ImageHelper;
use DB;
use Config;
use Artisan;

class GeneralSettingController extends Controller
{
    public function __construct(GeneralSetting $s)
    {
        $this->view = 'settings.general';
        $this->route = 'general.setting';
        $this->viewName = 'General Setting';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Add ' . $this->viewName;
        $data['settings'] = GeneralSetting::first();

        return view('adminseller.settings.general')->with($data);
    }

    public function update(Request $request)
    {
        $param = $request->all();
        // dd($param);
        unset($param['_token']);

        if ($request->hasFile('logo')) {
            $name = ImageHelper::saveUploadedImage(request()->logo, 'users', storage_path("app/public/uploads/brand/"));
            $param['logo']= $name;
        }

        if ($request->hasFile('favicon_icon')) {
            $name = ImageHelper::saveUploadedImage(request()->favicon_icon, 'users', storage_path("app/public/uploads/brand/"));
            $param['favicon_icon']= $name;
        }

        $oldsettings = GeneralSetting::first();
        $settings = GeneralSetting::where('id',1)->update($param);
        $newsetting = GeneralSetting::first();
        $this->mailSettings($oldsettings,$newsetting);

        if ($settings){
            $this->CacheClear();
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    public function CacheClear(){
        Artisan::call('config:clear');
        // Artisan::call('cache:clear');
        // Artisan::call('config:cache');
        // Artisan::call('view:clear');
        // Artisan::call('route:clear');
    }

    public function mailSettings($old,$new){

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_HOST=".$old->smtp_host,"MAIL_HOST=".$new->smtp_host, file_get_contents(app()->environmentFilePath())
        ));

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_PORT=".$old->smtp_port,"MAIL_PORT=".$new->smtp_port, file_get_contents(app()->environmentFilePath())
        ));

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_USERNAME=".$old->smtp_username,"MAIL_USERNAME=".$new->smtp_username, file_get_contents(app()->environmentFilePath())
        ));

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_PASSWORD=".$old->smtp_encrytion,"MAIL_PASSWORD=".$new->smtp_encrytion, file_get_contents(app()->environmentFilePath())
        ));

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_FROM_NAME=".$old->smtp_from_name,"MAIL_FROM_NAME=".$new->smtp_from_name, file_get_contents(app()->environmentFilePath())
        ));

        file_put_contents(app()->environmentFilePath(), str_replace(
            "MAIL_FROM_ADDRESS=".$old->from_email,"MAIL_FROM_ADDRESS=".$new->from_email, file_get_contents(app()->environmentFilePath())
        ));
    }
}