<?php

namespace App\Http\Controllers;

use Exception;
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

    // public function index()
    // {

    //     return view('options.index');
    // }
    public function index()
    {
        $columnData = DB::table('wizard_include_services')->pluck('account_type');

        return view('options.index', compact('columnData'));
    }
    public function fillFields()
    {
        $data = DB::table('admin_constants')->where(['constant_key' => 'siteTitle'])->first();
        return response()->json($data);
    }
    public function ADDWizardAccountType(Request $request)
    {
        // return response()->json($request->wizardAccountType);


        $checkData = DB::table('wizard_include_services')->where(['account_type' => $request->wizardAccountType])->exists();

        if (!$checkData) {

            $data = DB::table('wizard_include_services')->insert(
                ['account_type' => $request->wizardAccountType]
            );
            $data = 1;
            return response()->json($data);
        } else {
            $data = 0;
            return response()->json($data);
        }
    }
    public function GETWizardAccountType(Request $request)
    {
        $checkData = DB::table('wizard_include_services')->where(['account_type' => $request->availableAccountType])->exists();

        if ($checkData) {
            $data = DB::table('wizard_include_services')->where(['account_type' => $request->availableAccountType])->get();
            // $data = 1;
            return response()->json($data);
        } else {
            $data = false;
            return response()->json($data);
        }

        //Request Variables => mailSetupTestTo,mailSetupStatus,
        //,mailSetupEvent,mailSetupFrom,mailSetupSubject,mailSetupHeader
        //,mailSetupBody,mailSetupFooter
        // session(['eventName' => $request->mailSetupEvent]);
        // $data = DB::table('partners_adminmail', 'M')
        //     ->join('partners_event as E', function ($join) {
        //         $join->on('E.event_name', '=', 'M.adminmail_eventname')
        //             ->where('M.adminmail_eventname', '=',   session('eventName'));
        //     })
        //     ->select('M.*', 'E.*')
        //     ->orderby('E.event_name', 'DESC')
        //     ->distinct()->first();

        // return response()->json($data);
    }
    public function UpdateWizardServiceContent(Request $request)
    {
        $checkData = DB::table('wizard_include_services')->where(['account_type' => $request->availableAccountType])->exists();

        if ($checkData) {
            $contentUpdated = DB::table('wizard_include_services')
                ->where('account_type', $request->availableAccountType)
                // ->limit(1)
                ->update([
                    'include_service_body' => $request->bodyContent
                ]);
            if ($contentUpdated) {
                $data = DB::table('wizard_include_services')->where(['account_type' => $request->availableAccountType])->get();
            } else {
                $data = false;
                return response()->json($data);
            }
            return response()->json($data);
        }
    }
    public function updateUserEmail(Request $request)
    {
        if (Auth::check()) {
            $user = DB::table('users')
                ->where('id', '!=', Auth::user()->id)
                ->where('email', '=', $request->email)
                ->exists();
            if ($user) {
                $res = 0;
                return response()->json($res);
            } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $res = 'inValid';
                return response()->json($res);
            } else {
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

        $data = array();
        $i = 1;
        foreach ($request->event as $key => $value) {
            $data[] = DB::table('partners_event')
                ->where('id', '=', $key)
                ->update([
                    'event_status' => $value

                ]);
            $i++;
        }


        if (in_array(1, $data)) {
            return redirect()->route('Options.index')
                ->with('eventSuccess', 'Events Updated');
        } elseif (in_array(0, $data)) {
            return redirect()->route('Options.index')
                ->with('eventSuccess', 'Events Updated');
        } else {
            return redirect()->route('Options.index')
                ->with('eventDanger', 'Error in Updating Events');
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
            $keys = $request->key;
            $value = $request->value;


            // if ($request->key == 'siteMembValue') {
            //     SiteHelper::setConstant('siteMembType', '2');
            //     return SiteHelper::setConstant($request->key, $request->value);
            // } elseif ($request->key == 'siteProgramValue') {
            //     SiteHelper::setConstant('siteProgramType', '2');
            //     return SiteHelper::setConstant($request->key, $request->value);
            // } else
            if (is_array($keys)) {
                $i = 0;
                $ret = array();
                foreach ($keys as $key) {
                    $ret[$i] = SiteHelper::setConstant($key, $value[$i]);
                    $i++;
                }

                if (in_array(1, $ret)) {
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
            // ->join('partners_merchant as M', 'C.currency_caption', '=', 'M.merchant_currency')
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


        if (SiteHelper::getConstant('siteCurrencyCode') == $request->relation_currency_code) {
            $res = 0;
            return response()->json($res);
        } elseif ($currentCurrency->relation_value == 1) {
            session(['curCode' => $request->relation_currency_code]);
            $data = DB::table('partners_currency', 'C')
                ->join('partners_currency_relation as R', function ($join) {
                    $join->on('C.currency_code', '=', 'R.relation_currency_code')
                        ->where('C.currency_code', '=',   session('curCode'));
                })
                ->select('C.*', 'R.*')
                ->orderby('relation_date', 'DESC')
                ->distinct()->first();


            if ($data) {
                //  $res = SiteHelper::ConvertToPreviousBaseCurrency(SiteHelper::getConstant('siteCurrencyCode'));
                $res = DB::table('partners_currency_relation')
                    ->where('relation_currency_code', $request->relation_currency_code)
                    ->limit(1)
                    ->update([
                        'relation_value' => $request->relation_value,
                    ]);
                // $res = SiteHelper::ConvertToNewBaseCurrency($request->relation_currency_code);
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
        $mail = array();

        $mail['subject'] = $request->bulkSubject;
        $mail['header'] = $request->bulkHeader;
        $mail['body'] = $request->bulkBody;
        $mail['footer'] = $request->bulkFooter;
        $mail['from'] = $request->bulkFrom;


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
                $res = 'inValid Email';
                return response()->json($res);
            } else if (Mail::to($request->mails)->send(new testMail($mail))) {
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
        $body = $request->mailSetupBody;

        $ret = array();
        if (!filter_var($request->mailSetupFrom, FILTER_VALIDATE_EMAIL)) {
            $res = 'inValid Email';
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
        if (in_array(1, $ret)) {
            $mail = array();
            $mail['subject'] = $request->mailSetupSubject;
            $mail['header'] = $request->mailSetupHeader;
            $mail['body'] = $request->mailSetupBody;
            $mail['footer'] = $request->mailSetupFooter;
            SiteHelper::testMail('fasehahmedwork@gmail.com', $request->mailSetupSubject, $request->mailSetupBody);
            $res = 1;
            return response()->json($res);
        } else {
            $res = 0;
            return response()->json($res);
        }
    }

    public function IPcountry()
    {
        $IPc = DB::table("partners_countryflag")->get();
        return response()->json(['data' => $IPc]);
    }
    public function DeleteIP(Request $request)
    {
        $id = $request->ip_from;
        $data = DB::table('partners_countryflag')->where('ip_from', '=', $id)->delete();
        if ($data != 0) {
            $res = 1;
            return response()->json($res);
        }
        return response()->json($data);
    }
    public function ShowIP(Request $request)
    {
        $id = $request->ip_from;
        $res = DB::table('partners_countryflag')
            ->where(['ip_from' => $id])
            ->first();

        return response()->json($res);
    }

    public function EditIPget($id)
    {
        $data = DB::table('partners_countryflag')->where(['ip_from' => $id])->first();
        return response()->json($data);
    }

    public function EditIP(Request $request)
    {
        $res = DB::table('partners_countryflag')
            ->where(['ip_from' => $request->id])
            ->update(array(
                'ip_from' => $request->ip_from,
                'ip_to' => $request->ip_to,
                'country_code2' => $request->country_code2,
                'country_code3' => $request->country_code3,
                'country_name' => $request->country_name,

            ));
        if ($res != 0) {
            $res = 1;
            return response()->json($res);
        }

        return response()->json($res);
    }


    public function insertAdminuser(Request $request)
    {
        $insertAdmin = DB::table('partners_adminusers')->insert([

            'adminusers_id' => $request->id,
            'adminusers_login' => $request->username,
            'adminusers_password' => $request->password,
            'adminusers_email' => $request->email,
            'adminusers_ip' => $request->ip(),
            'adminusers_lastLogin' => date('Y-m-d H:i:s'),

        ]);

        return response()->json($insertAdmin);
    }

    public function UserAdmintable()
    {
        $Useradmin = DB::table('partners_adminusers')->get();
        return response()->json(['data' => $Useradmin]);
    }

    public function DeleteAdmin(Request $request)
    {
        $id = $request->id;
        $data = DB::table('partners_adminusers')->where('adminusers_id', '=', $id)->delete();
        return response()->json($data);
    }

    public function ShowAdmin(Request $request)
    {
        $id = $request->id;
        $res = DB::table('partners_adminusers')
            ->where(['adminusers_id' => $id])
            ->first();

        return response()->json($res);
    }

    public function updateAdmin(Request $request)
    {
        $updateadmin = DB::table('partners_adminusers')
            ->where(['adminusers_id' => $request->id])

            ->update(array(

                'adminusers_login' => $request->adminusername,
                'adminusers_password' => $request->adminpassword,
                'adminusers_email' => $request->adminemail,

            ));

        return response()->json($updateadmin);
    }

    public function privileges($id)
    {
        $privils = DB::table("partners_adminlinks")->get();
        $admin = DB::table('partners_adminusers')
            ->where(['adminusers_id' => $id])->first();


        return view('options.Privileges', compact('privils', 'admin'));
    }
    public function checkboxPrivileges(Request $request)
    {

        if ($request->isCheck == 1) {
            $checkboxPrivileges = DB::table('partners_adminlinks')
                ->where('adminlinks_id', $request->id)
                ->update([
                    'adminlinks_userid' => $request->userid
                ]);
        } else {
            $checkboxPrivileges = DB::table('partners_adminlinks')
                ->where('adminlinks_id', $request->id)
                ->update([
                    'adminlinks_userid' => ' '
                ]);
        }
        return response()->json($checkboxPrivileges);
    }


    public function affiliategroupMang(Request $request)
    {

        $affiliategroup = DB::table("partners_affiliategroup")->insert([
            'affiliategroup_id' => $request->id,
            'affiliategroup_title' => $request->grouptitle,
            'affiliategroup_levels' => $request->categorylevel,
        ]);
        return response()->json($affiliategroup);
    }

    public function updateAffgroup(Request $request)
    {
        $updateAffgroup = DB::table('partners_affiliategroup')
            ->where(['affiliategroup_id' => $request->groupid])

            ->update(array(
                'affiliategroup_id' => $request->groupid,
                'affiliategroup_title' => $request->grouptitle,
                'affiliategroup_levels' => $request->categorylevel,
            ));

        return response()->json($updateAffgroup);
    }

    public function deleteAffgroup(Request $request)
    {
        $id = $request->id;
        $data = DB::table('partners_affiliategroup')->where('affiliategroup_id', '=', $id)->delete();
        return response()->json($data);
    }

    public function ShowAffgroup(Request $request)
    {
        $id = $request->id;
        $res = DB::table('partners_affiliategroup')
            ->where(['affiliategroup_id' => $id])
            ->first();

        return response()->json($res);
    }


    public function existGroup()
    {

        $getAffgroup = DB::table("partners_affiliategroup")->get();

        return response()->json(['data' => $getAffgroup]);
    }

    public function getGroupDetails(Request $request)
    {

        $detailsAffgroup = DB::table('partners_affiliategroup', 'a')
            ->join('partners_affiliategroup_commission as c', function ($join) {
                $join->on('a.affiliategroup_levels', '=', 'c.commission_level')
                    ->where('a.affiliategroup_levels', '=', '2');
            })
            ->select('a.*', 'c.*',)
            ->get();
        return response()->json($detailsAffgroup);
    }
    public function uploadSql(Request $request)
    {

        $file = $request->file('sqlfile');

        if ($file) {
            $fileNameExt = $request->file('sqlfile')->getClientOriginalName();
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            $fileExt =  $request->file('sqlfile')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
            $tmp     = explode(".", $fileNameToStore);
            if (strtolower($tmp[1]) != "sql") {
                $err = 3;
                return response()->json($err);
            } else {
                $file = $request->file('sqlfile');
                $fp = fopen($file, 'r');
                $contents  = fread($fp, filesize($file));
                //separate lines
                $lines = explode("\n", $contents);
                //read line by line
                for ($i = 0; $i < count($lines); $i++) {
                    //verify the data
                    if (substr($lines[$i], 0, 34) == "INSERT INTO `partners_countryflag`") {
                        $line = $contents;
                        $sqlfile = trim($line, "/r/n");
                        try {
                            $affreqs = DB::insert($sqlfile);
                            $msg = 1;
                            return response()->json($msg);
                        } catch (Exception $e) {
                            $err = 2;
                            return response()->json($err);
                        }
                    } else {
                        $msg = 404;
                        return response()->json($msg);
                    }
                }
            }
        } else {
            $msg = 404;
            return response()->json($msg);
        }
        fclose($fp);
    }
    public function setCommission(Request $request)
    {

        $groupdetails = DB::table('partners_affiliategroup as ag')->select('ag.*', 'ac.*')
            ->join(
                'partners_affiliategroup_commission as ac',
                'ag.affiliategroup_id',
                '=',
                'ac.commission_groupid'
            )->where('ag.affiliategroup_id', $request->groupid)
            ->first();
        return response()->json($groupdetails);
    }

    public function submitCommission(Request $request)
    {
        $groupid = $request->id;
        $error = '';
        $groupdetails = DB::table('partners_affiliategroup')->where('affiliategroup_id', $groupid)->first();

        $grouplevel = $groupdetails->affiliategroup_levels;

        $commission = array();

        $commissiontype = array();

        for ($i = 1; $i <= $grouplevel; $i++) {

            $commission[$i] = $request->commission[$i];
            $commissiontype[$i] = $request->radio[$i];

            if (empty($commission[$i])  || !is_numeric($commission[$i])) {
                $error .= 1;
            } else {

                if ($commissiontype[$i] == "percentage" && $commission[$i] > 100)
                    $error .= 2;
            }
        }
        if ($error != 0) {
            $msg = 201;
            return response()->json($msg);
        } else {
            $insert = '';
            for ($i = 1; $i <= count($commission); $i++) {

                $insert .= DB::table('partners_affiliategroup_commission')
                    ->updateOrInsert(
                        ['commission_groupid' => $groupid, 'commission_level' => $i],
                        [
                            'commission_amount' => $commission[$i],
                            'commission_type' => $commissiontype[$i],
                            'commission_groupid' => $groupid,
                            'commission_level' => $i,
                        ]
                    );
            }
            if ($insert) {
                $data = 200;
                return response()->json($data);
            }
        }
        // 
        //    return response()->json($commission);

    }
}
