<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        $data = Banner::where('type', 'Banner')->get();
        return response()->json(['success' => 1, 'records' => $data], 200);    
    }
}
