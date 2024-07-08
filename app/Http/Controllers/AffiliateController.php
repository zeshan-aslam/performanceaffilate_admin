<?php

namespace App\Http\Controllers;

use App\Affiliate;
use App\Activity;
use Illuminate\Http\Request;
use App\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Utilities\SiteHelper;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $this->type = "Affiliate";
        $this->country = '';
    }

    public function index()
    {
        $affiliates = DB::table('partners_affiliate')->get();
        // ->orderByRaw('affiliate_id DESC')


        $affiliateGroups = DB::table('partners_affiliategroup')
            ->get();

        $loginData = DB::table('partners_login')
            ->where(['login_flag' => 'a'])->get();

        $datas = DB::table('affiliate_pay')->get();



        // $merchants = DB::table('partners_merchant', 'm')
        //     ->join('merchant_pay as p', 'm.merchant_id', '=', 'p.pay_merchantid')
        //     ->select('m.*', 'p.*')
        //     ->get();



        // $pending = DB::table('partners_transaction', 't')
        //     ->join('partners_joinpgm as j', 't.transaction_joinpgmid', '=', 'j.joinpgm_id')
        //     ->join('partners_affiliate as a', 'j.joinpgm_affiliateid', '=', 'a.affiliate_id')
        //     ->where('t.transaction_status', 'pending')
        //     ->count();


        $affiliate = DB::table('partners_affiliate')->get();
        $approved = DB::table('partners_affiliate')
            ->where('affiliate_status', 'approved')
            ->count();
        $waiting = DB::table('partners_affiliate')
            ->where('affiliate_status', 'waiting')
            ->count();
        $suspend = DB::table('partners_affiliate')
            ->where('affiliate_status', 'suspend')
            ->count();

        // return $datas;
        return view('affiliate.index', compact('affiliateGroups', 'affiliates', 'loginData', 'datas', 'affiliate', 'approved', 'waiting', 'suspend'));
    }
    public function affiliatePendings()
    {
        //============To get the pending counts =================//
        $merchants = DB::table('partners_merchant')->select([
            'merchant_id', 'merchant_company', 'pay_amount', 'merchant_status',
            'merchant_invoiceStatus', 'merchant_date', 'merchant_pgmapproval'
        ])
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->get();

        $pending = 0;
        foreach ($merchants as $row) {
            $trans = SiteHelper::GetPaymentPendingDetails($row->merchant_id, 1);
            if ($trans > 0) {
                $pending++;
            }
        }

        return response()->json([
            "pending"      => $pending
        ]);
    }
    #####################################New#######################
    // public function getAffiliates()
    // {

    //     $affiliates = DB::table('partners_affiliate')->get();

    //     return response()->json([
    //         'message' => 'Data Found',
    //         'code' => '200',
    //         'data' => $affiliates,
    //     ]);
    // }

    public function getAffiliates()
    {
        $sitehelper = new SiteHelper;


        $data = array();
        $affiliates = DB::table('partners_affiliate', 'a')
            ->join('affiliate_pay as p', 'a.affiliate_id', '=', 'p.pay_affiliateid')
            // ->join('partners_login as l', 'a.affiliate_id', '=', 'l.login_id')
            ->select('a.*', 'p.*')
            ->get();
        $i = 0;
        foreach ($affiliates as $row) {
            $data[$i]['affiliate_id'] = $row->affiliate_id;
            $data[$i]['affiliate_status'] = $row->affiliate_status;
            $data[$i]['affiliate_company'] = $row->affiliate_company;
            $data[$i]['affiliate_firstname'] = $row->affiliate_firstname;
            $data[$i]['affiliate_lastname'] = $row->affiliate_lastname;
            $data[$i]['affiliate_date'] = $row->affiliate_date;
            $data[$i]['pay_amount'] = $row->pay_amount;
            $data[$i]['pending_amount'] = SiteHelper::GetPaymentPendingDetails($row->affiliate_id, 2);
            $data[$i]['affiliate_address'] = $row->affiliate_address;
            // $data[$i]['affiliate_country'] = $row->affiliate_country;
            $data[$i]['affiliate_country'] = $sitehelper->getAffCountryOfPromotionName($row->affiliate_id);
            $data[$i]['affiliate_city'] = $row->affiliate_city;
            $data[$i]['affiliate_phone'] = $row->affiliate_phone;
            $data[$i]['affiliate_category'] = $sitehelper->getAffCategoryName($row->affiliate_id);
            $data[$i]['affiliate_fax'] = $row->affiliate_fax;
            $data[$i]['affiliate_currency'] = $row->affiliate_currency;
            $data[$i]['affiliate_zipcode'] = $row->affiliate_zipcode;
            $data[$i]['affiliate_taxId'] = $row->affiliate_taxId;
            $data[$i]['affiliate_url'] = $row->affiliate_url;
            $data[$i]['affiliate_state'] = $row->affiliate_state;
            // $data[$i]['login_email'] = $row->login_email;
            $i++;
        }

        return response()->json([
            'message' => 'Data Found',
            'code' => '200',
            'data' => $data,
        ]);
    }


    public function Reject(Affiliate $affiliate, $id)
    {

        $affiliate = DB::table('partners_affiliate')
            ->where(['affiliate_id' => $id])
            ->first();
        $activity = new Activity();
        $activity->url = url()->current();
        $activity->ip = SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = "Affiliate";
        $activity->country = '';
        $activity->description = $affiliate->affiliate_company . ' Affiliate Rejected';
        $activity->save();

        $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->delete();
        return response()->json($affiliate);
    }

    public function removeAffiliateForm($id)
    {
        return view('Affiliate.remove', compact('id'));
    }
    public function removeAffiliate(Request $request)
    {
        $id = 0;
        $id = $request->id;

        $ret = DB::table('partners_affiliate')->where('affiliate_id', '=', $id)->delete();
        $ret = DB::table('partners_login')->where(['login_id' => $id, 'login_flag' => 'a'])->delete();

        if ($ret) {
            $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
            $activity = new Activity();
            $activity->url = url()->current();
            $activity->ip = SiteHelper::getIp();
            $activity->user_id = Auth::id();
            $activity->type = "Affiliate";
            $activity->country = '';
            $activity->description = $affiliate->affiliate_company . ' Affiliate Removed';
            $activity->save();
            $data = 1;
        } else {
            $data = 0;
        }
        return response()->json($data);
    }
    public function show($id)
    {

        // Instantiate the SiteHelper class
        $sitehelper = new SiteHelper;
        $affiliate = DB::table('partners_affiliate')->where(['affiliate_id' => $id])->first();

        if ($affiliate) {
            // Modify the data as needed
            $customData = [
                'affiliate_category' => $sitehelper->getAffCategoryName($affiliate->affiliate_id),
                'affiliate_country' => $sitehelper->getAffCountryOfPromotionName($affiliate->affiliate_id),
            ];

            // Add the custom data to the affiliate object
            $affiliate->custom_data = $customData;
        }

        return response()->json($affiliate);
    }
    public function getAffiliate($id)
    {
        return  DB::table('partners_login', 'L')
            ->join(
                'partners_affiliate as A',
                function ($join) use ($id) {
                    $join->on('L.login_id', '=', 'A.affiliate_id')
                        ->where('L.login_flag', '=', 'a')
                        ->where('L.login_id', '=', $id);
                }
            )->select('L.*', 'A.*')->first();
    }
    public function changePasswordForm($id)
    {
        $loginData = DB::table('partners_login')->where(['login_id' => $id, 'login_flag' => 'a'])->first();


        return response()->json($loginData);
    }
    public function changePassword(Request $request)
    {
        $id = $request->id;

        $data = Login::where(['login_id' => $id, 'login_flag' => 'a'])
            ->limit(1)
            ->update(array('login_password' => $request->password));

        //    SiteHelper::sendAffiliateMail($this->getAffiliate($id),'Change Affiliate Password');
        $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
        $activity = new Activity();
        $activity->url = url()->current();
        $activity->ip = SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = "Affiliate";
        $activity->country = '';
        $activity->description = $affiliate->affiliate_company . ' Affiliate Password Changed';
        $activity->save();

        return response()->json($data);
    }

    // Adjust Money
    public function adjustMoneyForm($id)
    {
        $data = DB::table('affiliate_pay')->where(['pay_affiliateid' => $id])->first();
        return response()->json($data);
    }

    public function adjustMoney(Request $request)
    {

        $id = $request->id;

        $data = DB::table('affiliate_pay')->where(['pay_affiliateid' => $id])->first();
        try {

            if ($request->action == 'add') {
                $data->pay_amount = $data->pay_amount + (int)$request->pay_amount;
                $res = DB::table('affiliate_pay')
                    ->where(['pay_affiliateid' => $id])
                    ->limit(1)
                    ->update(array('pay_amount' => $data->pay_amount));
                if ($res == 1) {
                    $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
                    $activity = new Activity();
                    $activity->url = url()->current();
                    $activity->ip = SiteHelper::getIp();
                    $activity->user_id = Auth::id();
                    $activity->type = "Affiliate";
                    $activity->country = '';
                    $activity->description = $affiliate->affiliate_company . ' Affiliate Password Changed';
                    $activity->save();
                }

                return response()->json($res);
            }

            if ($request->action == 'deduct') {

                $data->pay_amount = $data->pay_amount - (int)$request->pay_amount;
                $res = DB::table('affiliate_pay')
                    ->where(['pay_affiliateid' => $id])
                    ->limit(1)
                    ->update(array('pay_amount' => $data->pay_amount));
                if ($res == 1) {
                    $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
                    $activity = new Activity();
                    $activity->url = url()->current();
                    $activity->ip = SiteHelper::getIp();
                    $activity->user_id = Auth::id();
                    $activity->type = "Affiliate";
                    $activity->country = '';
                    $activity->description = $affiliate->affiliate_company . ' Affiliate Password Changed';
                    $activity->save();
                }

                return response()->json($res);
            }
            //code...
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    // payment History

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


        return view('affiliate.paymenthistory', compact('data', 'merchants', 'id'));

        // $data = DB::select(
        //         "select *,date_format(transaction_dateofpayment,'%d/%M/%y') as date
        //     from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id
        //     and joinpgm_merchantid='$id' and transaction_dateofpayment <> '0000-00-00'  and
        //     transaction_status <> 'pending' ORDER BY transaction_dateofpayment DESC
        //     "
        //     );
        // $merchants = DB::select(
        //         "select *,date_format(adjust_date,'%d/%M/%Y') AS DATE
        //      from partners_adjustment,partners_merchant where merchant_id=adjust_memberid
        //      and adjust_flag like 'm' and adjust_memberid='$id' order by adjust_date desc
        //     "
        //     );
        // if ($data) {
        //     $ID = $data[0]->joinpgm_affiliateid;
        //     $affiliate = DB::table('partners_affiliate')
        //         ->where(['affiliate_id' => $ID])->get();
        //     return view('affiliate.paymenthistory', compact('data', 'merchants', 'affiliate'));
        //     // dd($data);
        // } else {
        //     return view('affiliate.paymenthistory', compact('data', 'merchants'));
        // }
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



        return view('affiliate.paymenthistory', compact('data', 'merchants', 'id'));

        // $data = DB::select(
        //         "select *,date_format(transaction_dateofpayment,'%d/%M/%y') as date
        //     from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id
        //     and joinpgm_merchantid='$id' and transaction_dateofpayment <> '0000-00-00'  and
        //     transaction_status <> 'pending' and transaction_dateofpayment between '$request->From' and '$request->To'
        //     ORDER BY transaction_dateofpayment DESC
        //     "
        //     );
        // $merchants = DB::select(
        //         "select *,date_format(adjust_date,'%d/%M/%Y') AS DATE
        //      from partners_adjustment,partners_merchant where merchant_id=adjust_memberid
        //      and adjust_flag like 'm' and adjust_memberid='$id' and adjust_date between '$request->From' and '$request->To'
        //      order by adjust_date desc
        //     "
        //     );

        // if ($data) {
        //     $ID = $data[0]->joinpgm_affiliateid;

        //     $affiliate = DB::table('partners_affiliate')
        //         ->where(['affiliate_id' => $ID])->get();
        //     return view('affiliate.paymenthistory', compact('data', 'merchants', 'affiliate'));
        // } else {

        //     return view('affiliate.paymenthistory', compact('data', 'merchants'))->with('message', 'No Data to Show');
        // }
        // dd($data);

    }

    // Transaction

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
        return view('affiliate.transaction', compact('data', 'id'));
        return view('affiliate.transaction', ['data' => $data]);
    }

    public function approveIt(Request $request)
    {
        // echo "Your desired ID is :".$request->consAff."Mafe: ".$request->group;
        try {


            $check = DB::table('partners_affiliate')
                ->where(['affiliate_id' => $request->id])
                ->limit(1)
                ->update(array('affiliate_status' => 'approved', 'affiliate_parentid' => '0'));
            $affiliate = DB::table('partners_affiliate')
                ->where(['affiliate_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = url()->current();
            $activity->ip = SiteHelper::getIp();
            $activity->user_id = Auth::id();
            $activity->type = "Affiliate";
            $activity->country = '';
            $activity->description = $affiliate->affiliate_company . ' Affiliate Approved';
            $activity->save();
            //  if( $check){
            //      SiteHelper::sendAffiliateMail($this->getAffiliate($request->id),'Approve Affiliate');
            // }
            //code...
        } catch (\Exception $th) {
            throw $th;
        }

        return response()->json($check);
    }

    public function suspend(Request $request)
    {
        try {

            $check = DB::table('partners_affiliate')
                ->where(['affiliate_id' => $request->id])
                ->limit(1)
                ->update(array('affiliate_status' => 'suspend'));
            $affiliate = DB::table('partners_affiliate')
                ->where(['affiliate_id' => $request->id])
                ->first();
            $activity = new Activity();
            $activity->url = url()->current();
            $activity->ip = SiteHelper::getIp();
            $activity->user_id = Auth::id();
            $activity->type = "Affiliate";
            $activity->country = '';
            $activity->description = $affiliate->affiliate_company . ' Affiliate Suspended';
            $activity->save();
            // if( $check){
            //    SiteHelper::sendAffiliateMail($this->getAffiliate($request->id),'Suspend Affiliate');
            // }
            return response()->json($check);
            //code...
        } catch (\Exception $th) {
            throw $th;
        }
    }


    public function setcommission(Request $request)
    {
        // return response()->json($request);

        $id = $request->id;
        $checkRecord = DB::table('partners_affiliate')
            ->where([
                'affiliate_id' => $id,
                'affiliate_group' => $request->groupId,
            ])->exists();

        if (!$checkRecord) {
            $check = DB::table('partners_affiliate')
                ->where(['affiliate_id' => $id])
                ->limit(1)
                ->update(array('affiliate_group' => $request->groupId));
            if ($check) {
                $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
                $activity = new Activity();
                $activity->url = url()->current();
                $activity->ip = SiteHelper::getIp();
                $activity->user_id = Auth::id();
                $activity->type = "Affiliate";
                $activity->country = '';
                $activity->description = $affiliate->affiliate_company . ' Affiliate Commission Set to Group ' . $request->groupId;
                $activity->save();
            }

            return response()->json($check);
        } else {
            $check = 2;
            return response()->json($check);
        }
    }


    public function destroy(Affiliate $affiliate, $id)
    {
        $toDelete = DB::table('partners_affiliate')->where('affiliate_id', $id)->delete();
        $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
        $activity = new Activity();
        $activity->url = url()->current();
        $activity->ip = SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = "Affiliate";
        $activity->country = '';
        $activity->description = $affiliate->affiliate_company . ' Affiliate Deleted';
        $activity->save();
        // return redirect()->route('Affiliate.index')->with('success', 'Affiliate Deleted!');
    }

    public function loginAffiliate(Request $request, $id)
    {
        session_start();
        $data = DB::table("partners_affiliate")
            ->where('affiliate_id', $id)
            ->first();
        $pay = DB::table("affiliate_pay")
            ->where('pay_affiliateid', $id)
            ->first();

        if ($data && $pay) {
            unset($_SESSION['AFFILIATEID']);
            unset($_SESSION['AFFILIATENAME']);
            unset($_SESSION['AFFILIATEBALANCE']);
            $_SESSION['AFFILIATEID'] = $data->affiliate_id;
            $_SESSION['AFFILIATENAME'] = stripslashes($data->affiliate_firstname) . " " . stripslashes($data->affiliate_lastname);
            $_SESSION['AFFILIATEBALANCE'] = $pay->pay_amount;

            echo  $_SESSION['AFFILIATEID'] . $_SESSION['AFFILIATENAME'] . $_SESSION['AFFILIATEBALANCE'];
            if ($data) {
                $affiliate = DB::table('partners_affiliate')->where('affiliate_id', $id)->first();
                $activity = new Activity();
                $activity->url = url()->current();
                $activity->ip = SiteHelper::getIp();
                $activity->user_id = Auth::id();
                $activity->type = "Affiliate";
                $activity->country = '';
                $activity->description = $affiliate->affiliate_company . ' Affiliate Logged in';
                $activity->save();
            }

            return redirect("https://performanceaffiliate.com/affiliates/index.php?Act=Home");
        } else {
            return "Error Logging in ";
        }
    }
}
// "https://searlco.net/affiliates/index.php?Act=home"