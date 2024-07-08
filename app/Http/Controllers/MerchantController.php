<?php

namespace App\Http\Controllers;

use App\Merchant;
use App\Login;
use App\User;
use App\Activity;
use App\Utilities\SiteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use stdClass;

class MerchantController extends Controller
{


    private $url;
    private  $country;
    private  $ip;
    private  $user_id;
    private  $type;
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
        $this->url = url()->current();
        $this->ip = SiteHelper::getIp();
        $this->user_id = Auth::id();
        $this->type = "Merchant";
        $this->country = '';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $merchants = DB::table('partners_merchant')->select([
            'merchant_id', 'merchant_company', 'pay_amount', 'merchant_status',
            'merchant_invoiceStatus', 'merchant_date', 'merchant_pgmapproval'
        ])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->get();
        // $merchants = DB::table('partners_merchant', 'm')
        //     ->join('merchant_pay as p', 'm.merchant_id', '=', 'p.pay_merchantid')
        //     ->select('m.*', 'p.*')
        //     ->get();

        // $pending = 0;
        // $empty = 0;
        // foreach ($merchants as $row) {
        //     $trans = SiteHelper::GetPaymentPendingDetails($row->merchant_id, 1);
        //     if ($trans > 0) {
        //         $pending++;
        //     }
        //     if ($row->pay_amount == 0) {
        //         $empty++;
        //     }
        // }
        $pen_amt = 0;

        //   $pen_amt = count($pending_amount);
        // $pending = DB::table('partners_transaction', 't')
        //     ->join('partners_joinpgm as j', 't.transaction_joinpgmid', '=', 'j.joinpgm_id')
        //     ->join('partners_merchant as m', 'j.joinpgm_merchantid', '=', 'm.merchant_id')
        //     ->where('t.transaction_status', 'pending')
        //     ->count();


        // $merchants = DB::table('partners_merchant')->get();
        $approved = DB::table('partners_merchant')
            ->where('merchant_status', 'approved')
            ->count();
        $waiting = DB::table('partners_merchant')
            ->where('merchant_status', 'waiting')
            ->count();
        $suspend = DB::table('partners_merchant')
            ->where('merchant_status', 'suspend')
            ->count();
        $NP = DB::table('partners_merchant')
            ->where('merchant_status', 'NP')
            ->count();
        $setup_NotCompleted = DB::table('partners_merchant')
            ->where(
                [
                    'in_setup' => 'Set NC',
                    'merchant_status' => 'approved',
                    'is_old' => 'no'
                ]
            )
            ->count();
        $Awaiting_Authorization = DB::table('partners_merchant')
            ->where(
                [
                    'in_setup' => 'Set AA',
                    'merchant_status' => 'approved',
                    'is_old' => 'no'
                ]
            )
            ->count();
        $setup_live = DB::table('partners_merchant')
            ->where(
                [
                    'in_setup' => 'Set Live',
                    'merchant_status' => 'approved',
                    'is_old' => 'no'
                ]
            )
            ->count();
            $setup_without_live = DB::table('partners_merchant')
            ->where(
                [
                    'in_setup' => 'Set Old',
                    'merchant_status' => 'approved'
                ]
            )
            ->count();
        // $empty = DB::table('partners_merchant')
        //     ->where('merchant_status', 'empty')
        //     ->count();


        $loginData = DB::table('partners_login')->where(['login_flag' => 'm'])->get();

        $adjustMoneydata = DB::table('merchant_pay')->get();

        return view('merchant.index', compact('merchants', 'approved', 'waiting', 'suspend', 'NP', 'loginData', 'adjustMoneydata', 'pen_amt', 'setup_NotCompleted', 'Awaiting_Authorization', 'setup_live', 'setup_without_live'));

        // dd( $merchants->attributesToArray());
    }

    public function merchantPendings()
    {
        $merchants = DB::table('partners_merchant')->select([
            'merchant_id', 'merchant_company', 'pay_amount', 'merchant_status',
            'merchant_invoiceStatus', 'merchant_date', 'merchant_pgmapproval'
        ])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->get();

        $pending = 0;
        $empty = 0;
        foreach ($merchants as $row) {
            $trans = SiteHelper::GetPaymentPendingDetails($row->merchant_id, 1);
            if ($trans > 0) {
                $pending++;
            }
            if ($row->pay_amount == 0) {
                $empty++;
            }
        }

        return response()->json([
            "pending"      => $pending,
            "empty"        => $empty
        ]);
    }

    // public function keywordCounter()
    // {
    //     $merchants = DB::table('partners_merchant')->where(['merchant_status' => 'approved'])->get();


    //     return view('merchant.keywordCounter', compact('merchants'));
    // }

    public function keywordCounter()
    {
        $merchants = DB::table('partners_merchant')->select([
            'brands'
        ])->where(['merchant_status' => 'approved'])->get();

        $concerned_merchants = DB::table('partners_merchant')->select([
            'merchant_company', 'brands'
        ])->where(['merchant_status' => 'approved'])->get();

        // dd($concerned_merchants);

        $new = [];
        $unique_brands = [];
        foreach ($merchants as $merchant) {
            $low = strtoupper($merchant->brands);
            trim($low);
            $newArray = explode('|', $low);
            $new = array_merge($new, $newArray);
        }
        $unique_brands = array_unique($new, SORT_REGULAR);

        return view('merchant.keywordCounter', compact('merchants', 'concerned_merchants', 'unique_brands'));
    }

    // public function getkeywords()
    // {
    //     $merchants = DB::table('partners_merchant')->select([
    //         'brands', 'merchant_company'
    //     ])->where(['merchant_status' => 'approved'])->get();

    //     return response()->json([
    //         'message' => 'Data Found',
    //         'code' => '200',
    //         'data' => $merchants,

    //     ]);
    // }
    public function getkeywords()
    {
        $sitehelper = new SiteHelper;

        $merchantData = DB::table('partners_merchant')
            ->select(['partners_merchant.*', 'partners_country.country_name', 'partners_category.cat_name'])
            ->join('partners_country', 'partners_country.country_no', '=', 'partners_merchant.merchant_country')
            ->leftjoin('partners_category', 'partners_category.cat_id', '=', 'partners_merchant.merchant_category')
            ->where(['partners_merchant.merchant_status' => 'approved'])->get();
        $i = 0;
        foreach ($merchantData as $row) {
            $merchantData[$i]->countryOfPromotion = $sitehelper->getCountryOfPromotionName($row->merchant_id);
            $i++;
        }

        return response()->json([
            'message' => 'Data Found',
            'code' => '200',
            'data' => $merchantData

        ]);
    }


    public function getMerchants(Request $request)
    {

        $sitehelper = new SiteHelper;

        ## Read value
        $draw  = $request->draw;
        $limit = $request->length;
        $start = $request->start;
        $columnIndex      = $request['order'][0]['column']; // Column index
        $columnName       = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder  = $request['order'][0]['dir']; // asc or desc
        $searchValue      = $request['search']['value']; // Search value

        # Total Records
        $totalCount = DB::table('partners_merchant')
            ->select(['partners_merchant.*', 'merchant_pay.*', 'partners_category.cat_name', 'partners_country.country_name'])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->leftjoin('partners_category', 'partners_category.cat_id', '=', 'partners_merchant.merchant_category')
            ->leftjoin('partners_country', 'partners_country.country_no', '=', 'partners_merchant.merchant_country')
            ->count();
        # Total Filtering Records
        $datafilter = DB::table('partners_merchant')
            ->select(['partners_merchant.*', 'merchant_pay.*', 'partners_category.cat_name', 'partners_country.country_name'])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->leftjoin('partners_category', 'partners_category.cat_id', '=', 'partners_merchant.merchant_category')
            ->leftjoin('partners_country', 'partners_country.country_no', '=', 'partners_merchant.merchant_country')
            ->when($request['search']['value'], function ($query) use ($request) {
                $query->Where('merchant_company', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_status', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('in_setup', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_pgmapproval', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_invoiceStatus', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('pay_amount', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('cat_name', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('country_name', 'like', '%' . $request['search']['value'] . '%');
            })->count();
        # SHOWING DATA
        $merchantData = DB::table('partners_merchant')
            ->select(['partners_merchant.*', 'merchant_pay.*', 'partners_category.cat_name', 'partners_country.country_name'])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->leftjoin('partners_category', 'partners_category.cat_id', '=', 'partners_merchant.merchant_category')
            ->leftjoin('partners_country', 'partners_country.country_no', '=', 'partners_merchant.merchant_country')
            ->when($request['search']['value'], function ($query) use ($request) {
                $query->Where('merchant_company', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_status', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('in_setup', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_pgmapproval', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('merchant_invoiceStatus', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('pay_amount', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('cat_name', 'like', '%' . $request['search']['value'] . '%');
                $query->orWhere('country_name', 'like', '%' . $request['search']['value'] . '%');
            })
            ->take($limit)
            ->offset($start)
            ->orderBy($columnName, $columnSortOrder)
            ->get();
        $i = 0;
        foreach ($merchantData as $row) {
            $merchantData[$i]->pending_amount = $sitehelper->GetPaymentPendingDetails($row->merchant_id, 1);
            $merchantData[$i]->countryOfPromotion = $sitehelper->getCountryOfPromotionName($row->merchant_id);
            $i++;
        }

        ## Response
        $response = array(
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalCount,
            "iTotalDisplayRecords" => $datafilter,
            "aaData"               => $merchantData
        );
        return json_encode($response);
    }
    public function AddBrandPower(Request $request)
    // public function AddBrandPower()
    {
        //dd('Working');
        // $allMerchatns = DB::table('partners_merchant')->select('merchant_id ','brands')->get();
        // dd($allMerchatns);
        // $allMerchatns = DB::table('partners_merchant')->select(['merchant_id','brands'])
        // ->get();
        //dd($merchants);

        // foreach ($allMerchatns as $key => $valMer) {

        //     if (strpos($valMer->brands, '|') !== false) {
        //         echo "If is working <br>";

        //         DB::table('partners_merchant')
        //             ->where(['merchant_id' => $valMer->merchant_id])
        //             ->limit(1)
        //             ->update(array('brand_power' => 3));
        //         // DB::table('partners_merchant')
        //         // ->where('id', $valMer->id)
        //         // ->update(['brand_power' => 3]);
        //     }else{
        //         echo "Else is working <br>";
        //         DB::table('partners_merchant')
        //         ->where(['merchant_id' => $valMer->merchant_id])
        //         ->limit(1)
        //         ->update(array('brand_power' => 1));
        //         // DB::table('partners_merchant')
        //         // ->where('id', $valMer->id)
        //         // ->update(['brand_power' => 1]);
        //     }

        // }

        //return $request->power;
        $merchants = DB::table('partners_merchant')->where('merchant_id', $request->id)->update(['brand_power' => (int)$request->power]);
        if ($merchants) {
            $msg = "1";
            return response()->json($msg);
        }
        $code = "0";
        $msg = "Brands Power is Already " . $request->power . " Of This Merchant";
        return response()->json(["message" => $msg, "code" => $code]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function getMerchant($id)
    {

        return  DB::table('partners_login', 'L')
            ->join(
                'partners_merchant as M',
                function ($join) use ($id) {
                    $join->on('L.login_id', '=', 'M.merchant_id')
                        ->where('L.login_flag', '=', 'm')
                        ->where('L.login_id', '=', $id);
                }
            )->select('L.*', 'M.*')->first();
    }
    public function show(Merchant $merchant, $id)
    {

        $merchant = DB::table('partners_merchant')->where(['merchant_id' => $id])->first();

        return response()->json($merchant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchant $merchant, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant, $id)
    {



        $merchant = DB::table('partners_merchant')
            ->where(['merchant_id' => $id])
            ->first();
        $activity = new Activity();
        $activity->url = $this->url;
        $activity->ip = $this->ip;
        $activity->user_id = Auth::id();
        $activity->type = $this->type;
        $activity->country = $this->country;
        $activity->description = $merchant->merchant_company . " " . $this->type . ' Deleted';
        $activity->save();

        $toDelete = DB::table('partners_merchant')->where('merchant_id', $id)->delete();
        return redirect()->route('Merchant.index')->with('success', 'Merchant deleted!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function changePasswordForm($id)
    {

        $loginData = DB::table('partners_login')->where(['login_id' => $id, 'login_flag' => 'm'])->first();

        return response()->json($loginData);
    }
    public function changePassword(Request $request)
    {
        $id = $request->id;
        $data = Login::where(['login_id' => $id, 'login_flag' => 'm'])
            ->limit(1)
            ->update(array('login_password' => $request->password));

        // SiteHelper::sendMerchantMail($this->getMerchant($id),'Change Merchant Password');
        if ($data) {
            $merchant = DB::table('partners_merchant')
                ->where(['merchant_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = $this->url;
            $activity->ip = $this->ip;
            $activity->user_id = Auth::id();
            $activity->type = $this->type;
            $activity->country = $this->country;
            $activity->description = $merchant->merchant_company . " " . $this->type . ' Password Changed';
            $activity->save();
        }

        return response()->json($data);
    }
    public function adjustMoneyForm($id)
    {

        $data = DB::table('merchant_pay')->where(['pay_merchantid' => $id])->first();

        return response()->json($data);
    }
    public function adjustMoney(Request $request)
    {

        $id = $request->id;


        $data = DB::table('merchant_pay')->where(['pay_merchantid' => $id])->first();

        if ($request->action == 'add') {
            $data->pay_amount = $data->pay_amount + (float)$request->pay_amount;
            $res = DB::table('merchant_pay')
                ->where(['pay_merchantid' => $id])
                ->limit(1)
                ->update(array('pay_amount' => $data->pay_amount));
            if ($res) {
                $merchant = DB::table('partners_merchant')
                    ->where(['merchant_id' => $request->id])
                    ->first();
                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' Money Added ' . $data->pay_amount;
                $activity->save();
            }


            return response()->json($res);
        }


        if ($request->action == 'deduct') {


            $data->pay_amount = $data->pay_amount - (float)$request->pay_amount;
            $res = DB::table('merchant_pay')
                ->where(['pay_merchantid' => $id])
                ->limit(1)
                ->update(array('pay_amount' => $data->pay_amount));
            if ($res) {
                $merchant = DB::table('partners_merchant')
                    ->where(['merchant_id' => $request->id])
                    ->first();
                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' Monaey Deducted ' . $data->pay_amount;
                $activity->save();
            }

            return response()->json($res);
        }
    }

    public function paymentHistoryForm($id)
    {
        session(['id' => $id]);
        $data = DB::table('partners_transaction', 't')
            ->join('partners_joinpgm as j', function ($join) {
                $join->on('t.transaction_joinpgmid', '=', 'j.joinpgm_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_merchant as m', function ($join) {
                $join->on('j.joinpgm_merchantid', '=', 'm.merchant_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_affiliate as a', function ($join) {
                $join->on('j.joinpgm_affiliateid', '=', 'a.affiliate_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->select('t.*', 'j.*', 'm.*', 'a.*')
            ->where('t.transaction_dateofpayment', '<>', '0000-00-00')
            ->where('t.transaction_status', '<>', 'pending')
            ->orderby('t.transaction_dateofpayment', 'DESC')
            ->get();

        $merchants = DB::table('partners_adjustment', 'a')
            ->join('partners_merchant as m', function ($join) {
                $join->on('a.adjust_memberid', '=', 'm.merchant_id')
                    ->where('a.adjust_memberid', '=', session('id'))
                    ->where('a.adjust_flag', '=', 'm');
            })
            ->select('a.*', 'm.*')
            ->orderby('a.adjust_date', 'DESC')
            ->get();


        return view('merchant.paymenthistory', compact('data', 'merchants', 'id'));
    }
    public function paymentHistoryByDate(Request $request, $id)
    {

        session(['id' => $id]);
        $data = DB::table('partners_transaction', 't')
            ->join('partners_joinpgm as j', function ($join) {
                $join->on('t.transaction_joinpgmid', '=', 'j.joinpgm_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_merchant as m', function ($join) {
                $join->on('j.joinpgm_merchantid', '=', 'm.merchant_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_affiliate as a', function ($join) {
                $join->on('j.joinpgm_affiliateid', '=', 'a.affiliate_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->select('t.*', 'j.*', 'm.*', 'a.*')
            ->where('t.transaction_dateofpayment', '<>', '0000-00-00')
            ->where('t.transaction_status', '<>', 'pending')
            ->whereBetween('transaction_dateoftransaction', array($request->From, $request->To))
            ->orderby('t.transaction_dateofpayment', 'DESC')
            ->get();

        $merchants = DB::table('partners_adjustment', 'a')
            ->join('partners_merchant as m', function ($join) {
                $join->on('a.adjust_memberid', '=', 'm.merchant_id')
                    ->where('a.adjust_memberid', '=', session('id'))
                    ->where('a.adjust_flag', '=', 'm');
            })
            ->select('a.*', 'm.*')
            ->whereBetween('a.adjust_date', array($request->From, $request->To))
            ->orderby('a.adjust_date', 'DESC')
            ->get();



        return view('merchant.paymenthistory', compact('data', 'merchants', 'id'));
    }

    public function transactionForm($id)
    {
        session(['id' => $id]);
        $data = DB::table('partners_transaction', 't')
            ->join('partners_joinpgm as j', function ($join) {
                $join->on('t.transaction_joinpgmid', '=', 'j.joinpgm_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_merchant as m', function ($join) {
                $join->on('j.joinpgm_merchantid', '=', 'm.merchant_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->join('partners_affiliate as a', function ($join) {
                $join->on('j.joinpgm_affiliateid', '=', 'a.affiliate_id')
                    ->where('j.joinpgm_merchantid', '=', session('id'));
            })
            ->select('t.*', 'j.*', 'm.*', 'a.*')
            ->where('t.transaction_dateofpayment', '<>', '0000-00-00')
            ->where('t.transaction_status', '<>', 'pending')
            ->orderby('t.transaction_dateofpayment', 'DESC')
            ->get();


        return view('merchant.transaction', compact('data', 'id'));
    }
    public function suspendMerchant(Request $request)
    {

        $data = DB::table('partners_merchant')
            ->where(['merchant_id' => $request->id])
            ->limit(1)
            ->update(array('merchant_status' => 'suspend'));
        //  if($data){
        //   SiteHelper::sendMerchantMail($this->getMerchant($request->id),'Suspend Merchant');

        // }
        if ($data) {
            $merchant = DB::table('partners_merchant')
                ->where(['merchant_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = $this->url;
            $activity->ip = $this->ip;
            $activity->user_id = Auth::id();
            $activity->type = $this->type;
            $activity->country = $this->country;
            $activity->description = $merchant->merchant_company . " " . $this->type . ' Suspended';
            $activity->save();
        }
        return response()->json($data);
    }
    public function approveMerchant(Request $request)
    {

        $data = DB::table('partners_merchant')
            ->where(['merchant_id' => $request->id])
            ->limit(1)
            ->update(array('merchant_status' => 'approved'));
        //  if( $data){
        //     SiteHelper::sendMerchantMail($this->getMerchant($request->id),'Approve Merchant');
        // }
        if ($data) {
            $merchant = DB::table('partners_merchant')
                ->where(['merchant_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = $this->url;
            $activity->ip = $this->ip;
            $activity->user_id = Auth::id();
            $activity->type = $this->type;
            $activity->country = $this->country;
            $activity->description = $merchant->merchant_company . " " . $this->type . ' Approved';
            $activity->save();
        }
        return response()->json($data);
    }

    // To Make Mechant's "is_setup" Status to Live in parteners_merchants By RANA
    public function makeLiveMerchant(Request $request)
    {
        $data = DB::table('partners_merchant')
            ->where(['merchant_id' => $request->id])
            ->limit(1)
            ->update(array('in_setup' => 'Set Live'));
        return response()->json($data);
    }
     // To Make Mechant's "is_setup" Status to Live in parteners_merchants By RANA
     public function makeLiveMerchantWithoutSetup(Request $request)
     {
         $data = DB::table('partners_merchant')
             ->where(['merchant_id' => $request->id])
             ->limit(1)
             ->update(array('in_setup' => 'Set Old'));
         return response()->json($data);
     }

    public function pgmApprovelMerchant(Request $request)
    {
        $id = $request->id;
        if (DB::table('partners_merchant')->where(['merchant_id' => $id, 'merchant_pgmapproval' => 'automatic'])->exists()) {
            $data = DB::table('partners_merchant')
                ->where(['merchant_id' => $id])
                ->limit(1)
                ->update(array('merchant_pgmapproval' => 'manual'));
            if ($data) {
                $merchant = DB::table('partners_merchant')
                    ->where(['merchant_id' => $request->id])
                    ->first();
                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' PGM Changed to Manual';
                $activity->save();
            }
            return response()->json($data);
        } else {
            $data = DB::table('partners_merchant')
                ->where(['merchant_id' => $id])
                ->limit(1)
                ->update(array('merchant_pgmapproval' => 'automatic'));
            if ($data) {
                $merchant = DB::table('partners_merchant')
                    ->where(['merchant_id' => $request->id])
                    ->first();
                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' PGM Chnaged to Automatic';
                $activity->save();
            }
            return response()->json($data);
        }
    }
    public function activateInvoiceStatusMerchant(Request $request)
    {
        $id = $request->id;
        $today            = date("Y-m-d");
        DB::table('partners_invoicestat')->insert(
            ['invoice_merchantid' => $id, 'invoice_date' => $today, 'invoice_status' => 'active']
        );
        $data = DB::table('partners_merchant')
            ->where(['merchant_id' => $id])
            ->limit(1)
            ->update(array('merchant_invoiceStatus' => 'active'));
        if ($data) {
            $merchant = DB::table('partners_merchant')
                ->where(['merchant_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = $this->url;
            $activity->ip = $this->ip;
            $activity->user_id = Auth::id();
            $activity->type = $this->type;
            $activity->country = $this->country;
            $activity->description = $merchant->merchant_company . " " . $this->type . ' Invoice Activated';
            $activity->save();
        }
        return response()->json($data);
    }
    public function DeActivateInvoiceStatusMerchant(Request $request)
    {
        $id = $request->id;
        $today            = date("Y-m-d");
        DB::table('partners_invoicestat')
            ->insert(
                ['invoice_merchantid' => $id, 'invoice_date' => $today, 'invoice_status' => 'inactive']
            );
        $data = DB::table('partners_merchant')
            ->where(['merchant_id' => $id])
            ->limit(1)
            ->update(array('merchant_invoiceStatus' => 'inactive'));
        if ($data) {
            $merchant = DB::table('partners_merchant')
                ->where(['merchant_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = $this->url;
            $activity->ip = $this->ip;
            $activity->user_id = Auth::id();
            $activity->type = $this->type;
            $activity->country = $this->country;
            $activity->description = $merchant->merchant_company . " " . $this->type . ' Invoice Deactivated';
            $activity->save();
        }
        return response()->json($data);
    }
    public function removeMerchantForm($id)
    {
        return view('merchant.remove', compact('id'));
    }
    public function removeMerchant(Request $request)
    {

        $ret = array();
        $id = $request->id;
        $merchant = DB::table('partners_merchant')
            ->where(['merchant_id' => $request->id])
            ->first();
        $ret[] = DB::table('partners_merchant')->where('merchant_id', '=', $id)->delete();
        $ret[] =  DB::table('partners_login')->where('login_id', '=', $id)->delete();
        $ret[] = DB::table('merchant_pay')->where('pay_merchantid', '=', $id)->delete();
        $ret[] = DB::table('partners_adjustment')->where('adjust_memberid', '=', $id)->delete();
        $ret[] = DB::table('partners_fee')->where('adjust_memberid', '=', $id)->delete();
        if (!in_array(0, $ret)) {

            $data = 1;
            if ($data) {

                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' Merchant Removed';
                $activity->save();
            }
        } else {
            $data = 0;
        }


        return response()->json($data);
    }
    public function loginMerchant(Request $request, $id)
    {
        session_start();
        $data = DB::table("partners_merchant")
            ->where('merchant_id', $id)
            ->get();
        $pay = DB::table("merchant_pay")
            ->where('pay_merchantid', $id)
            ->get();

        if (count($data) > 0 && count($pay) > 0) {
            unset($_SESSION['MERCHANTID']);
            unset($_SESSION['MERCHANTNAME']);
            unset($_SESSION['MERCHANTBALANCE']);
            $_SESSION['MERCHANTID'] = $data[0]->merchant_id;
            $_SESSION['MERCHANTNAME'] = stripslashes($data[0]->merchant_firstname) . " " . stripslashes($data[0]->merchant_lastname);
            $_SESSION['MERCHANTBALANCE'] = $pay[0]->pay_amount;

            echo  $_SESSION['MERCHANTID'] . $_SESSION['MERCHANTNAME'] . $_SESSION['MERCHANTBALANCE'];
            if ($data) {
                $merchant = DB::table('partners_merchant')
                    ->where(['merchant_id' => $request->id])
                    ->first();
                $activity = new Activity();
                $activity->url = $this->url;
                $activity->ip = $this->ip;
                $activity->user_id = Auth::id();
                $activity->type = $this->type;
                $activity->country = $this->country;
                $activity->description = $merchant->merchant_company . " " . $this->type . ' Merchant Logged In';
                $activity->save();
            }


            return redirect("https://performanceaffiliate.com/merchants/index.php?Act=home");
        } else {
            return "Error Logging in ";
        }
    }
}
