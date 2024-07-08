<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\SiteHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\adminMail;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
    }


    public function affreqs()
    {
        $aff = DB::table('partners_affiliate', 'A')
            ->join('partners_request as R', function ($join) {
                $join->on('A.affiliate_id', '=', 'R.request_affiliateid')
                    ->where('R.request_status', '=',  'active');
            })

            ->join('partners_bankinfo as B', 'A.affiliate_id', '=', 'B.bankinfo_affiliateid')
            ->join('affiliate_pay as P', 'B.bankinfo_affiliateid', '=', 'P.pay_affiliateid')

            ->select('R.*', 'A.*', 'B.*', 'P.*')
            ->distinct()->get();

        return response()->json(['data' => $aff]);
    }
    public function affReqDelete(Request $request)
    {
        $ids = $request->id;
        $ret=array();
        if(is_array($ids)){
            foreach($ids as $id){
                $ret[] = DB::table('partners_request')->where('request_affiliateid', '=', $id)->delete();

            }
            if(in_array(0,$ret)){
                $res=0;
                return response()->json($res);

            }
            else{
                $res=1;
                return response()->json($res);
            }
        }


    }
    public function affReqDecline(Request $request)
    {
        $id = $request->id;
        $affReqDelete =DB::table('partners_request')
        ->where(['request_id' => $id])
        ->limit(1)
        ->update(array('request_status' => 'decline'));

        return response()->json($affReqDelete);

    }
    public function manualpay(Request $request)
    {

        $id = $request->id;
        $ret = array();

        $ret[] = DB::table('partners_bankinfo', 'b')
            ->join('partners_affiliate as a', 'b.bankinfo_affiliateid', '=', 'a.affiliate_id')
            ->select('a.*', 'b.*')
            ->get();

        $ret[] = DB::table('partners_request')
            ->where(['request_id' => $id])
            ->limit(1)
            ->update(array('request_status' => 'completed'));



        $affpay = DB::table("affiliate_pay")->where(['pay_affiliateid'=> $id])->first();
        $affrequest = DB::table("partners_request")->where(['request_affiliateid' => $id])->first();

        $requestaffiliateid= $affrequest->request_affiliateid;
        $amountpay=$affpay->pay_amount;
        $today=date('Y-m-d');
        $ret[]  = DB::table('partners_adjustment')->insert(
            [

                'adjust_memberid'   => $requestaffiliateid,
                'adjust_action'   =>   'withdraw',
                'adjust_flag'    =>   'a',
                'adjust_amount'   =>  $amountpay,
                'adjust_date'   =>   $today,
            ]
        );


        $amount    =  $amountpay - $requestaffiliateid;

        $ret[] = DB::table('affiliate_pay')
            ->where(['pay_affiliateid' => $id])
            ->limit(1)
            ->update(array('pay_amount' => $amount));

        return response()->json($ret);
    }
    public function showAff(Request $request)
    {
        $id = $request->id;
        $res = DB::table('partners_affiliate')->where(['affiliate_id' => $id])->first();
        return response()->json($res);
    }

    public function adjustMoneyForm1($id)
    {
        $data = DB::table('affiliate_pay')->where(['pay_affiliateid' => $id])->first();
        return response()->json($data);
    }
    public function adjustMoney1(Request $request)
    {
        $id = $request->id;

        $data = DB::table('affiliate_pay')->where(['pay_affiliateid' => $id])->first();
        if ($request->action == 'add') {
            $data->pay_amount = $data->pay_amount + (float)$request->pay_amount;
            $pay = DB::table('affiliate_pay')
                ->where(['pay_affiliateid' => $id])
                ->limit(1)
                ->update(array('pay_amount' => $data->pay_amount));

            return response()->json($pay);
        }
        if ($request->action == 'deduct') {

            $data->pay_amount = $data->pay_amount - (float)$request->pay_amount;
            $pay = DB::table('affiliate_pay')
                ->where(['pay_affiliateid' => $id])
                ->limit(1)
                ->update(array('pay_amount' => $data->pay_amount));

            return response()->json($pay);
        }
    }

    #------------------Merchant Request

    public function MerRequest()
    {
        $MerReqs = DB::table('partners_merchant')
            ->join('partners_addmoney', function ($join) {
                $join->on('partners_merchant.merchant_id', '=', 'partners_addmoney.addmoney_merchantid')
                    ->where('partners_addmoney.addmoney_status', '=',  'waiting');
            })
            ->join('merchant_pay', 'partners_merchant.merchant_id', '=', 'merchant_pay.pay_merchantid')
            ->select('partners_merchant.*', 'partners_addmoney.*', 'merchant_pay.*', "partners_merchant.merchant_date")
            ->get();
        return response()->json(['data' => $MerReqs]);
    }

    public function showMer(Request $request)
    {
        $id = $request->id;
        $res = DB::table('partners_merchant')->where(['merchant_id' => $id])->first();
        return response()->json($res);
    }
    public function MerReqDelete(Request $request)
    {
        $id = $request->id;
        $affReqDelete = DB::table('partners_addmoney')->where('addmoney_merchantid', '=', $id)->delete();
        return response()->json($affReqDelete);
    }
    public function rejectMer(Request $request)
    {
        $id = $request->id;
        $addmoney = DB::table('partners_addmoney')
            ->where(['addmoney_id' => $id])
            ->limit(1)
            ->update(array('addmoney_status' => 'suspend', 'addmoney_id' => $id));

        return response()->json($addmoney);
    }

    public function MerchantPay(Request $request)
    {
        $id = $request->id;
        $ret = array();

        $Merpay = DB::table('partners_addmoney')->where('addmoney_id', '=', $id)
            ->join('merchant_pay', 'partners_addmoney.addmoney_id', '=', 'merchant_pay.pay_merchantid')
            ->first();

        $total = $Merpay->addmoney_amount + $Merpay->pay_amount;

        $ret[] = DB::table('partners_addmoney')
            ->where(['addmoney_id' => $id])
            ->limit(1)
            ->update(['addmoney_status' => 'approved']);

        $ret[] = DB::table('merchant_pay')
            ->where(['pay_merchantid' => $id])
            ->limit(1)
            ->update(['pay_amount' => $total]);

            $today=date('Y-m-d');
            $ret[]  = DB::table('partners_adjustment')->insert(
                [
                    'adjust_memberid'   => $id,
                    'adjust_action'   =>   'deposit',
                    'adjust_flag'    =>   'm',
                    'adjust_amount'   =>  $Merpay->pay_amount,
                    'adjust_date'   =>   $today,
                ]
            );

        $minimum_amount = 25;

        if ($total > $minimum_amount) {

            $ret[] = DB::table('partners_merchant')
                ->where(['merchant_id' => $id])
                ->limit(1)
                ->update(['merchant_status' => 'approved']);
        } else {
            $ret[] = DB::table('partners_merchant')
                ->where(['merchant_id' => $id])
                ->limit(1)
                ->update(['merchant_status' => 'empty']);
        }

        if ($Merpay->addmoney_mode == "upgrade") {
            $ret[] = DB::table('partners_merchant')
                ->where(['merchant_id' => $id])
                ->limit(1)
                ->update(['merchant_type' => 'advance']);
        }

        // if(in_array(0,$ret)){
        //     $res=0;
        return response()->json($ret);

        // }
        // else{
        //     $res=1;
        //     return response()->json($res);
        // }
    }

    #Reverse Sale
    public function reverseSale1()
    {

        $Revsales = DB::table('partners_joinpgm', 'j')
            ->join('partners_transaction as t', function ($join) {
                $join->on('j.joinpgm_id', '=', 't.transaction_joinpgmid')
                    ->where('t.transaction_status', '=',  'reverserequest');
            })
            ->join('partners_affiliate as a', 'j.joinpgm_affiliateid', '=', 'a.affiliate_id')
            ->join('partners_merchant as m', 'j.joinpgm_merchantid', '=', 'm.merchant_id')
            ->select('t.*', 'j.*', 'a.*', 'm.*', "t.transaction_reversedate as date")
            ->get();
        return response()->json(['data' => $Revsales]);
    }
    public function show($id)
    {
        return  DB::table('partners_login','L')
        ->join('partners_merchant as M',function($join) use ($id){
            $join->on('L.login_id','=','M.merchant_id')
            ->where('L.login_flag','=','m')
            ->where('L.login_id','=',$id);
        })
            ->join('partners_joinpgm as j', 'M.merchant_id', '=', 'j.joinpgm_merchantid')
            ->join('partners_affiliate as a', 'j.joinpgm_affiliateid', '=', 'a.affiliate_id')
            ->join('partners_transaction as t', 'j.joinpgm_id', '=', 't.transaction_joinpgmid')
            ->select('L.*', 'j.*', 'a.*', 'M.*','t.*')
            ->first();
      
    }
    public function payReverse(Request $request)
    {

        $ret = array();
        $id = $request->id;
        $aid = $request->aid;
        $mid = $request->mid;
        $tid = $request->tid;

        $flage = 1;
        if ($flage == 1) {
            if ($aid) {
                $partnerAfflogin = DB::table('partners_affiliate', 'a')
                    ->join('partners_login as pl', function ($join) {
                        $join->on('a.affiliate_id', '=', 'pl.login_id')
                            ->where('pl.login_flag', '=',  'a');
                    })
                    ->select('a.*', 'pl.*',)
                    ->get();
            }
            if ($mid) {
                $partnerMerlogin = DB::table('partners_merchant', 'm')
                    ->join('partners_login as pl', function ($join) {
                        $join->on('m.merchant_id', '=', 'pl.login_id')
                            ->where('pl.login_flag', '=',  'm');
                    })
                    ->select('m.*', 'pl.*',)
                    ->get();
            }
            if ($tid) {
                $trans = DB::table('partners_transaction', 't')
                    ->join('partners_joinpgm as j', 't.transaction_id', '=', 'j.joinpgm_id')
                    ->join('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                    ->select('t.*', 'j.*', 'p.*', "t.transaction_reversedate as date")
                    ->get();
            }
        }

        $adminpay = DB::table('admin_pay')->where(['pay_id' => $id])->first();
        $transaction = DB::table('partners_transaction')->where(['transaction_id' => $id])->first();
        $merchantpay = DB::table('merchant_pay')->where(['pay_merchantid' => $id])->first();

        $totalamnt = $adminpay->pay_amount - $transaction->transaction_admin_amount;

        if ($totalamnt >= 0) {

            $ret[] = DB::table('partners_transaction')
                ->where(['transaction_id' => $tid])
                ->limit(1)
                ->update(array('transaction_status' => 'reversed'));

            $merchant_pay_amount    =  $merchantpay->pay_amount + $transaction->transaction_admin_amount;
            $admin_pay_amount       =  $adminpay->pay_amount -  $transaction->transaction_admin_amount;

            $ret[] = DB::table('merchant_pay')
                ->where('pay_merchantid', $id)
                ->limit(1)
                ->update(['pay_amount' => $merchant_pay_amount]);

            $ret[] = DB::table('admin_pay')
                ->where(['pay_id' => $id])
                ->limit(1)
                ->update(['pay_amount' => $admin_pay_amount]);
        }
          

       // SiteHelper::sendTransactionMail($this->show($id),'Reverse Transaction');

        return response()->json($ret);
    }


    public function RecuringReverseSale(Request $request)
    {
        $Revrecurings = DB::table('partners_transaction', 'T')
            ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
            ->join('partners_recur as R', function ($join) {
                $join->on('T.transaction_id', '=', 'R.recur_transactionid')
                    ->where('R.recur_status', '=',  'Active');
            })
            ->join('partners_recurpayments as P', function ($join) {
                $join->on('R.recur_id', '=', 'P.recurpayments_recurid')
                    ->where('P.recurpayments_status', '=',  'reverserequest');
            })
            ->join('partners_affiliate as a', 'J.joinpgm_affiliateid', '=', 'a.affiliate_id')
            ->join('partners_merchant as m', 'J.joinpgm_merchantid', '=', 'm.merchant_id')
            ->select('T.*', 'J.*', 'R.*', 'P.*', 'a.*', 'm.*', "T.transaction_reversedate as date")
            ->get();
        return response()->json(['data' => $Revrecurings]);
    }

    public function payRecuringReverse(Request $request)
    {

        $ret = array();
        $id = $request->id;
        $aid = $request->aid;
        $mid = $request->mid;
        $tid = $request->tid;
        $rid = $request->rid;

        $flage = 1;
        if ($flage == 1) {
            if ($aid) {
                $partnerAfflogin = DB::table('partners_affiliate', 'a')
                    ->join('partners_login as pl', function ($join) {
                        $join->on('a.affiliate_id', '=', 'pl.login_id')
                            ->where('pl.login_flag', '=',  'a');
                    })
                    ->select('a.*', 'pl.*',)
                    ->get();
            }
            if ($mid) {
                $partnerMerlogin = DB::table('partners_merchant', 'm')
                    ->join('partners_login as pl', function ($join) {
                        $join->on('m.merchant_id', '=', 'pl.login_id')
                            ->where('pl.login_flag', '=',  'm');
                    })
                    ->select('m.*', 'pl.*',)
                    ->get();
            }
            if ($tid) {
                $trans = DB::table('partners_transaction', 't')
                    ->join('partners_joinpgm as j', 't.transaction_id', '=', 'j.joinpgm_id')
                    ->join('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                    ->select('t.*', 'j.*', 'p.*', "t.transaction_reversedate as date")
                    ->get();
            }
        }

        $adminpay = DB::table('admin_pay')->where(['pay_id' => $id])->first();
        $transaction = DB::table('partners_transaction')->where(['transaction_id' => $id])->first();
        $merchantpay = DB::table('merchant_pay')->where(['pay_merchantid' => $id])->first();

        $totalamnt = $adminpay->pay_amount - $transaction->transaction_admin_amount;

        if ($totalamnt >= 0) {

            $ret[] = DB::table('partners_recurpayments')
                ->where(['recurpayments_id' => $rid])
                ->limit(1)
                ->update(array('recurpayments_status' => 'reversed'));

            $merchant_pay_amount    =  $merchantpay->pay_amount + $transaction->transaction_admin_amount;
            $admin_pay_amount       =  $adminpay->pay_amount -  $transaction->transaction_admin_amount;

            $ret[] = DB::table('merchant_pay')
                ->where(['pay_merchantid'=> $id])
                ->limit(1)
                ->update(['pay_amount'=> $merchant_pay_amount]);

            $ret[] = DB::table('admin_pay')
                ->where(['pay_id'=> $id])
                ->limit(1)
                ->update(['pay_amount' => $admin_pay_amount]);
        }

        // $details=DB::table('partners_adminmail')
        // ->where('adminmail_eventname','=','Reverse Transaction')
        // ->first();

        // Mail::to('fasehahmedwork@gmail.com')->send(new adminMail($details));

        return response()->json($ret);
    }

    public function invoicefetch(Request $request)
    {

        $StatusInvoice = DB::table('partners_transaction', 'T')
            ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
            ->join('partners_merchant as M', function ($join) {
                $join->on('J.joinpgm_id', '=', 'M.merchant_id')
                    ->where('M.merchant_invoiceStatus', '=',  'active');
            })
            ->select('T.*', 'J.*', 'M.*')
            ->get();

        $StatusInvoice = DB::table('partners_merchant')
            ->join('partners_invoice', function ($join) {

                $join->on('partners_merchant.merchant_id', '=', 'partners_invoice.invoice_merchantid')
                    ->where('partners_merchant.merchant_isInvoice', '=',  'Yes');
            })
            ->select('partners_merchant.*', 'partners_invoice.*')
            ->get();


        $Status = $request->Status;
        $From          = $request->From;
        $To            = $request->To;

        $data = array();
        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = ($request->From);
        }
        if ($request->To == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }

        $StatusInvoice = DB::table('partners_invoice', 'I')
            ->join('partners_transaction as T', 'I.invoice_id', '=', 'T.transaction_id')
            ->whereBetween('T.transaction_dateoftransaction', array($From, $To))
            ->orderby('T.transaction_dateoftransaction', 'asc')->get();

        if ($Status == 'All') {
            $StatusInvoice = DB::table('partners_invoice', 'I')
                ->join('partners_transaction as T', 'I.invoice_id', '=', 'T.transaction_id')
                ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                ->join('partners_merchant as M', 'J.joinpgm_id', '=', 'M.merchant_id')
                ->whereBetween('T.transaction_dateoftransaction', array($From, $To))
                ->select('I.*', 'T.*', 'J.*', 'M.*')
                ->get();
        } elseif ($Status == 'unpaid') {
            $StatusInvoice = DB::table('partners_invoice', 'I')
                ->join('partners_merchant as M', 'I.invoice_id', '=', 'M.merchant_id')
                ->join('partners_transaction as T', function ($join) {
                    $join->on('I.invoice_id', '=', 'T.transaction_id')
                        ->where('I.invoice_paidstatus', '=',  '1');
                })
                ->whereBetween('T.transaction_dateoftransaction', array($From, $To))
                ->select('I.*', 'T.*', 'M.*')
                ->get();
        } elseif ($Status == 'paid') {
            $StatusInvoice = DB::table('partners_invoice', 'I')
                ->join('partners_merchant as M', 'I.invoice_id', '=', 'M.merchant_id')
                ->join('partners_transaction as T', function ($join) {
                    $join->on('I.invoice_id', '=', 'T.transaction_id')
                        ->where('I.invoice_paidstatus', '=',  '0');
                })
                ->whereBetween('T.transaction_dateoftransaction', array($From, $To))
                ->select('I.*', 'T.*', 'M.*')
                ->get();
        }

        return response()->json([
            'message' => 'Data Found',
            'code' => '200',
            'data' => $StatusInvoice,
        ]);
    }

    public function Invoicepaystatus(Request $request)
    {

        $Invoicepaystatus = DB::table('partners_invoice')
            ->where('invoice_id', $request->id)
            ->update([
                'invoice_paidstatus' => $request->status
            ]);
        return response()->json($Invoicepaystatus);
    }


    public function detailstrans(Request $request)
    {
        $ret = array();
        $id = $request->id;
        session(['id' => $id]);

        $details = DB::table('partners_invoice', 'I')
            ->join('partners_merchant as M', 'I.invoice_id', '=', 'M.merchant_id')
            ->join('partners_transaction as T', function ($join) {
                $join->on('I.invoice_id', '=', 'T.transaction_id')
                    ->where('T.transaction_id', '=', session('id'));
            })
            ->select('I.*', 'T.*', 'M.*',)
            ->first();
            return response()->json($details);
        //initialize
        $total_clicks = $total_leads = $total_sales = $click_amount = $lead_amount = $sale_amount = 0;
        $merchant = DB::table('partners_merchant')->get();

        foreach($merchant as $mer){

        $merchantid = $mer->merchant_id;
        //get all join program ids of this merchant
        $res1=DB::table('partners_joinpgm')->where('joinpgm_merchantid',$merchantid)->first();
        // $ret[] = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_merchantid = '$merchantid'";
       
        $join_pgm_ids = "";
        foreach ($res1 as $row1){
            $join_pgm_ids .= $row1->joinpgm_id . ",";
            $join_pgm_ids = trim($join_pgm_ids, ",");

        }
        $sql = DB::table('partners_invoice')->where("invoice_id", $id)->first();
        $monthyear = $sql->invoice_monthyear;

        $year_month    = substr($monthyear, 3, 4) . "-" . substr($monthyear, 0, 2);


        if (!empty($join_pgm_ids)) {
            //get all active-inactive periods for current month and store in an array
            // $sql1 = "SELECT invoice_date,invoice_status FROM partners_invoicestat WHERE invoice_merchantid = '$merchantid'";
            // $sql1 .= " AND SUBSTRING(invoice_date,1,7) = '" . $year_month . "'";
            // $sql1 .= " ORDER BY invoice_id ASC";
            // $res1 = DB::select($sql1);

            $res1 = DB::table('partners_invoicestat')
            ->where('invoice_merchantid','=', $merchantid)
            ->where('invoice_date', $year_month )
            ->select('invoice_date', 'invoice_status')
            ->orderby('invoice_id', 'ASC')
            ->get();

            $invoice_date_arr = $status_arr = array();
            foreach ($res1 as $row1) {
                $invoice_date_arr[] = $row1->invoice_date;
                $status_arr[]        = $row1->invoice_status;
            }

            //find the transactions for each period
            $total  = 0;
            $count = count($invoice_date_arr);
            for ($i = 0; $i < $count; $i += 2) {
                $fromdate     =    $invoice_date_arr[$i];
                $todate     =    $invoice_date_arr[$i + 1];

                //in the case of last one
                if (empty($todate)) {
                    //if the last status is inactive
                    if ($status_arr[$count - 1] == 'inactive')
                        //then skip the loop
                        break;
                    else
                        //consider transactions till current date
                        $todate = date('Y-m-d');
                }

                //get transactions
                $sql_trans = "SELECT * FROM partners_transaction ";
                $sql_trans .= " WHERE transaction_joinpgmid IN ($join_pgm_ids)";
                $sql_trans .= " AND transaction_dateoftransaction BETWEEN '" . $fromdate . "' AND '" . $todate . "'";
                $res_trans    = DB::select($sql_trans);

                //list one by one
                $r = 0;
                foreach ($res_trans as $row_trans) {
                    //alternate row colors
                    if ($r % 2) $class =  "grid1";
                    else $class = "grid2";
                    $r++;

                    $transamount = $row_trans->transaction_amttobepaid;
                    $trans        = $row_trans->transaction_type;
                    $date        = $row_trans->transaction_dateoftransaction;
                    $adminamnt    = $row_trans->transaction_admin_amount;
                    $total        = $transamount + $adminamnt;

                    //get consolidated report
                    if ($trans == "click") {
                        $total_clicks++;
                        $click_amount += $total;
                    }
                    if ($trans == "lead") {
                        $total_leads++;
                        $lead_amount += $total;
                    }
                    if ($trans == "sale") {
                        $total_sales++;
                        $sale_amount += $total;
                    }
                }
            }
        }

        //get total fee amount for membership free and program fee
        $ret[1]         = "SELECT COUNT(*) AS c, SUM(adjust_amount) AS sum FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'register' ";
        $res_mem        = DB::select($ret[] );
        $fee_amount = $program_amount = 0;

        if (count($res_mem) > 0) {
            $row_mem = $res_mem;
            $fee_amount     = $row_mem[0]->sum;
            $total_register    = $row_mem[0]->c;
        }
        $sql_pgm        = "SELECT COUNT(*) AS c,SUM(adjust_amount) as sum FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'programFee' ";
        $res_pgm        = DB::select($sql_pgm);
        if (count($res_pgm) > 0) {
            $row_pgm = $res_pgm;
            $program_amount = $row_pgm[0]->sum;
            $total_program    = $row_pgm[0]->c;
        }
    }
        //find final total
        $ret[2] = $click_amount + $lead_amount + $sale_amount + $fee_amount + $program_amount;
        
        // $stat[$i]['index1']=
        // $stat[$i]['index2']=

        return response()->json($ret);
    }



///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // payment History
    public function paymentHistoryForm()
    {
        $affreqs  =DB::table('partners_bankinfo')
            //->join('partners_affiliate as a', 'b.bankinfo_affiliateid', '=', 'a.affiliate_id')
            //->select('a.*', 'b.*')
            ->get();
		
            return view("payment.index", compact('affreqs', ));
    } 

    #------------------------------Request-Affiliate-Delete--------------------------#
    public function Delete($id)
    {
       // $toDelete = DB::table('partners_request')->where('request_affiliateid', $id)->delete();
        //  return redirect()->route('payment.paymentHistoryForm')->with('success', 'Affiliate Deleted!');
        $affReqDelete =DB::table('partners_request')
        ->where(['request_id' => $id])
        ->limit(1)
        ->update(array('request_status' => 'decline'));
        return redirect()->route('payment.paymentHistoryForm')->with('success', 'Request Affiliate Deleted!');
    }

}
