<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index()
    {
        // dd('Hello');
        $data = Currency::where('deleted_at',NULL)->get();
        return response()->json(['success' => 1, 'records' => $data], 200);    
    }
}
