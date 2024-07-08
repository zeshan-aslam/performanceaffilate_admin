<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Utilities\SiteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use \App\Mail\testMail;

class OptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
    }

    public function index()
    {

        return view('options.index');
    }
    public function fillFields()
    {
        $data = DB::table('admin_constants')->where(['constant_key' => 'siteTitle'])->first();
        return response()->json($data);
    }
    public function updateUserEmail(Request $request)
    {
        if (Auth::check()) {
            $user = DB::table('users')
            ->where('id','!=',Auth::user()->id)
            ->where('email','=', $request->email)
            ->exists();
            if ($user) {
                $res = 0;
                return response()->json($res);
            }elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $res='inValid';
                return response()->json($res);
            }
            else {
                $res = DB::table('users')
                    ->where(['id' => Auth::user()->id])
                    ->limit(1)
                    ->update(array('email' => $request->email));

                return response()->json($res);
            }
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }
    public function updateUserName(Request $request)
    {
        if (Auth::check()) {
            $user = DB::table('users')->where(['username' => $request->username])->exists();
            if ($user) {
                $res = 0;
                return response()->json($res);
            } else {
                $res = DB::table('users')
                    ->where(['id' => Auth::user()->id])
                    ->limit(1)
                    ->update(array('username' => $request->username));

                return response()->json($res);
            }
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }


    public function updateUserPassword(Request $request)
    {

        if (Auth::check()) {

            if (Hash::check($request->currentPassword, Auth::user()->password)) {
                $res = DB::table('users')
                    ->where(['id' => Auth::user()->id])
                    ->limit(1)
                    ->update(array('password' => Hash::make($request->userPassword)));

                return response()->json($res);
            } else {
                $res = 2;
                return response()->json($res);
            }
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }

    public function updateSiteInfo(Request $request)
    {
        $resSiteTitle = SiteHelper::setConstant('siteTitle', $request->siteTitle);
        $resSiteLines = SiteHelper::setConstant('lines', $request->siteLines);
        if ($resSiteTitle == 1 || $resSiteLines == 1) {
            $res = 1;
            return response()->json($res);
        } elseif ($resSiteTitle == 0 && $resSiteLines == 0) {
            $res = 0;
            return response()->json($res);
        } else {
            $res = 2;
            return response()->json($res);
        }
    }
    public function updateSiteError(Request $request)
    {
        $filename =  public_path('files/error.htm');
        $fp = fopen($filename, 'w');
        $check = fwrite($fp, $request->siteError);
        fclose($fp);
        if ($check) {
            $response = 1;
            return response()->json($response);
        } else {
            $response = 0;
            return response()->json($response);
        }
    }
    /////////////////////////////////////////
    public function getPaymentGateways()
    {
        $data = DB::table('partners_paymentgateway')->get();

        return response()->json([
            'message' => 'Data Found',
            'code' => '200',
            'data' => $data,
        ]);
    }


    public function updateGateway(Request $request)
    {
        if (Auth::check()) {


            $res = DB::table('partners_paymentgateway')
                ->where(['pay_id' => $request->id])
                ->limit(1)
                ->update(array('pay_status' => $request->pay_status));

            return response()->json($res);
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }

    public function getcatagories()
    {
        $data = DB::table('partners_category')->get();

        return response()->json($data);
    }

    public function insertCatagory(Request $request)
    {
        $checkData = DB::table('partners_category')->where(['cat_name' => $request->catName])->exists();
        if (!$checkData) {
            $data = DB::table('partners_category')->insert(
                ['cat_name' => $request->catName]
            );
            return response()->json($data);
        } else {
            $data = 0;
            return response()->json($data);
        }
    }
    public function deleteCatagory(Request $request)
    {
        $checkData = DB::table('partners_category')
            ->where(['cat_id' => $request->catId])->delete();

        return response()->json($checkData);
    }

    /////////////////////////////////////////
    public function getMerchantEvents()
    {
        $data = DB::table('partners_event')->get();

        return response()->json([
            'message' => 'Data Found',
            'code' => '200',
            'data' => $data,
        ]);
    }
    public function updateMerchantEvents(Request $request)
    {

        $data=array();
        $i=1;
        foreach($request->event as $key=>$value){
            $data[] = DB::table('partners_event')
            ->where('id','=',$key)
            ->update([
                'event_status'=>$value

            ]);
            $i++;
        }


       if(in_array(1,$data))
       {
        return redirect()->route('Options.index')
        ->with('eventSuccess','Events Updated');
        }
      elseif(in_array(0,$data))
        {
         return redirect()->route('Options.index')
         ->with('eventSuccess','Events Updated');
         }
         else
         {
          return redirect()->route('Options.index')
          ->with('eventDanger','Error in Updating Events');
          }

    }

    //////////////Admin Mail////////////

    public function getAdminMailOptions()
    {
        $data = DB::table('partners_admin')->first();

        return response()->json($data);
    }
    public function updateAdminMailOptions(Request $request)
    {
        if (Auth::check()) {


            $res = DB::table('partners_admin')
                ->update(array(
                    'admin_mailheader' => $request->adminMailHeader,
                    'admin_mailfooter' => $request->adminMailFooter
                ));

            return response()->json($res);
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }
    public function updateAdminAmount(Request $request)
    {
        if (Auth::check()) {


            $res = DB::table('partners_admin')
                ->update(array(
                    'admin_mailamnt' => $request->adminAmount
                ));

            return response()->json($res);
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }

    public function updatePayments(Request $request)
    {
        if (Auth::check()) {


            // if ($request->key == 'siteMembValue') {
            //     SiteHelper::setConstant('siteMembType', '2');
            //     return SiteHelper::setConstant($request->key, $request->value);
            // } elseif ($request->key == 'siteProgramValue') {
            //     SiteHelper::setConstant('siteProgramType', '2');
            //     return SiteHelper::setConstant($request->key, $request->value);
            // } else
            if (is_array($request->key)) {
                $i=1;
                $ret =array();
                foreach($request->key as $key){
                    $ret[]=SiteHelper::setConstant($request->key[$i], $request->value[$i]);
                }

                if (in_array(1,$ret)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return SiteHelper::setConstant($request->key, $request->value);
            }
        } else {
            $res = 'User Not Logged in ';
            return response()->json($res);
        }
    }

    #== Languages Section ==#
    public function getSiteLanguages()
    {
        $data = DB::table('partners_languages')->get();

        return response()->json($data);
    }
    public function addLanguage(Request $request)
    {
        $res = DB::table('partners_languages')
            ->insertOrIgnore(
                [
                    'languages_name' => $request->languages_name,
                    'languages_status' => $request->languages_status
                ]

            );

        return response()->json($res);
    }
    public function showLanguage(Request $request)
    {
        $res = DB::table('partners_languages')
            ->where(['languages_id' => $request->languages_id])
            ->first();

        return response()->json($res);
    }
    public function updateLanguage(Request $request)
    {
        $res = DB::table('partners_languages')
            ->where('languages_id', $request->languages_id)
            ->limit(1)
            ->updateOrInsert([
                'languages_name' => $request->languages_name,
                'languages_status' => $request->languages_status
            ]);


        return response()->json($res);
    }
    public function deleteLanguage(Request $request)
    {
        $res = DB::table('partners_languages')
            ->where('languages_id', $request->languages_id)
            ->delete();

        return response()->json($res);
    }
    #== Currency Section ==#
    public function getCurrencies()
    {
        $data = array();
        $data['data'] = DB::table('partners_currency', 'C')
            ->join('partners_currency_relation as R', 'C.currency_code', '=', 'R.relation_currency_code')
            ->join('partners_merchant as M', 'C.currency_caption', '=', 'M.merchant_currency')
            ->select('C.*', 'R.*')
            ->orderby('relation_date', 'DESC')
            ->distinct()->get();

        $data['currency'] = DB::table('partners_currency')
            ->where('currency_code', SiteHelper::getConstant('siteCurrencyCode'))
            ->first();


        return response()->json($data);
    }
    public function addCurrency(Request $request)
    {
        $resCu = DB::table('partners_currency')
            ->insert(
                [
                    'currency_code' => $request->curCode,
                    'currency_caption' => $request->curCaption,
                    'currency_symbol' => $request->curSymbol,
                ]

            );
        $resRe = DB::table('partners_currency_relation')
            ->insert(
                [
                    'relation_currency_code' => $request->curCode,
                    'relation_value' => $request->curRelation,
                    'relation_date' => date("Y-m-d"),

                ]

            );
        if ($resCu && $resRe) {
            $res = 1;
            return response()->json($res);
        } else {
            $res = 0;
            return response()->json($res);
        }
    }
    public function showCurrency(Request $request)
    {
        $res = DB::table('partners_currency')
            ->where(['currency_id' => $request->currency_id])
            ->first();

        return response()->json($res);
    }
    public function updateCurrencyValue(Request $request)
    {



        $currentCurrency = DB::table('partners_currency_relation')
            ->where(['relation_currency_code' => 'GBP'])
            ->first();


        if (SiteHelper::getConstant('siteCurrencyCode') == $request->curCode) {
            $res = 0;
            return response()->json($res);
        } elseif ($currentCurrency->relation_value == 1) {
            session(['curCode' => $request->curCode]);
            $data = DB::table('partners_currency', 'C')
                ->join('partners_currency_relation as R', function ($join) {
                    $join->on('C.currency_code', '=', 'R.relation_currency_code')
                        ->where('C.currency_code', '=',   session('curCode'));
                })
                ->select('C.*', 'R.*')
                ->orderby('relation_date', 'DESC')
                ->distinct()->first();


            if ($data) {
                $res = SiteHelper::ConvertToPreviousBaseCurrency(SiteHelper::getConstant('siteCurrencyCode'));
                $res = DB::table('partners_currency_relation')
                    ->where('relation_currency_code', $request->relation_currency_code)
                    ->limit(1)
                    ->update([
                        'relation_value' => $request->relation_value,
                    ]);
                $res = SiteHelper::ConvertToNewBaseCurrency($request->relation_currency_code);
                return response()->json($res);
            } else {
                $res = 2;
                return response()->json($res);
            }
        }
    }
    public function deleteCurrency(Request $request)
    {

        $checkData = DB::table('partners_currency', 'C')
            ->join('partners_merchant as M', 'C.currency_caption', '=', 'M.merchant_currency')
            ->select('C.*', 'M.*')
            ->orderby('M.merchant_currency', 'DESC')
            ->distinct()->get();
        if ($checkData) {
            $res = 2;
            return response()->json($res);
        } else {
            $res = DB::table('partners_currency')
                ->where('currency_id', $request->currency_id)
                ->delete();

            return response()->json($res);
        }
    }
    public function changeCurrency(Request $request)
    {
        $currentCurrency = DB::table('partners_currency_relation')
            ->where(['relation_currency_code' => 'GBP'])
            ->first();


        if (SiteHelper::getConstant('siteCurrencyCode') == $request->curCode) {
            $res = 0;
            return response()->json($res);
        } elseif ($currentCurrency->relation_value == 1) {
            session(['curCode' => $request->curCode]);
            $data = DB::table('partners_currency', 'C')
                ->join('partners_currency_relation as R', function ($join) {
                    $join->on('C.currency_code', '=', 'R.relation_currency_code')
                        ->where('C.currency_code', '=',   session('curCode'));
                })
                ->select('C.*', 'R.*')
                ->orderby('relation_date', 'DESC')
                ->distinct()->first();


            if ($data && SiteHelper::getConstant('siteCurrencyCode') != $request->curCode) {
                $res = SiteHelper::ConvertToPreviousBaseCurrency(SiteHelper::getConstant('siteCurrencyCode'));
                $res = SiteHelper::ConvertToNewBaseCurrency($request->curCode);
                SiteHelper::setConstant('siteCurrencyCode', $data->relation_currency_code);
                SiteHelper::setConstant('siteCurrencyCaption', $data->currency_caption);
                return response()->json($res);
            } else {
                $res = 2;
                return response()->json($res);
            }
        }
    }
    public function updateFraudSetting(Request $request)
    {

        $res = array();
        $res[] = SiteHelper::setConstant('siteFraudRecentClick', $request->siteFraudRecentClick);
        $res[] = SiteHelper::setConstant('siteFraudClickSeconds', $request->siteFraudClickSeconds);
        $res[] = SiteHelper::setConstant('siteFraudClickAction', $request->siteFraudClickAction);
        $res[] = SiteHelper::setConstant('siteFraudRecentSale', $request->siteFraudRecentSale);
        $res[] = SiteHelper::setConstant('siteFraudSaleSeconds', $request->siteFraudSaleSeconds);
        $res[] = SiteHelper::setConstant('siteFraudSaleAction', $request->siteFraudSaleAction);
        $res[] = SiteHelper::setConstant('siteFraudDeclineRecentSale', $request->siteFraudDeclineRecentSale);
        $res[] = SiteHelper::setConstant('siteLoginRetry', $request->siteLoginRetry);
        $res[] = SiteHelper::setConstant('siteLoginDelay', $request->siteLoginDelay);

        if (in_array(1, $res)) {
            $response = 1;
            return response()->json($response);
        } else {
            $response = 0;
            return response()->json($response);
        }
    }
    public function updateAffiliateTerms(Request $request)
    {
        $filename =  public_path('files/terms.htm');
        $fp = fopen($filename, 'w');
        $check = fwrite($fp, $request->affiliateTerms);
        fclose($fp);
        if ($check) {
            $response = 1;
            return response()->json($response);
        } else {
            $response = 0;
            return response()->json($response);
        }
    }
    public function updateMerchantTerms(Request $request)
    {
        $filename =  public_path('files/mer_terms.htm');
        $fp = fopen($filename, 'w');
        $check = fwrite($fp, $request->merchantTerms);
        fclose($fp);
        if ($check) {
            $response = 1;
            return response()->json($response);
        } else {
            $response = 0;
            return response()->json($response);
        }
    }
    public function getMailList(Request $request)
    {
        $res = DB::table('partners_login')
            ->where(['login_flag' => $request->flag])
            ->get();

        return response()->json($res);
    }

    public function sendBulkMail(Request $request)
    {
        //Request Variables => bulkFrom,bulkHeader,bulkSubject,bulkFooter,bulkBody
        $res = array();
        $mail= array();

        $mail['subject']=$request->bulkSubject;
        $mail['header']=$request->bulkHeader;
        $mail['body']=$request->bulkBody;
        $mail['footer']=$request->bulkFooter;


        if (is_array($request->mails)) {

            foreach ($request->mails as $key => $value) {

                $res[] = Mail::to($value)->send(new testMail($mail));
            }
            if (in_array(true, $res)) {
                $ret = 1;
                return response()->json($ret);
            } else {
                $ret = 0;
                return response()->json($ret);
            }
        } else {
            if (!filter_var($request->mails, FILTER_VALIDATE_EMAIL)) {
                $res='inValid Email';
                return response()->json($res);
            }else if (Mail::to($request->mails)->send(new testMail($mail))) {
                $ret = 1;
                return response()->json($ret);
            } else {
                $ret = 0;
                return response()->json($ret);
            }
        }
    }
    public function fillEventsMailSetup(Request $request)
    {
        //Request Variables => mailSetupTestTo,mailSetupStatus,
        //,mailSetupEvent,mailSetupFrom,mailSetupSubject,mailSetupHeader
        //,mailSetupBody,mailSetupFooter
        session(['eventName' => $request->mailSetupEvent]);
        $data = DB::table('partners_adminmail', 'M')
            ->join('partners_event as E', 'M.adminmail_eventname', '=', 'E.event_name')
            ->select('E.*')
            ->orderby('E.event_name', 'DESC')
            ->distinct()->get();

        return response()->json($data);
    }
    public function getMailSetup(Request $request)
    {
        //Request Variables => mailSetupTestTo,mailSetupStatus,
        //,mailSetupEvent,mailSetupFrom,mailSetupSubject,mailSetupHeader
        //,mailSetupBody,mailSetupFooter
        session(['eventName' => $request->mailSetupEvent]);
        $data = DB::table('partners_adminmail', 'M')
            ->join('partners_event as E', function ($join) {
                $join->on('E.event_name', '=', 'M.adminmail_eventname')
                    ->where('M.adminmail_eventname', '=',   session('eventName'));
            })
            ->select('M.*', 'E.*')
            ->orderby('E.event_name', 'DESC')
            ->distinct()->first();

        return response()->json($data);
    }
    public function updateMailSetup(Request $request)
    {
        //Request Variables => mailSetupTestTo,mailSetupStatus,
        //,mailSetupEvent,mailSetupFrom,mailSetupSubject,mailSetupHeader
        //,mailSetupBody,mailSetupFooter
        // return response()->json($request);
        //Replace variable in the content with values
        $body=$request->mailSetupBody;
        $body=str_replace("[aff_firstname]",'$affiliate_firstname',$body);
        $body=str_replace("[aff_lastname]",'$affiliate_lastname',$body);
        $body=str_replace("[aff_company]",'$affiliate_company',$body);
        $body=str_replace("[aff_email]",'$login_email',$body);
        $body=str_replace("[aff_loginlink]",'$affiliate_url',$body);
        $body=str_replace("[aff_password]",'$login_password',$body);

        $body=str_replace("[mer_firstname]",'$merchant_firstname',$body);
        $body=str_replace("[mer_lastname]",'$merchant_lasttname',$body);
        $body=str_replace("[mer_company]",'$merchant_company',$body);
        $body=str_replace("[mer_email]",'$login_email',$body);
        $body=str_replace("[mer_loginlink]",'$merchant_url',$body);
        $body=str_replace("[mer_password]",'$login_password',$body);

        $body=str_replace("[from]",'$admin_email',$body);
        $body=str_replace("[commission]",'$commission_amount',$body);
        $body=str_replace("[program]",'$program_url',$body);
        $body=str_replace("[type]",'$transaction_type',$body);
        $body=str_replace("[date]",'$transaction_dateoftransaction',$body);
        $body=str_replace("[today]",date('d:m:Y'),$body);
        $ret = array();
    if (!filter_var($request->mailSetupFrom, FILTER_VALIDATE_EMAIL)) {
        $res='inValid Email';
        return response()->json($res);
    }
        $ret[] = DB::table('partners_adminmail')
            ->where('adminmail_eventname', $request->mailSetupEvent)
            ->limit(1)
            ->update([
                'adminmail_from' => $request->mailSetupFrom,
                'adminmail_subject' => $request->mailSetupSubject,
                'adminmail_header' => $request->mailSetupHeader,
                'adminmail_footer' => $request->mailSetupFooter,
                'adminmail_message' => $body
            ]);
        $ret[] = DB::table('partners_event')
            ->where('event_name', $request->mailSetupEvent)
            ->limit(1)
            ->update([
                'event_status' => $request->mailSetupStatus,
            ]);
        if (in_array(0, $ret)) {
            $res = 0;
            return response()->json($res);
        } else {
            $res = 1;
            $mail= array();
            $mail['subject']=$request->mailSetupSubject;
            $mail['header']=$request->mailSetupHeader;
            $mail['body']=$request->mailSetupBody;
            $mail['footer']=$request->mailSetupFooter;
            Mail::to($request->mailSetupTestTo)->send(new testMail($mail));
            return response()->json($res);
        }
    }
}
