<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utilities\SiteHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function getMerchant(Request $request){
        $data=DB::table('affilate_coupon','C')
        ->join('partners_merchant as M',function($join) use ($request){
              $join->on('C.merchant_id','=','M.merchant_id')
              ->where('merchant_url','=','www.searlco.net');
        })
          ->select('C.coupon','C.coupon_detail','M.merchant_company')
        ->get();

        return response()->json([
    'data'=>$data,

        ]);
    }

}
