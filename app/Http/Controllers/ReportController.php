<?php

namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Support\Arr;
use App\Utilities\SiteHelper;
use App\Utilities\ReportsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }





    public function index()
    {
        $tabId = "#Daily";
        $merchants = DB::table('partners_merchant')->get();
        $affiliates = DB::table('partners_affiliate')->get();
        $programs = DB::table('partners_program', 'p')
            ->leftJoin('partners_merchant AS m', 'p.program_merchantid', '=', 'm.merchant_id')
            ->select('p.program_id', 'p.program_url')
            ->get();
        //  dd($programs);
        $data2 = array();
        $data = array();
        return view('report.index', compact('merchants', 'affiliates', 'data2', 'data', 'tabId', 'programs'));
    }
    public function getTransactionData(Request $request)


    {
        $merchants = DB::table('partners_merchant')->get();
        $affiliates = DB::table('partners_affiliate')->get();
        $tabId = "#Transaction";
        $SQL = $SQL2 = "";
        // $toPass=array();
        // $data2=array();
        // $Merchant = "All";
        // $Affiliate = "All";
        // $From = '2020-03-01';
        // $To = '2022-02-01';
        $Merchant = $request->Merchant;
        $Affiliate = $request->Affiliate;
        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->From;
        }
        if ($request->To == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }
        $From = $request->From;
        $To = $request->To;

        // $Sale="sale";
        // $Lead="lead";
        // $Impression="impression";
        // $Click="click";

        $Sale = $request->Sale;
        $Lead = $request->Lead;
        $Impression = $request->Impression;
        $Click = $request->Click;


        switch ($Merchant) {
            case 'All': {
                    switch ($Affiliate) {
                        case 'All':
                            $data    = DB::table('partners_joinpgm')->get();

                            break;

                        default:
                            $data    = DB::table('partners_joinpgm')
                                ->where(['joinpgm_affiliateid' => $Affiliate])
                                ->get();


                            break;
                    }
                    break;
                }

            default: {
                    switch ($Affiliate) {
                        case 'All':
                            $data = DB::table('partners_joinpgm')
                                ->join('partners_program', 'partners_joinpgm.joinpgm_programid', '=', 'partners_program.program_id')
                                ->where('partners_program.program_merchantid', '=', $Merchant)
                                ->get();

                            break;
                        default:
                            $data = DB::table('partners_joinpgm')
                                ->join('partners_program', 'partners_joinpgm.joinpgm_programid', '=', 'partners_program.program_id')
                                ->where([
                                    'partners_program.program_merchantid' => $Merchant,
                                    'partners_joinpgm.joinpgm_affiliateid' => $Affiliate,
                                ])->get();


                            break;
                    }
                }
        }




        if ($data) {
            $j = 0;
            $joinId = array();
            foreach ($data as $row) {

                $joinId[$j] = $row->joinpgm_id;
                //   echo "Array = ".$joinId[$j]." ID = ".$row->joinpgm_id."</br>";
                $j++;
            }
            $data['joinId'] = $joinId;
            // dd( $request);
            session(['joinId' => $joinId]);

            $data2 = DB::table('partners_transaction', 't')
                ->leftJoin('partners_joinpgm as j', function ($join) {
                    $join->on('t.transaction_joinpgmid', '=', 'j.joinpgm_id')
                        ->whereIn('j.joinpgm_id', session('joinId'));
                })
                ->join('partners_merchant as m', 'j.joinpgm_merchantid', '=', 'm.merchant_id')
                ->join('partners_affiliate as a', 'j.joinpgm_affiliateid', '=', 'a.affiliate_id')
                ->select(
                    'j.joinpgm_id',
                    't.transaction_id',
                    't.transaction_type',
                    'j.joinpgm_merchantid',
                    'm.*',
                    'j.joinpgm_affiliateid',
                    'a.*',
                    't.transaction_status',
                    't.transaction_amttobepaid',
                    't.transaction_dateoftransaction',
                    'j.joinpgm_status',
                    't.transaction_referer',

                )
                ->where(function($query) use ($Impression, $Lead,$Click,$Sale) {
                    $query->orWhere([

                        'transaction_type' => $Impression,
                    ])
                    ->orWhere([
                        'transaction_type' => $Lead,
    
                    ])
                    ->orWhere([
    
                        'transaction_type' => $Click,
    
                    ])
                    ->orWhere([
    
                        'transaction_type' => $Sale,
    
    
                    ]);

                })
                
                ->whereIn('j.joinpgm_id', $joinId)
                ->whereBetween('transaction_dateoftransaction', array($From, $To))
                ->orderBy('m.merchant_company', 'asc')
                ->get();
            $i = 0;
            $data3 = array();
            if (count($data2) > 0) {
                foreach ($data2 as $row) {

                    if (in_array($row->joinpgm_id, $joinId)) {
                        $data3[$i] = $row;
                        $i++;
                    }
                }
                return response()->json($data3);
            } else {
                return response()->json($data3);
            }




            //  dd($data2);




            //   return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('success',"Success");
        } else {
            return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('danger', "No Record Found");
            $error = array();

            $error['error'] = true;
            return response()->json($error);
        }
    }


    public function getDailyData(Request $request)


    {
        $clickCommission = 0;           //total click amnt
        $leadCommission = 0;            //total lead amnt
        $saleCommission = 0;            //total sale amnt
        $nClick = 0;          //total no of clicks
        $nLead = 0;           //total no of leads
        $nSale = 0;           //total no of sales
        $nImpression = 0;
        $impressionCommission = 0;



        if ($request->date) {
            $date = $request->date;
        } else {
            //$date = date('Y-m-d');
            $date = '2020-05-24';
        }
        if ($request->merchant && $request->affiliate) {
            $Merchant = $request->merchant;
            $Affiliate = $request->affiliate;
        } else {
            $Merchant = 1;
            $Affiliate = 1;
        }






        switch ($Merchant) {
            case 'All': {
                    switch ($Affiliate) {
                        case 'All':
                            $partners = DB::table('partners_joinpgm')->get();

                            $impCount = DB::table('partners_impression_daily')

                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click', 0, 0, 0, "", 0, 0, $date);
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression', 0, 0, 0, '', 0, 0, $date);


                            break;

                        default:
                            $partners = DB::table('partners_joinpgm')
                                ->where('joinpgm_affiliateid', $Affiliate)
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_affiliateid' => $Affiliate,
                                    'imp_date' => $date,
                                ])
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click', 0, $Affiliate, 0, "", 0, 0, $date);
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression', 0, $Affiliate, 0, '', 0, 0, $date);


                            break;
                    }
                    break;
                }

            default: {
                    switch ($Affiliate) {
                        case 'All':
                            $partners = DB::table('partners_joinpgm', 'j')
                                ->leftJoin('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                                ->where([
                                    'p.program_merchantid' => $Merchant,
                                ])
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_merchantid' => $Merchant,
                                    'imp_date'              => $date,
                                ])
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click',  $Merchant, 0, 0, "", 0, 0, $date);
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression',  $Merchant, 0, 0, '', 0, 0, $date);


                            break;
                        default:

                            $partners = DB::table('partners_joinpgm', 'j')
                                ->leftJoin('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                                ->where([
                                    'p.program_merchantid' => $Merchant,
                                    'j.joinpgm_affiliateid' => $Affiliate,

                                ])
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_merchantid' => $Merchant,
                                    'imp_affiliateid' => $Affiliate,
                                    'imp_date'              => $date,
                                ])
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click',  $Merchant, $Affiliate, 0, "", 0, 0, $date);
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression',  $Merchant, $Affiliate, 0, '', 0, 0, $date);


                            break;
                    }
                }
        }
        //    dd($data);


        foreach ($impCount as $row) {
            $nImpression = $row->impr_count +    $nImpression;
            echo $row->impr_count;
        }
        if ($nImpression == NULL) $nImpression = 0;



        if ($partners) {
            $j = 0;
            $joinId = array();
            foreach ($partners as $row) {

                $joinId[$j] = $row->joinpgm_id;
                //   echo "Array = ".$joinId[$j]." ID = ".$row->joinpgm_id."</br>";
                $j++;
            }
            $data['joinId'] = $joinId;


            //  Click

            $dataClick = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([
                    'transaction_dateoftransaction' => $date,
                    'transaction_type' => 'click',

                ])->get();
            if (count($dataClick) > 0) {
                foreach ($dataClick as $row) {
                    $clickCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $clickCommission;
                }
            }
            $nClick = count($dataClick);
            //  Lead
            $dataLead = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([
                    'transaction_dateoftransaction' => $date,
                    'transaction_type' => 'lead',

                ])->get();
            if (count($dataLead) > 0) {
                foreach ($dataLead as $row) {
                    $leadCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $leadCommission;
                }
            }
            $nLead = count($dataLead);

            //  Sale

            $dataSale = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([
                    'transaction_dateoftransaction' => $date,
                    'transaction_type' => 'sale',

                ])->get();
            if (count($dataSale) > 0) {
                foreach ($dataSale as $row) {

                    $transactionId    = $row->transaction_id;
                    $recur      =     $row->transaction_recur;


                    if ($recur == '1') {
                        $dataSaleRecur = DB::table('partners_recur')

                            ->where([
                                'recur_transactionid' => $transactionId,


                            ])->get();

                        if (count($dataSaleRecur) > 0) {
                            $recurId = $dataSaleRecur[0]->recur_id;
                            $dataSaleRecurPayments = DB::table('partners_recurpayments')

                                ->where([
                                    'recurpayments_recurid' => $recurId,


                                ])->get();

                            if (count($dataSaleRecurPayments) > 0) {
                                $saleCommission = $dataSaleRecurPayments[0]->recurpayments_amount + $saleCommission;
                            }
                        }
                    } else {

                        $saleCommission = $row->transaction_amttobepaid + $saleCommission;
                    }
                    $saleCommission =  +$row->transaction_admin_amount +  $saleCommission;
                }
            }
            $nSale = count($dataSale);

            //  Impression
            $dataImpression = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([
                    'transaction_dateoftransaction' => $date,
                    'transaction_type' => 'impression',

                ])->get();
            if (count($dataImpression) > 0) {
                foreach ($dataImpression as $row) {
                    #get the impressioncount(unit) from trans_rates table
                    $imp_amt = $row->transaction_amttobepaid + $row->transaction_admin_amount;
                    $date                 =   $row->transaction_dateoftransaction;
                    $impressionCommission = $imp_amt + $impressionCommission;
                }
            }

            # Asigning All Data to One Array and Send Back
            $data['impCount'] = $impCount;

            $data['nClick'] = $nClick;
            $data['nLead'] = $nLead;
            $data['nSale'] = $nSale;
            $data['nImpression'] = $nImpression;
            $data['clickCommission'] = $clickCommission;
            $data['leadCommission'] = $leadCommission;
            $data['saleCommission'] = $saleCommission;
            $data['impressionCommission'] = $impressionCommission;

            $data['date'] = $date;

            // dd($data);
            return response()->json($data);
            //   return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('success',"Success");
        } else {
            //     return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('danger',"No Record Found");
            //     $error = array();

            //     $error['error'] = true;
            //     return response()->json($error);
        }
    }
    public function getLinkData(Request $request)
    {

        // $From = '2020-02-01';
        // $To = '2022-02-01';
        $From = $request->from;
        $To =$request->to;
        $merchantId = $request->merchant;
        $programs = $request->program;
        $Condition = '';
        if($merchantId=='All' && $programs=='All')
        {
            $Condition.='AllPgms';
        }
        elseif($merchantId=='All' && $programs==$request->program)
        {
          $Condition .='Pgm';
        }
        elseif($programs=='All' && $merchantId==$request->merchant)
        {
            $Condition .='Mer';
        }
        $Links = array();   
        switch ($Condition) {
            case 'AllPgms':
                $data = DB::table('partners_program')
                    ->get();
                break;
            case 'Mer':
                $data = DB::table('partners_program')
                    ->where('program_merchantid', $merchantId)
                    ->get();
                break;
                case 'Pgm':
                    $data = DB::table('partners_program')
                    ->where('program_id', $programs)
                    ->get();
                    break;
            default:
                $data = DB::table('partners_program')
                    ->where('program_id', $programs)
                    ->get();
                break;
        }



        foreach ($data as $row) {
            $pgmid         = $row->program_id;

            $dataBanner = DB::table('partners_banner')
                ->where('banner_programid', $pgmid)
                ->get();

            $counterBanner = 0;
            foreach ($dataBanner as $rows) {

                $From          = SiteHelper::date2mysql($From);
                $To            = SiteHelper::date2mysql($To);
                $total         = ReportsHelper::getLinkInfo($To, $From,  "B" . $rows->banner_id);
                $Links['Banner'][$counterBanner] = $total;
                $counterBanner++;
            }



            $dataText = DB::table('partners_text')
                ->where('text_programid', $pgmid)
                ->get();
            $counterText = 0;

            foreach ($dataText as $rows) {

                $From          = SiteHelper::date2mysql($From);
                $To            = SiteHelper::date2mysql($To);
                $total         = ReportsHelper::getLinkInfo($To, $From,  "T" . $rows->text_id);
                $Links['Text'][$counterText] = $total;
                $counterText++;
            }

            $dataPopup = DB::table('partners_popup')
                ->where('popup_programid', $pgmid)
                ->get();

            $counterPopup = 0;
            foreach ($dataPopup as $rows) {

                $From          = SiteHelper::date2mysql($From);
                $To            = SiteHelper::date2mysql($To);
                $total         = ReportsHelper::getLinkInfo($To, $From,  "P" . $rows->popup_id);
                $Links['Popup'][$counterPopup] = $total;
                $counterPopup++;
            }

            $dataFlash = DB::table('partners_flash')
                ->where('flash_programid', $pgmid)
                ->get();

            $counterFlash = 0;
            foreach ($dataFlash as $rows) {

                $From          = SiteHelper::date2mysql($From);
                $To            = SiteHelper::date2mysql($To);
                $total         = ReportsHelper::getLinkInfo($To, $From,  "F" . $rows->flash_id);
                $Links['Flash'][$counterFlash] = $total;
                $counterFlash++;
            }

            $dataHtml = DB::table('partners_html')
                ->where('html_programid', $pgmid)
                ->get();
            $counterHtml = 0;

            foreach ($dataHtml as $rows) {

                $From          = SiteHelper::date2mysql($From);
                $To            = SiteHelper::date2mysql($To);
                $total         = ReportsHelper::getLinkInfo($To, $From,  "H" . $rows->html_id);
                $Links['Html'][$counterHtml] = $total;
                $counterHtml++;
            }
        }
        // dd($Links);

        return response()->json($Links);
    }

    public function BannerDisplay(Request $request)
    {
       
        $banner =DB::table('partners_banner')->where('banner_id',$request->id)->first();
        return response()->json($banner);
    }
    public function getRecurringData(Request $request)
    {
        $merchantId = 1;

        $data = array();
        $data['Transaction'] =  ReportsHelper::getRecurringTransactions($merchantId);
        $data['pending'] = ReportsHelper::getRecurringCommissions('pending', $merchantId);
        $data['approved'] = ReportsHelper::getRecurringCommissions('approved', $merchantId);

        return response()->json($data);
    }

    public function getForPeriodData(Request $request)
    {
        if ($request->from == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->from;
        }
        if ($request->to == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->to;
        }
        $rejectedamnt = 0;
        $pendingamnt = 0;
        $clickCommission = 0;           //total click amnt
        $leadCommission = 0;            //total lead amnt
        $saleCommission = 0;            //total sale amnt
        $nClick = 0;          //total no of clicks
        $nLead = 0;           //total no of leads
        $nSale = 0;           //total no of sales
        $nImpression = 0;
        $impressionCommission = 0;



        if ($request->date) {
            $date = $request->date;
        } else {
            //$date = date('Y-m-d');
            $date = '2020-05-24';
        }
        if ($request->merchant && $request->affiliate) {
            $Merchant = $request->merchant;
            $Affiliate = $request->affiliate;
        } else {
            $Merchant = 1;
            $Affiliate = 1;
        }






        switch ($Merchant) {
            case 'All': {
                    switch ($Affiliate) {
                        case 'All':
                            $partners = DB::table('partners_joinpgm')->get();

                            $impCount = DB::table('partners_impression_daily')
                                ->whereBetween('imp_date', array($From, $To))
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click', 0, 0, 0, "", $From, $To, '');
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression', 0, 0, 0, '', $From, $To, '');


                            break;

                        default:
                            $partners = DB::table('partners_joinpgm')
                                ->where('joinpgm_affiliateid', $Affiliate)
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_affiliateid' => $Affiliate,
                                    'imp_date' => $date,
                                ])
                                ->whereBetween('imp_date', array($From, $To))
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click', 0, $Affiliate, 0, "", $From, $To, '');
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression', 0, $Affiliate, 0, '', $From, $To, '');


                            break;
                    }
                    break;
                }

            default: {
                    switch ($Affiliate) {
                        case 'All':
                            $partners = DB::table('partners_joinpgm', 'j')
                                ->leftJoin('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                                ->where([
                                    'p.program_merchantid' => $Merchant,
                                ])
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_merchantid' => $Merchant,
                                    'imp_date'              => $date,
                                ])
                                ->whereBetween('imp_date', array($From, $To))
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click',  $Merchant, 0, 0, "", $From, $To, '');
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression',  $Merchant, 0, 0, '', $From, $To, '');


                            break;
                        default:

                            $partners = DB::table('partners_joinpgm', 'j')
                                ->leftJoin('partners_program as p', 'j.joinpgm_programid', '=', 'p.program_id')
                                ->where([
                                    'p.program_merchantid' => $Merchant,
                                    'j.joinpgm_affiliateid' => $Affiliate,

                                ])
                                ->get();
                            $impCount = DB::table('partners_impression_daily')
                                ->where([
                                    'imp_merchantid' => $Merchant,
                                    'imp_affiliateid' => $Affiliate,
                                    'imp_date'              => $date,
                                ])
                                ->whereBetween('imp_date', array($From, $To))
                                ->get();

                            $data['rawClick'] = SiteHelper::GetRawTrans('click',  $Merchant, $Affiliate, 0, "", $From, $To, '');
                            $data['rawImp']   = SiteHelper::GetRawTrans('impression',  $Merchant, $Affiliate, 0, '', $From, $To, '');


                            break;
                    }
                }
        }
        //    dd($data);


        foreach ($impCount as $row) {
            $nImpression = $row->impr_count +    $nImpression;
            echo $row->impr_count;
        }
        if ($nImpression == NULL) $nImpression = 0;



        if ($partners) {
            $j = 0;
            $joinId = array();
            foreach ($partners as $row) {

                $joinId[$j] = $row->joinpgm_id;
                //   echo "Array = ".$joinId[$j]." ID = ".$row->joinpgm_id."</br>";
                $j++;
            }
            $data['joinId'] = $joinId;


            //  Click

            $dataClick = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([

                    'transaction_type' => 'click',

                ])
                ->whereBetween('transaction_dateoftransaction', array($From, $To))
                ->get();

            if (count($dataClick) > 0) {
                foreach ($dataClick as $row) {
                    $clickCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $clickCommission;
                }
            }
            $nClick = count($dataClick);
            //  Lead
            $dataLead = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([

                    'transaction_type' => 'lead',

                ])->whereBetween('transaction_dateoftransaction', array($From, $To))->get();
            if (count($dataLead) > 0) {
                foreach ($dataLead as $row) {
                    $leadCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $leadCommission;
                }
            }
            $nLead = count($dataLead);

            //  Sale

            $dataSale = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([

                    'transaction_type' => 'sale',

                ])->whereBetween('transaction_dateoftransaction', array($From, $To))->get();
            if (count($dataSale) > 0) {
                foreach ($dataSale as $row) {

                    $transactionId    = $row->transaction_id;
                    $recur      =     $row->transaction_recur;


                    if ($recur == '1') {
                        $dataSaleRecur = DB::table('partners_recur')

                            ->where([
                                'recur_transactionid' => $transactionId,


                            ])->get();

                        if (count($dataSaleRecur) > 0) {
                            $recurId = $dataSaleRecur[0]->recur_id;
                            $dataSaleRecurPayments = DB::table('partners_recurpayments')

                                ->where([
                                    'recurpayments_recurid' => $recurId,


                                ])->get();

                            if (count($dataSaleRecurPayments) > 0) {
                                $saleCommission = $dataSaleRecurPayments[0]->recurpayments_amount + $saleCommission;
                            }
                        }
                    } else {

                        $saleCommission = $row->transaction_amttobepaid + $saleCommission;
                    }
                    $saleCommission =  +$row->transaction_admin_amount +  $saleCommission;
                }
            }
            $nSale = count($dataSale);

            //  Impression
            $dataImpression = DB::table('partners_transaction')
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([

                    'transaction_type' => 'impression',

                ])->whereBetween('transaction_dateoftransaction', array($From, $To))->get();
            if (count($dataImpression) > 0) {
                foreach ($dataImpression as $row) {
                    #get the impressioncount(unit) from trans_rates table
                    $imp_amt = $row->transaction_amttobepaid + $row->transaction_admin_amount;
                    $date                 =   $row->transaction_dateoftransaction;
                    $impressionCommission = $imp_amt + $impressionCommission;
                }
            }

            $dataReversedRecur = DB::table('partners_transaction', 't')

                ->join('partners_recur as r', 't.transaction_id', '=', 'r.recur_transactionid')
                ->join('partners_recurpayments as rp', 'r.recur_id', '=', 'rp.recurpayments_recurid')
                ->whereBetween('t.transaction_dateoftransaction', array($From, $To))
                ->whereIn('t.transaction_joinpgmid', $joinId)
                ->where([
                    'rp.recurpayments_status' => 'reversed',

                ])
                ->get();

            if (count($dataReversedRecur) > 0) {
                foreach ($dataReversedRecur as $row) {
                    $rejectedamnt = $row->recurpayments_amount + $rejectedamnt;
                }
            }
            #  End Reversed Payments

            #   Pending Payments

            $dataPending = DB::table('partners_transaction')
                ->whereBetween('transaction_dateoftransaction', array($From, $To))
                ->whereIn('transaction_joinpgmid', $joinId)
                ->where([
                    'transaction_status' => 'pending',


                ])->get();

            foreach ($dataPending as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $dataPendingRecur = DB::table('partners_recur')

                        ->where([
                            'recur_transactionid' => $transactionId,


                        ])->get();

                    if (count($dataPendingRecur) > 0) {
                        $row_recur    = $dataPendingRecur[0];
                        $recurId    = $row_recur->recur_id;
                        $dataPendingRecurPayments = DB::table('partners_recurpayments')

                            ->where([
                                'recurpayments_recurid' => $recurId,
                                'recurpayments_status' => 'pending',


                            ])->get();
                        if (count($dataPendingRecurPayments) > 0) {
                            $row_recurpay     = $dataPendingRecurPayments[0];
                            $pendingamnt      =  $row_recurpay->recurpayments_amount + $pendingamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $pendingamnt = $row->transaction_amttobepaid + $pendingamnt; //total pending amnt
                }
            }


            # Asigning All Data to One Array and Send Back
            $data['impCount'] = $impCount;
            $data['nClick'] = round($nClick, 2);
            $data['nLead'] = round($nLead, 2);
            $data['nSale'] = round($nSale, 2);
            $data['nImpression'] = round($nImpression, 2);
            $data['clickCommission'] = round($clickCommission, 2);
            $data['leadCommission'] = round($leadCommission, 2);
            $data['saleCommission'] = round($saleCommission, 2);
            $data['impressionCommission'] = round($impressionCommission, 2);;
            $data['pendingamnt'] = round($pendingamnt, 2);
            $data['rejectedamnt'] = round($rejectedamnt, 2);
            $data['date'] = $date;

            // dd($data);







            return response()->json($data);
            //   return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('success',"Success");
        } else {
            //     return view('report.index', compact('data', 'data2', 'merchants', 'affiliates', 'tabId'))->with('danger',"No Record Found");

            //     return response()->json($error);
        }
    }

    public function getRefererData(Request $request)
    {

        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->From;
        }
        if ($request->Fo == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }
        $From = $request->From;
        $To = $request->To;
        $Sale = $request->Sale;
        $Lead = $request->Lead;
        $Impression = $request->Impression;
        $Click = $request->Click;
        if ($request->Program == 'All' && $request->Merchant == 'All') {
            $programs = 'Allpgms';
        } else {
            $programs = $request->Program;
        }

        $merchantId = $request->Merchant;
        // $programs = "Allpgms";
        // $merchantId =1;
        session(['merchantId' => $merchantId]);
        session(['programId' => $programs]);
        // $Sale = 'sale';
        // $Lead = 'lead';
        // $Impression = 'impression';
        // $Click = 'click';


        # getiing all programs
        switch ($programs) {
            case 'Allpgms':


                $data = DB::table('partners_transaction', 'T')


                    ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                    ->join('partners_program as P', 'J.joinpgm_programid', '=', 'P.program_id')
                    ->join('partners_affiliate as A', 'J.joinpgm_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'P.program_id',
                        'J.joinpgm_id',
                        'T.transaction_id',
                        'T.transaction_ip',
                        'T.transaction_country',
                        'T.transaction_type',
                        'T.transaction_status',
                        'T.transaction_referer',
                        'T.transaction_dateoftransaction as transDate',
                        'A.*',

                    )
                    ->where(function($query) use ($Impression, $Lead,$Click,$Sale) {
                        $query->orWhere([
    
                            'transaction_type' => $Impression,
                        ])
                        ->orWhere([
                            'transaction_type' => $Lead,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Click,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Sale,
        
        
                        ]);
    
                    })

                    ->whereBetween('transaction_dateoftransaction', array($From, $To))
                    ->orderBy('T.transaction_type', 'asc')
                    ->get();

                $ImpDate = DB::table('partners_impression_daily', 'I')
                    ->join('partners_affiliate as A', 'I.imp_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'I.imp_date as impDate'
                    )
                    ->get();


                break;

            case 'All':

                $data = DB::table('partners_transaction', 'T')


                    ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                    ->join('partners_program as P', function ($join) {

                        $join->on('J.joinpgm_programid', '=', 'P.program_merchantid')
                            ->where('P.program_merchantid', '=',   session('merchantId'));
                    })
                    ->join('partners_affiliate as A', 'J.joinpgm_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'P.program_id',
                        'J.joinpgm_id',
                        'T.transaction_id',
                        'T.transaction_ip',
                        'T.transaction_country',
                        'T.transaction_type',
                        'T.transaction_status',
                        'T.transaction_referer',
                        'T.transaction_dateoftransaction as transDate',
                        'A.*',
                    )

                    ->where(function($query) use ($Impression, $Lead,$Click,$Sale) {
                        $query->orWhere([
    
                            'transaction_type' => $Impression,
                        ])
                        ->orWhere([
                            'transaction_type' => $Lead,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Click,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Sale,
        
        
                        ]);
    
                    })

                    ->whereBetween('transaction_dateoftransaction', array($From, $To))
                    ->orderBy('T.transaction_type', 'asc')
                    ->get();

                $ImpDate = DB::table('partners_impression_daily', 'I')

                    ->join('partners_affiliate as A', 'I.imp_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'I.imp_date as impDate'
                    )
                    ->where('imp_merchantid', '=', $merchantId)
                    ->get();

                break;

            default:
                $data = DB::table('partners_transaction', 'T')
                    ->join('partners_joinpgm as J', 'T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                    ->join('partners_program as P', function ($join) {

                        $join->on('J.joinpgm_programid', '=', 'P.program_merchantid')
                            ->where('P.program_id', '=',   session('programId'));
                    })
                    ->join('partners_affiliate as A', 'J.joinpgm_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'P.program_id',
                        'J.joinpgm_id',
                        'T.transaction_id',
                        'T.transaction_ip',
                        'T.transaction_country',
                        'T.transaction_type',
                        'T.transaction_status',
                        'T.transaction_referer',
                        'T.transaction_dateoftransaction as transDate',
                        'A.*',
                    )

                    ->where(function($query) use ($Impression, $Lead,$Click,$Sale) {
                        $query->orWhere([
    
                            'transaction_type' => $Impression,
                        ])
                        ->orWhere([
                            'transaction_type' => $Lead,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Click,
        
                        ])
                        ->orWhere([
        
                            'transaction_type' => $Sale,
        
        
                        ]);
    
                    })

                    ->whereBetween('transaction_dateoftransaction', array($From, $To))
                    ->orderBy('T.transaction_type', 'asc')
                    ->get();

                $ImpDate = DB::table('partners_impression_daily', 'I')

                    ->join('partners_affiliate as A', 'I.imp_affiliateid', '=', 'A.affiliate_id')
                    ->select(
                        'I.imp_date as impDate'
                    )
                    ->where('I.imp_programid', '=', $programs)
                    ->get();



                break;
        }
        $Arr = array();
        $Arr['data'] = $data;
        $Arr['ImpDate'] = $ImpDate;
        return response()->json($Arr);
        // dd($Arr);

    }
    public function getAffiliateReferralData()
    {
        $Arr = array();
        $dataParentId = DB::table('partners_affiliate')
            ->where('affiliate_parentid', '!=', 0)
            ->distinct()
            ->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('partners_affiliate');

        $j = 0;
        if ($dataParentId) {
            foreach ($dataParentId as $key => $row) {

                $Arr[$j]['affiliate_id'] = $row->affiliate_id;
                $Arr[$j]['affiliate_firstname'] = $row->affiliate_firstname;
                $Arr[$j]['affiliate_lastname'] = $row->affiliate_lastname;
                $Arr[$j]['affiliate_date'] = $row->affiliate_date;
                $Arr[$j]['affiliate_parentid'] = $row->affiliate_parentid;

                $parent = DB::table('partners_affiliate')
                    ->where('affiliate_id', $row->affiliate_parentid)
                    ->select('affiliate_firstname as pA_name', 'affiliate_lastname as pL_name')
                    ->first();
                $Arr[$j]['pA_name'] = $parent->pA_name;
                $Arr[$j]['pL_name'] = $parent->pL_name;
                $Arr[$j]['referralCount'] = DB::table('partners_affiliate')
                    ->where('affiliate_id', $row->affiliate_parentid)
                    ->count();
                $j++;
            }
        }

        return response()->json($Arr);
    }
    public function getReferralCommissionData(Request $request)
    {
        $Arr = array();
        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->From;
        }
        if ($request->Fo == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }
        $data = DB::table('partners_affiliate', 'A')
            ->join('partners_transaction_subsale as S', 'A.affiliate_id', '=', 'S.subsale_affiliateid')
            ->whereBetween('S.subsale_date', array($From, $To))
            ->orderby('S.subsale_affiliateid', 'asc')->distinct()->get();

        $i = 0;
        foreach ($data as $row) {
            session(['affId' => $row->affiliate_id]);

            $Arr[$i]['affiliate_id'] = $row->affiliate_id;
            $Arr[$i]['affiliate_company'] = $row->affiliate_company;
            $Arr[$i]['subsale_id'] = $row->subsale_id;
            $Arr[$i]['subsale_amount'] = $row->subsale_amount;

            $Arr[$i]['subsale_id_count'] = DB::table('partners_affiliate', 'A')
                ->join('partners_transaction_subsale as S', function ($join) {
                    $join->on('A.affiliate_id', '=', 'S.subsale_affiliateid')
                        ->where('S.subsale_affiliateid', '=', session('affId'));
                })
                ->whereBetween('S.subsale_date', array($From, $To))
                ->count('S.subsale_id');

            $Arr[$i]['subsale_amount_sum'] = DB::table('partners_affiliate', 'A')
                ->join('partners_transaction_subsale as S', function ($join) {
                    $join->on('A.affiliate_id', '=', 'S.subsale_affiliateid')
                        ->where('S.subsale_affiliateid', '=', session('affId'));
                })
                ->whereBetween('S.subsale_date', array($From, $To))
                ->orderby('S.subsale_affiliateid', 'asc')->sum('S.subsale_amount');
            $i++;
        }

        return response()->json($Arr);
    }
    public function subsale($id){
        return view('report.subsaleaffiliate' , compact('id'));
    }
    public function getSubReferralCommission(Request $request)
    {
        session(['Id' => $request->id]);
        $Arr = array();
        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->From;
        }
        if ($request->Fo == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }
        $data = DB::table('partners_affiliate', 'A')
        ->join('partners_transaction_subsale as S', function ($join) {
            $join->on('A.affiliate_id', '=', 'S.subsale_childaffiliateid')
                ->where('A.affiliate_id', '=', session('Id'))->distinct();
        })->whereBetween('S.subsale_date', array($From, $To))
            ->orderby('S.subsale_affiliateid', 'asc')->distinct()->get();

        $i = 0;
        foreach ($data as $row) {
            session(['subaffId' => $row->affiliate_id]);

            $Arr[$i]['affiliate_id'] = $row->affiliate_id;
            $Arr[$i]['affiliate_company'] = $row->affiliate_company;
            $Arr[$i]['subsale_id'] = $row->subsale_id;
            $Arr[$i]['subsale_amount'] = $row->subsale_amount;

            $Arr[$i]['subsale_id_count'] = DB::table('partners_affiliate', 'A')
                ->join('partners_transaction_subsale as S', function ($join) {
                    $join->on('A.affiliate_id', '=', 'S.subsale_childaffiliateid')
                        ->where('S.subsale_affiliateid', '=', session('subaffId'));
                })
                ->whereBetween('S.subsale_date', array($From, $To))
                ->count('S.subsale_id');

            $Arr[$i]['subsale_amount_sum'] = DB::table('partners_affiliate', 'A')
                ->join('partners_transaction_subsale as S', function ($join) {
                    $join->on('A.affiliate_id', '=', 'S.subsale_childaffiliateid')
                        ->where('S.subsale_affiliateid', '=', session('subaffId'));
                })
                ->whereBetween('S.subsale_date', array($From, $To))
                ->orderby('S.subsale_affiliateid', 'asc')->sum('S.subsale_amount');
            $i++;
        }

        return response()->json($Arr);
    }
    public function getGraphsData(Request $request)
    {
        if ($Merchant = $request->Merchant) {
            $Merchant = $request->Merchant;
        } else {
            $Merchant = 2;
        }
        if ($Affiliate = $request->Affiliate) {
            $Affiliate = $request->Affiliate;
        } else {
            $Affiliate = 1;
        }
        $i = $j = 0;
        $data = array();
        $joinId = array();
        $linkId = array();
        session()->put('merchantId', $Merchant);
        session()->put('affiliateId', $Affiliate);

        $data['Affiliates'] = DB::table('partners_affiliate', 'A')
            ->join('partners_joinpgm as J', function ($join) {

                $join->on('A.affiliate_id', '=', 'J.joinpgm_affiliateid')
                    ->where(
                        [
                            'J.joinpgm_merchantid' => session('merchantId'),
                            'J.joinpgm_status' => 'approved',
                        ]
                    );
            })
            ->select(
                'A.affiliate_id',
                'A.affiliate_company',
            )->distinct()->get();
        if ($Affiliate == 'All') {
            $data['joinId'] = DB::table('partners_transaction', 'T')
                ->join('partners_joinpgm as J', function ($join) {

                    $join->on('T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                        ->where(
                            [
                                'J.joinpgm_merchantid' => session('merchantId'),

                            ]
                        );
                })
                ->select(
                    'T.transaction_linkid',
                    'T.transaction_joinpgmid',
                )
                ->where('T.transaction_type', '=', 'click')
                ->distinct()->get();
        } else {
            $data['joinId'] = DB::table('partners_transaction', 'T')
                ->join('partners_joinpgm as J', function ($join) {

                    $join->on('T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                        ->where(
                            [
                                'J.joinpgm_merchantid' => session('merchantId'),
                                'J.joinpgm_affiliateid' => session('affiliateId'),

                            ]
                        );
                })
                ->select(
                    'T.transaction_linkid',
                    'T.transaction_joinpgmid',
                )
                ->where('T.transaction_type', '=', 'click')
                ->distinct()->get();
        }
        foreach ($data['joinId'] as $row) {
            $joinId[$i] = $row->transaction_joinpgmid;
            $linkId[$i] = $row->transaction_linkid;
        }

        $data['Click'] = DB::table('partners_transaction', 'T')
            ->join('partners_joinpgm as J', function ($join) {

                $join->on('T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                    ->where(
                        [
                            'J.joinpgm_merchantid' => session('merchantId'),


                        ]
                    );
            })
            ->orWhere('joinpgm_affiliateid', '=', $Affiliate)
            ->whereIn('J.joinpgm_id', $joinId)
            ->whereIn('T.transaction_linkid', $linkId)
            ->select(
                'T.transaction_dateoftransaction',
                'J.joinpgm_id',

            )
            ->where('T.transaction_type', '=', 'click')
            ->orderby('T.transaction_dateoftransaction', 'asc')
            ->distinct()->get();
        $data['Sale'] = DB::table('partners_transaction', 'T')
            ->join('partners_joinpgm as J', function ($join) {

                $join->on('T.transaction_joinpgmid', '=', 'J.joinpgm_id')
                    ->where(
                        [
                            'J.joinpgm_merchantid' => session('merchantId'),


                        ]
                    );
            })
            ->orWhere('joinpgm_affiliateid', '=', $Affiliate)
            ->whereIn('J.joinpgm_id', $joinId)
            ->whereIn('T.transaction_linkid', $linkId)
            ->select(
                'T.transaction_dateoftransaction',
                'J.joinpgm_id',

            )
            ->where('T.transaction_type', '=', 'sale')
            ->orderby('T.transaction_dateoftransaction', 'asc')
            ->distinct()->get();
        $clickdate = $saledate = "";

        for ($i = 0; $i < count($data['Click']); $i++) {
        }


        $data['Affiliate'] = $Affiliate;
        $data['Merchant'] = $Merchant;
        return response()->json($data);
    }

    public function getProductsData(Request $request)
    {

        if ($request->From == '') {
            $From = "0000-00-00";
        } else {
            $From = $request->From;
        }
        if ($request->Fo == '') {
            $To = date("Y-m-d");
        } else {
            $To = $request->To;
        }





        if ($request->Sale) {
            $Sale = $request->Sale;
        } else {
            $Sale = 'sale';
        }
        if ($request->Lead) {
            $Lead = $request->Lead;
        } else {
            $Lead = 'lead';
        }
        if ($request->Click) {
            $Click = $request->Click;
        } else {
            $Click = 'click';
        }




        $programs = $request->Program;
        $merchantId = $request->Merchant;
        if ($programs == 'All' && $merchantId == 'All') {
            $programs = 'Allpgms';
        }
        $programs = 1;
        $merchantId = 1;
        session(['merchantId' => $merchantId]);
        session(['programId' => $programs]);



        $tsql='';
   switch ($programs) {
    case 'AllPgms':
        $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
        $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";

         if($From!='' &&$To!=''){
           $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
         }
        $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
        $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
        $transSql.= " AND affiliate_id = joinpgm_affiliateid ";


       if($Sale==1 or $Lead==1 or $Click==1){
            $tsql  .= ($Sale==1) ? "OR transaction_type = 'sale' " : "";
        $tsql  .= ($Lead==1) ? "OR  transaction_type = 'lead' " : "";
        $tsql  .= ($Click==1) ? "OR transaction_type = 'click' " : "";

        $tsql = trim($tsql);
        $tsql = trim($tsql,"OR");
        $tsql = " AND (".$tsql.")";
        $transSql .= $tsql;
       }

         break;

   case 'All':
    $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
    $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
    $transSql.= " AND joinpgm_merchantid = '$merchantId' ";
    if($From!='' &&$To!=''){
       $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
    }
    $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
    $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
    $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
    if($Sale==1 or $Lead==1 or $Click==1){
            $tsql  .= ($Sale==1) ? "OR transaction_type = 'sale' " : "";
        $tsql  .= ($Lead==1) ? "OR  transaction_type = 'lead' " : "";
        $tsql  .= ($Click==1) ? "OR transaction_type = 'click' " : "";

        $tsql = trim($tsql);
        $tsql = trim($tsql,"OR");
        $tsql = " AND (".$tsql.")";
        $transSql .= $tsql;
    }

    break;

  default:
    $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
    $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
    $transSql.= " AND joinpgm_programid = '$programs' ";
    if($From!='' &&$To!=''){
       $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
    }
    $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
    $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
    $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
    if($Sale==1 or $Lead==1 or $Click==1){
        $tsql  .= ($Sale==1) ? "OR transaction_type = 'sale' " : "";
        $tsql  .= ($Lead==1) ? "OR  transaction_type = 'lead' " : "";
        $tsql  .= ($Click==1) ? "OR transaction_type = 'click' " : "";
        $tsql = trim($tsql);
        $tsql = trim($tsql,"OR");
        $tsql = " AND (".$tsql.")";
        $transSql .= $tsql;
     }


     break;
   }
        $data = DB::select($transSql);
        return response()->json(['data'=>$data]);

    }
}
