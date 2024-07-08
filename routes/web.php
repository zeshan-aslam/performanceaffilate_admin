<?php

use Illuminate\Support\Facades\Route;
use App\Merchant;
use App\Affiliate;
use App\Utilities\SiteHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AwinController;
use App\Models\PartnerTextOld;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('getMatch', function () {
    DB::table('partners_transaction', 'PT')
        ->get();







    // return DB::table('partners_transaction', 'PT')
    // ->join(DB::raw('awin_transaction as AT'),function($join){
    //     $join->on('PT.transaction_id','=','AT.clickRef');
    //     ->whereBetween('AT.clickDate',['2022-04-01T00-00-00','2022-05-17T00-00-00']);
    // })
    // ->select('PT.*','AT.*')
    // ->selectRaw('monthname(AT.clickDate) as month ,year(AT.clickDate) as year')
    // ->whereRaw('year(AT.clickDate)=?',['2021'])
    // ->get();

});
Route::get('insertAwin', function () {

    return "Not yet";
});
Route::get('AwinCron', 'CronController@users')->name('users');



Route::get('AwinMatch', function () {

    return DB::table('awin_match')->get();

});
Route::get('TransTesting', function () {
    $countTrans = DB::table('partners_transaction')->count();
    $transCount = DB::table('transCount')
        ->orderBy('id', 'desc')
        ->first();
    if ($transCount->countTrans < $countTrans) {
        $lastTransID = DB::table('partners_transaction')->max('transaction_id');
        $transactions = DB::table('partners_transaction')->whereBetween('transaction_id', [$transCount->lastTransID, $lastTransID])
            ->get();
        DB::table('transCount')
            ->insert([
                'countTrans' => $countTrans,
                'lastTransID' => $lastTransID,
                'noOfTrans' => count($transactions) - 1,
            ]);

        $i = 0;
        $countMatch=0;
        foreach ($transactions as $row) {
            $i++;
            if ($i != 1) {
                echo "Transaction ID = " . $row->transaction_id . "<br/>";
                $awinData = DB::table('awin_transaction')
                    ->where('clickRef', '=', $row->transaction_id)
                    ->orderBy('id', 'desc')
                    ->first();
                if ($awinData) {

                    DB::table('awin_match')
                        ->insert([
                            'transactionId' => $row->transaction_id,
                            'awin_transactionId' => $awinData->transactionId,
                            'clickRef' => $awinData->clickRef,
                        ]);

                    DB::table('partners_transaction')
                        ->where('transaction_id', '=', $row->transaction_id)
                        ->update([
                            'transaction_amountpaid' => $awinData->commissionAmount,
                            'transaction_status' => 'approved',
                        ]);
                        $countMatch++;
                }
            }
        }
        echo "Total =" . (count($transactions) - 1);
        echo "Matched =" . $countMatch;
    } else {
        echo "No New Transaction Found";
    }
});
Route::get('Artisan', function () {
    if (Artisan::call("cache:clear") == 0) {
        Artisan::call("optimize:clear");
    //   shell_exec('composer dump-autoload');
    
        return "Commands Run Successfully";
    } else {

        return "Error Running Commands";
    }
});
Route::get('Backup', function () {
    if (Artisan::call("database:backup") == 0) {
        return 1;
    } else {
        return 0;
    }
});
Route::get('User/Activities', function () {
    
    return view('user.activity');
})->middleware(['auth','role:superadministrator']);
Route::get('aff1', function () {
    $aff = DB::table('partners_affiliate', 'A')
        ->join('partners_request as R', function ($join) {
            $join->on('A.affiliate_id', '=', 'R.request_affiliateid')
                ->where('R.request_status', '=',  'active');
        })

        ->join('partners_bankinfo as B', 'A.affiliate_id', '=', 'B.bankinfo_affiliateid')
        ->join('affiliate_pay as P', 'B.bankinfo_affiliateid', '=', 'P.pay_affiliateid')

        ->select('B.*')
        ->distinct()->get();

    return response()->json(['data' => $aff]);
});

Route::get('CodeTesting', function () {
    $time = strtotime("2010-12-11");
    return  date("Y-m-d", strtotime("+5 month", $time));
});
Auth::routes();
// Auth::routes(['verify' => true]);
Route::prefix('Auth')->name('password.')->group(function () {
    Route::get('ChangePasswordForm', 'Auth\ChangePasswordController@changePasswordForm')->name('changePasswordForm');
    Route::post('ChangePassword', 'Auth\ChangePasswordController@changePassword')->name('changePassword');
});
Route::prefix('Admin')->name('admin.')->group(function () {
    Route::get('Users', 'AdminController@users')->name('users');
    Route::get('GetUsers', 'AdminController@getUsers')->name('getUsers');
    Route::post('AddUser', 'AdminController@addUser')->name('addUser');
    Route::post('ShowUser', 'AdminController@showUser')->name('showUser');
    Route::post('UpdateUser', 'AdminController@updateUser')->name('updateUser');
    Route::post('DeleteUser', 'AdminController@deleteUser')->name('deleteUser');
});

Route::prefix('PoweredWords')->name('PoweredWords.')->group(function () {
    Route::get('', 'PoweredWordsController@words')->name('index');
    Route::get('GetKeywords', 'PoweredWordsController@getKeywords')->name('getKeywords');
    Route::post('AddKeyword', 'PoweredWordsController@addKeyword')->name('addKeyword');
    Route::post('ShowUser', 'AdminController@showUser')->name('showUser');
    Route::post('UpdateKeyword', 'PoweredWordsController@updateKeyword')->name('updateKeyword');
    Route::post('DeleteKeyword', 'PoweredWordsController@deleteKeyword')->name('deleteKeyword');
});

Route::resource('Networks', 'NetworkController', [
    'names' => [
        'index' => 'network.index'


    ]
]);

Route::prefix('AWIN')->name('awin.')->group(function () {
    Route::get('', 'AwinController@account')->name('index');
    Route::get('Accounts', 'AwinController@account')->name('account');
    Route::get('Publisher/{id}', 'AwinController@publisher')->name('publisher');
    Route::get('Programs/{id}', 'AwinController@program')->name('program');
    Route::get('CommissionGroups/{id}', 'AwinController@commissiongroup')->name('commissiongroup');
    Route::post('AwinBackup', 'AwinController@awinBackup')->name('awinBackup');
    Route::get('Transactions/{id}', 'AwinController@transaction')->name('transaction');
    Route::get('GetTransactions/{id}', 'AwinController@getTransactions')->name('getTransactions');
    Route::post('GetFilteredTransactions', 'AwinController@getFilteredTransactions')->name('getFilteredTransactions');


    Route::get('Notifications/{id}', 'AwinController@notifications')->name('notifications');
    Route::get('GetNotifications/{id}', 'AwinController@getNotifications')->name('getNotifications');
    Route::get('GetProducts/{id}', 'AwinController@getProducts')->name('getProducts');
    Route::get('GetCommissionGroups/{id}', 'AwinController@getCommissionGroups')->name('getCommissionGroups');


    Route::get('Reports/{id}', 'AwinController@report')->name('report');
});

Route::get('/', function () {
    if (!Auth::check()) {

        return view('auth.login');
    } else {
        return redirect()->route("admin.home");
    }
});




// Merchants Routes



Route::prefix('Merchant')->name('Merchant.')->group(function () {

    Route::get('merchantPendings', 'MerchantController@merchantPendings')->name('merchantPendings');

    Route::get('keywordCounter', 'MerchantController@keywordCounter')->name('keywordCounter');
    Route::get('getkeywords', 'MerchantController@getkeywords')->name('getkeywords');
    // Route::get('keywordCounter', 'MerchantController@keywordCounter')->name('keywordCounter');
    Route::get('getMerchants', 'MerchantController@getMerchants')->name('getMerchants');
    Route::get('pendingMerchants', 'MerchantController@pendingMerchants')->name('pendingMerchants');
    Route::get('ChangePasswordForm/{id}', 'MerchantController@changePasswordForm')->name('changepasswordForm');
    Route::post('ChangePassword', 'MerchantController@changePassword')->name('changepassword');

    Route::get('AdjustMoneyForm/{id}', 'MerchantController@adjustMoneyForm')->name('adjustMoneyForm');
    Route::post('AdjustMoney', 'MerchantController@adjustMoney')->name('adjustMoney');


    Route::get('PaymentHistoryForm/{id}', 'MerchantController@paymentHistoryForm')->name('paymentHistoryForm');
    Route::post('PaymentHistoryByDate/{id}', 'MerchantController@paymentHistoryByDate')->name('paymentHistoryByDate');
    Route::post('SuspendMerchant', 'MerchantController@suspendMerchant')->name('suspendMerchant');
    Route::post('ApproveMerchant', 'MerchantController@approveMerchant')->name('approveMerchant');
    
    // To Make Mechant's "is_setup" Status to Live in parteners_merchants By RANA
    Route::post('MakeLiveMerchant', 'MerchantController@makeLiveMerchant')->name('makeLiveMerchant');
    Route::post('MakeLiveMerchantWithoutSetup', 'MerchantController@makeLiveMerchantWithoutSetup')->name('makeLiveMerchant');



    Route::get('RemoveMerchantForm/{id}', 'MerchantController@removeMerchantForm')->name('removeMerchantForm');
    Route::post('RemoveMerchant', 'MerchantController@removeMerchant')->name('removeMerchant');
    Route::post('PGMApprovelMerchant', 'MerchantController@pgmApprovelMerchant')->name('pgmApprovelMerchant');
    Route::post('ActivateInvoiceStatusMerchant', 'MerchantController@activateInvoiceStatusMerchant')->name('activateInvoiceStatusMerchant');
    Route::post('DeActivateInvoiceStatusMerchant', 'MerchantController@DeActivateInvoiceStatusMerchant')->name('DeActivateInvoiceStatusMerchant');
    Route::get('TransactionForm/{id}', 'MerchantController@transactionForm')->name('transactionForm');
    Route::get('Login/{id}', 'MerchantController@loginMerchant')->name('login');
});


Route::resource('Merchant', 'MerchantController');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Program Module  Routes
Route::prefix('Program')->name('Program.')->group(function () {

    Route::get('', 'ProgramController@index')->name('index');

    Route::get('Text/{id}/{status}', 'ProgramController@text')->name('text');
    Route::get('TemplateText/{id}/{status}', 'ProgramController@tamplateText')->name('templateText');
    Route::get('HTML/{id}/{status}', 'ProgramController@html')->name('html');
    Route::get('Popup/{id}/{status}', 'ProgramController@popup')->name('popup');
    Route::get('Flash/{id}/{status}', 'ProgramController@flash')->name('flash');
    Route::get('Banner/{id}/{status}', 'ProgramController@banner')->name('banner');
    Route::get('Product/{id}/{status}', 'ProgramController@product')->name('product');

    Route::get('GetTextLinks/{id}/{status}', 'ProgramController@getTextLinks')->name('getTextLinks');
    Route::get('GetTempTextLinks/{id}/{status}', 'ProgramController@getTempTextLinks')->name('getTempTextLinks');
    Route::get('GetHTMLLinks/{id}/{status}', 'ProgramController@getHTMLLinks')->name('getHTMLLinks');
    Route::get('GetPopupLinks/{id}/{status}', 'ProgramController@getPopupLinks')->name('getPopupLinks');
    Route::get('GetFlashLinks/{id}/{status}', 'ProgramController@getFlashLinks')->name('getFlashLinks');
    Route::get('GetBannerLinks/{id}/{status}', 'ProgramController@getBannerLinks')->name('getBannerLinks');
    Route::get('GetProductLinks/{id}/{status}', 'ProgramController@getProductLinks')->name('getBannerLinks');

    Route::post('ApproveLink', 'ProgramController@approveLink')->name('approveLink');
    Route::post('RejectLink', 'ProgramController@rejectLink')->name('rejectLink');

    Route::get('ProgramDetails/{id}', 'ProgramController@getProgramDetails')->name('getProgramDetails');
    Route::get('changeProgramStatus/{id}', 'ProgramController@changeProgramStatus')->name('changeProgramStatus');
    Route::post('UpdateFee/{id}', 'ProgramController@updateFee')->name('updateFee');
    Route::post('UpdateAdminPayments/{id}', 'ProgramController@updateAdminPayments')->name('updateAdminPayments');
    Route::post('UpdateComission/{id}', 'ProgramController@updateComission')->name('updateComission');
    Route::post('GetAffiliates', 'ProgramController@getAffiliates')->name('getAffiliates');
});

//Program Module  Routes
Route::prefix('Report')->name('Report.')->group(function () {

    Route::get('', 'ReportController@index')->name('index');
    Route::get('Sale/{id}', 'ReportController@subsale')->name('subsale');

    Route::post('GetTransactionData', 'ReportController@getTransactionData')->name('getTransactionData');
    Route::post('GetDailyData', 'ReportController@getDailyData')->name('getDailyData');
    Route::post('GetLinkData', 'ReportController@getLinkData')->name('getLinkData');
    Route::post('GetRecurringData', 'ReportController@getRecurringData')->name('getRecurringData');
    Route::post('GetForPeriodData', 'ReportController@getForPeriodData')->name('getForPeriodData');
    Route::post('GetRefererData', 'ReportController@getRefererData')->name('getRefererData');
    Route::post('GetAffiliateReferralData', 'ReportController@getAffiliateReferralData')->name('getAffiliateReferralData');
    Route::post('GetReferralCommissionData', 'ReportController@getReferralCommissionData')->name('getReferralCommissionData');
    Route::post('GetSubReferralCommission', 'ReportController@getSubReferralCommission')->name('getSubReferralCommission');

    Route::post('GetGraphsData', 'ReportController@getGraphsData')->name('getGraphsData');
    Route::post('GetProductsData', 'ReportController@getProductsData')->name('getProductsData');


    Route::get('GetTransaction', 'ReportController@getTransactionData')->name('getTransaction');
    Route::get('GetDaily', 'ReportController@getDailyData')->name('getDaily');
    Route::get('GetLink', 'ReportController@getLinkData')->name('getLink');
    Route::get('GetRecurring', 'ReportController@getRecurringData')->name('getRecurring');
    Route::get('GetForPeriod', 'ReportController@getForPeriodData')->name('getForPeriod');
    Route::get('GetReferer', 'ReportController@getRefererData')->name('getReferer');
    Route::get('GetAffiliateReferral', 'ReportController@getAffiliateReferralData')->name('getAffiliateReferral');
    Route::get('GetReferralCommission', 'ReportController@getReferralCommissionData')->name('getReferralCommission');
    Route::get('GetGraphs', 'ReportController@getGraphsData')->name('getGraphs');
    Route::get('GetProducts', 'ReportController@getProductsData')->name('getProducts');
    Route::get('BannerDisplay', 'ReportController@BannerDisplay')->name('BannerDisplay');
});

//--------------------------------Affiliate---------------------------------------->
Route::prefix('Affiliate')->name('Affiliate.')->group(function () {

    #Affiliate data with ajax request
    Route::get('affiliatePendings', 'AffiliateController@affiliatePendings')->name('affiliatePendings');

    #new
    Route::get('getAffiliates', 'AffiliateController@getAffiliates')->name('getAffiliates');

    Route::post('approveIt', 'AffiliateController@approveIt')->name('approveIt');
    Route::post('suspend', 'AffiliateController@suspend')->name('suspend');

    Route::get('adjustMoneyForm/{id}', 'AffiliateController@adjustMoneyForm')->name('adjustMoneyForm');
    Route::post('adjustMoney', 'AffiliateController@adjustMoney')->name('adjustMoney');

    Route::get('changePasswordForm/{id}', 'AffiliateController@changePasswordForm')->name('changePasswordForm');
    Route::post('changePassword', 'AffiliateController@changePassword')->name('changePassword');

    Route::get('removeAffiliateForm/{id}', 'AffiliateController@removeAffiliateForm')->name('removeAffiliateForm');
    Route::post('removeAffiliate', 'AffiliateController@removeAffiliate')->name('removeAffiliate');
    Route::get('{id}', 'AffiliateController@show')->name('show');
    Route::post('setcommission/{id}', 'AffiliateController@setcommission')->name('setcommission');
    Route::get('Reject/{id}', 'AffiliateController@Reject')->name('Reject');
    #old
    Route::get('', 'AffiliateController@index')->name('index');
    route::get('destroy/{id}', 'AffiliateController@destroy')->name('destroy');
    Route::get('TransactionForm/{id}', 'AffiliateController@transactionForm')->name('TransactionForm');
    Route::get('PaymentHistoryForm/{id}', 'AffiliateController@paymentHistoryForm')->name('paymentHistoryForm');
    Route::post('PaymentHistoryByDate/{id}', 'AffiliateController@paymentHistoryByDate')->name('paymentHistoryByDate');
    Route::get('Login/{id}', 'AffiliateController@loginAffiliate')->name('login');
});

Route::prefix('Crons')->name('cron.')->group(function () {
    Route::get('AwinMatchTransactions', 'CronController@AwinBackup')->name('awin');
    Route::get('CjMatchTransactions', 'CronController@CjBackup')->name('cj');

});

//-------------------------------------Payments-----------------------------------//
Route::prefix('Payments')->name('payment.')->group(function () {
    #New
    #Affiliate Request
    Route::get('affreqs', 'PaymentsController@affreqs')->name('affreqs');
    Route::post('affReqDecline', 'PaymentsController@affReqDecline')->name('affReqDecline');
    Route::post('affReqDelete', 'PaymentsController@affReqDelete')->name('affReqDelete');
    Route::post('manualpay', 'PaymentsController@manualpay')->name('manualpay');
    Route::post('showAff', 'PaymentsController@showAff')->name('showAff');

    #Merchant Request
    Route::get('MerRequest', 'PaymentsController@MerRequest')->name('MerRequest');
    Route::post('MerReqDelete', 'PaymentsController@MerReqDelete')->name('MerReqDelete');
    Route::post('showMer', 'PaymentsController@showMer')->name('showMer');
    Route::post('rejectMer', 'PaymentsController@rejectMer')->name('rejectMer');
    Route::post('MerchantPay', 'PaymentsController@MerchantPay')->name('MerchantPay');
    #Reverse Sale
    Route::get('ReverseSale', 'PaymentsController@reverseSale1')->name('ReverseSale');
    Route::post('payReverse', 'PaymentsController@payReverse')->name('payReverse');

    #Reverse Recure Sale
    Route::get('ReverseRecureSale', 'PaymentsController@RecuringReverseSale')->name('ReverseRecureSale');
    Route::post('payReverseRecure', 'PaymentsController@payRecuringReverse')->name('payReverseRecure');

    #Invoice
    Route::post('getInvoiceData', 'PaymentsController@invoicefetch')->name('getInvoiceData');
    Route::post('detailstrans', 'PaymentsController@detailstrans')->name('detailstrans');
    Route::get('getInvoice', 'PaymentsController@invoicefetch')->name('getInvoice');

    Route::post('Invoicepaystatus', 'PaymentsController@Invoicepaystatus')->name('Invoicepaystatus');

    #old
    #Payments Routes
    Route::get('', 'PaymentsController@paymentHistoryForm')->name('paymentHistoryForm');
    Route::post('PaymentHistoryByDate1', 'PaymentsController@paymentHistoryByDate1')->name('paymentHistoryByDate1');
    #Affiliate
    Route::get('AffiliateReq', 'PaymentsController@AffiliateReq')->name('AffiliateReq');
    Route::post('DeleteReq/{id}', 'PaymentsController@Delete')->name('DeleteReq');
    Route::post('MerDelete/{id}', 'PaymentsController@MerDelete')->name('MerDelete');

    #Merchant
    Route::post('MerchantReq/{addmoney_id}', 'PaymentsController@MerchantReq')->name('MerchantReq');
    Route::post('MerchantPay/{id}', 'PaymentsController@MerchantPay')->name('MerchantPay');
    Route::get('MerchantPayget/{id}', 'PaymentsController@MerchantPay')->name('MerchantPayget');
    Route::post('test', 'PaymentsController@paynow')->name('test');
    #Reverse
    Route::post('ReverseSale', 'PaymentsController@ReverseSale')->name('ReverseSale');
    Route::get('paySale/{aid}/{mid}/{tid}/{amount}/{tupdateamnt}', 'PaymentsController@ReverseSale')->name('paySale');
    #Recuring
    Route::get('RecuringReverseSale', 'PaymentsController@RecuringReverseSale')->name('RecuringReverseSale');
});

//-----------------------------Options Routes-----------------------//

Route::prefix('Options')->name('Options.')->group(function () {
    Route::get('', 'OptionsController@index')->name('index');
    Route::get('FillFields', 'OptionsController@fillFields')->name('fillFields');
    Route::post('UpdateUserEmail', 'OptionsController@updateUserEmail')->name('updateUserEmail');
    Route::post('UpdateUserName', 'OptionsController@updateUserName')->name('updateUserName');
    Route::post('UpdateUserPassword', 'OptionsController@updateUserPassword')->name('updateUserPassword');
    Route::post('UpdateSiteInfo', 'OptionsController@updateSiteInfo')->name('updateSiteInfo');
    Route::post('UpdateSiteError', 'OptionsController@updateSiteError')->name('updateSiteError');
    //-----------------------------Gate Ways Routes-----------------------//
    Route::get('GetPaymentGateways', 'OptionsController@getPaymentGateways')->name('getPaymentGateways');
    Route::post('UpdateGateway', 'OptionsController@updateGateway')->name('updateGateway');
    //-----------------------------Set Payments Routes-----------------------//
    Route::post('UpdatePayments', 'OptionsController@updatePayments')->name('updatePayments');
    //-----------------------------Catagory Routes-----------------------//
    Route::get('Getcatagories', 'OptionsController@getcatagories')->name('getcatagories');
    Route::post('InsertCatagory', 'OptionsController@insertCatagory')->name('insertCatagory');
    Route::post('DeleteCatagory', 'OptionsController@deleteCatagory')->name('deleteCatagory');
    //-----------------------------Merchant Events Routes-----------------------//
    Route::get('GetMerchantEvents', 'OptionsController@getMerchantEvents')->name('getMerchantEvents');
    Route::post('UpdateMerchantEvents', 'OptionsController@updateMerchantEvents')->name('updateMerchantEvents');

    //-----------------------------AdminMailOptionsRoutes-----------------------//
    Route::get('GetAdminMailOptions', 'OptionsController@getAdminMailOptions')->name('getAdminMailOptions');
    Route::post('UpdateAdminMailOptions', 'OptionsController@updateAdminMailOptions')->name('updateAdminMailOptions');
    //-----------------------------set Payments-----------------------//
    Route::post('UpdateAdminAmount', 'OptionsController@updateAdminAmount')->name('updateAdminAmount');
    //-----------------------------Languages-----------------------//

    Route::get('GetSiteLanguages', 'OptionsController@getSiteLanguages')->name('getSiteLanguages');
    Route::post('AddLanguage', 'OptionsController@addLanguage')->name('addLanguage');
    Route::post('EditLanguage', 'OptionsController@showLanguage')->name('editLanguage');
    Route::post('UpdateLanguage', 'OptionsController@updateLanguage')->name('updateLanguage');
    Route::post('DeleteLanguage', 'OptionsController@deleteLanguage')->name('deleteLanguage');
    //-----------------------------Currency-----------------------//

    Route::get('GetCurrencies', 'OptionsController@getCurrencies')->name('getCurrencies');
    Route::post('AddCurrency', 'OptionsController@addCurrency')->name('addCurrency');
    Route::post('EditCurrency', 'OptionsController@showCurrency')->name('editCurrency');
    Route::post('UpdateCurrency', 'OptionsController@updateCurrencyValue')->name('updateCurrencyValue');
    Route::post('DeleteCurrency', 'OptionsController@deleteCurrency')->name('deleteCurrency');
    Route::post('ChangeCurrency', 'OptionsController@changeCurrency')->name('changeCurrency');
    //-----------------------------Fraud Settings-----------------------//
    Route::post('UpdateFraudSetting', 'OptionsController@updateFraudSetting')->name('updateFraudSetting');
    //-----------------------------Affiliate Terms-----------------------//
    Route::post('UpdateAffiliateTerms', 'OptionsController@updateAffiliateTerms')->name('updateAffiliateTerms');

    //-----------------------------Merchant Terms-----------------------//
    Route::post('UpdateMerchantTerms', 'OptionsController@updateMerchantTerms')->name('updateMerchantTerms');
    //-----------------------------Bulk Mail-----------------------//
    Route::post('GetMailList', 'OptionsController@getMailList')->name('getMailList');
    Route::post('SendBulkMail', 'OptionsController@sendBulkMail')->name('sendBulkMail');
    //-----------------------------Mail Setup-----------------------//
    Route::get('FillEventsMailSetup', 'OptionsController@fillEventsMailSetup')->name('fillEventsMailSetup');
    Route::post('UpdateMailSetup', 'OptionsController@updateMailSetup')->name('updateMailSetup');
    Route::post('GetMailSetup', 'OptionsController@getMailSetup')->name('getMailSetup');
    //-------------------------------Wizard Content Setting----------------//
    Route::post('ADDWizardAccountType', 'OptionsController@ADDWizardAccountType')->name('ADDWizardAccountType');
    Route::post('GETWizardAccountType', 'OptionsController@GETWizardAccountType')->name('GETWizardAccountType');
    Route::post('UpdateWizardServiceContent', 'OptionsController@UpdateWizardServiceContent')->name('UpdateWizardServiceContent');


    //------------------------------IPCountry------------------------------//
    Route::get('IPcountry', 'OptionsController@IPcountry')->name('IPcountry');
    Route::get('EditIPget/{id}', 'OptionsController@EditIPget')->name('EditIPget');
    Route::post('EditIP', 'OptionsController@EditIP')->name('EditIP');
    Route::post('DeleteIP', 'OptionsController@DeleteIP')->name('DeleteIP');
    Route::get('ShowIP', 'OptionsController@ShowIP')->name('ShowIP');
    //-------------------------------Admin-User---------------------------//
    Route::post('insertAdminuser', 'OptionsController@insertAdminuser')->name('insertAdminuser');
    Route::get('UserAdmintable', 'OptionsController@UserAdmintable')->name('UserAdmintable');
    Route::post('DeleteAdmin', 'OptionsController@DeleteAdmin')->name('DeleteAdmin');
    Route::post('ShowAdmin', 'OptionsController@ShowAdmin')->name('ShowAdmin');
    Route::post('updateAdmin', 'OptionsController@updateAdmin')->name('updateAdmin');
    Route::get('privileges/{id}', 'OptionsController@privileges')->name('privileges');
    Route::get('checkboxPrivileges', 'OptionsController@checkboxPrivileges')->name('checkboxPrivileges');
    Route::post('affiliategroup', 'OptionsController@affiliategroupMang')->name('affiliategroup');
    Route::get('getAffgroup', 'OptionsController@existGroup')->name('getAffgroup');
    Route::post('updateAffgroup', 'OptionsController@updateAffgroup')->name('updateAffgroup');
    Route::post('deleteAffgroup', 'OptionsController@deleteAffgroup')->name('deleteAffgroup');
    Route::post('ShowAffgroup', 'OptionsController@ShowAffgroup')->name('ShowAffgroup');
    Route::get('getGroupDetails', 'OptionsController@getGroupDetails')->name('getGroupDetails');
    Route::post('uploadSql', 'OptionsController@uploadSql')->name('uploadSql');
    Route::get('setCommission', 'OptionsController@setCommission')->name('setCommission');
    Route::post('submitCommission', 'OptionsController@submitCommission')->name('submitCommission');
});

#PGM Status
Route::prefix('PGMStatus')->name('PGMStatus.')->group(function () {
    Route::get('', 'pgmStatusController@index')->name('index');
    Route::get('getpgm', 'pgmStatusController@getpgm')->name('getpgm');
    Route::get('GetLinks', 'pgmStatusController@GetLinks')->name('GetLinks');

    Route::get('approvePgm', 'pgmStatusController@approvePgm')->name('approvePgm');
    Route::get('rejectPgm', 'pgmStatusController@rejectPgm')->name('rejectPgm');
    Route::get('approveMerchants', 'pgmStatusController@approveMerchants')->name('approveMerchants');
    Route::get('approveAffiliates', 'pgmStatusController@approveAffiliates')->name('approveAffiliates');
    Route::get('rejectMerchants', 'pgmStatusController@rejectMerchants')->name('rejectMerchants');
    Route::get('rejectAffiliates', 'pgmStatusController@rejectAffiliates')->name('rejectAffiliates');

    Route::get('waitMerchants', 'pgmStatusController@waitMerchants')->name('waitMerchants');
    Route::get('waitAffiliate', 'pgmStatusController@waitAffiliate')->name('waitAffiliate');
});

//-----------------------------Paypal Routes-----------------------//

Route::get('paywithpaypal', 'PaypalController@payWithPaypal');
Route::post('paypal/{id}', 'PaypalController@postPaymentWithpaypal');
Route::get('paypal', array('as' => 'status', 'uses' => 'PaypalController@getPaymentStatus',));

//--------------------------------------------------------------//

//---------------------Stripe-Payments-Gateway Routes-----------//
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

//-------------------------------------------------------------//



Route::prefix('SearlcoDynamicData')->name('searlco.')->group(function () {

    Route::get('/', 'SearlcoHomeController@index')->name('index');
    Route::get('title', 'SearlcoHomeController@Title')->name('title');
    Route::get('Slides', 'SearlcoHomeController@slides')->name('slides');
    Route::get('Services', 'SearlcoHomeController@services')->name('services');
    Route::get('SearlcoNetwork', 'SearlcoHomeController@searlcoNetwork')->name('searlcoNetwork');
    Route::get('Features', 'SearlcoHomeController@features')->name('features');
    Route::get('Standard', 'SearlcoHomeController@standard')->name('standard');
    Route::get('TrustedBrands', 'SearlcoHomeController@trustedBrands')->name('trustedBrands');
    Route::get('Header', 'SearlcoHomeController@header')->name('header');
    // ............................................................................................
    Route::get('ServicesCard', 'SearlcoHomeController@ServicesCard')->name('ServicesCard');
    Route::get('SearlcoNetworkCard', 'SearlcoHomeController@SearlcoNetworkCard')->name('SearlcoNetworkCard');
    Route::get('FeaturesCard', 'SearlcoHomeController@FeaturesCard')->name('FeaturesCard');
    Route::get('StandardCard', 'SearlcoHomeController@StandardCard')->name('StandardCard');
    Route::get('TrustedBrandsCard', 'SearlcoHomeController@TrustedBrandsCard')->name('TrustedBrandsCard');
    Route::get('Navbar', 'SearlcoHomeController@Navbar')->name('Navbar');
    Route::get('Footer', 'SearlcoHomeController@footer')->name('footer');
    Route::get('Contact', 'SearlcoHomeController@contact')->name('contact');
    //.............................................................................................
    Route::post('titleStore', 'SearlcoHomeController@titleStore')->name('titleStore');
    Route::post('NavbarStore', 'SearlcoHomeController@NavbarStore')->name('NavbarStore');
    Route::post('MenuStore', 'SearlcoHomeController@MenuStore')->name('MenuStore');
    Route::post('sliderStore', 'SearlcoHomeController@sliderStore')->name('sliderStore');
    Route::post('servicesStore', 'SearlcoHomeController@servicesStore')->name('servicesStore');
    Route::post('servicesCardStore', 'SearlcoHomeController@servicesCardStore')->name('servicesCardStore');
    Route::post('searlcoNetworkStore', 'SearlcoHomeController@searlcoNetworkStore')->name('searlcoNetworkStore');
    Route::post('searlcoNetworkCardStore', 'SearlcoHomeController@searlcoNetworkCardStore')->name('searlcoNetworkCardStore');
    Route::post('featuresStore', 'SearlcoHomeController@featuresStore')->name('featuresStore');
    Route::post('featuresCardStore', 'SearlcoHomeController@featuresCardStore')->name('featuresCardStore');
    Route::post('trustedBrandsStore', 'SearlcoHomeController@trustedBrandsStore')->name('trustedBrandsStore');
    Route::post('trustedStore', 'SearlcoHomeController@trustedStore')->name('trustedStore');
    Route::post('standardStore', 'SearlcoHomeController@standardStore')->name('standardStore');
    Route::post('standardCardStore', 'SearlcoHomeController@standardCardStore')->name('standardCardStore');
    Route::post('contactStore', 'SearlcoHomeController@contactStore')->name('contactStore');

    Route::get('titleView', 'SearlcoHomeController@titleView')->name('titleView');
    Route::get('sliderView', 'SearlcoHomeController@sliderView')->name('sliderView');
    Route::get('servicesView', 'SearlcoHomeController@servicesView')->name('servicesView');
    Route::get('searlcoNetworkView', 'SearlcoHomeController@searlcoNetworkView')->name('searlcoNetworkView');
    Route::get('featuresView', 'SearlcoHomeController@featuresView')->name('featuresView');
    Route::get('standardView', 'SearlcoHomeController@standardView')->name('standardView');
    Route::get('trustedBrandsView', 'SearlcoHomeController@trustedBrandsView')->name('trustedBrandsView');
    Route::get('headerView', 'SearlcoHomeController@headerView')->name('headerView');
    Route::get('contactView', 'SearlcoHomeController@contactView')->name('contactView');

    Route::get('getTitleData', 'SearlcoHomeController@getTitleData')->name('getTitleData');
    Route::get('deleteTitleData', 'SearlcoHomeController@deleteTitleData')->name('deleteTitleData');
    Route::post('RemoveTitleData', 'SearlcoHomeController@RemoveTitleData')->name('RemoveTitleData');
    Route::get('EditTitleData', 'SearlcoHomeController@EditTitleData')->name('EditTitleData');
    Route::post('editsTitleData', 'SearlcoHomeController@editsTitleData')->name('editsTitleData');

    Route::get('getSliderData', 'SearlcoHomeController@getSliderData')->name('getSliderData');
    Route::get('deleteSliderData', 'SearlcoHomeController@deleteSliderData')->name('deleteSliderData');
    Route::post('RemoveSliderData', 'SearlcoHomeController@RemoveSliderData')->name('RemoveSliderData');
    Route::get('EditSliderData', 'SearlcoHomeController@EditSliderData')->name('EditSliderData');
    Route::get('editsSliderData', 'SearlcoHomeController@editsSliderData')->name('editsSliderData');
    Route::get('getheaderData', 'SearlcoHomeController@getheaderData')->name('getheaderData');
    Route::get('deleteheaderData', 'SearlcoHomeController@deleteheaderData')->name('deleteheaderData');
    Route::post('RemoveheaderData', 'SearlcoHomeController@RemoveheaderData')->name('RemoveheaderData');
    Route::get('EditheaderData', 'SearlcoHomeController@EditheaderData')->name('EditheaderData');
    Route::post('editsheaderData', 'SearlcoHomeController@editsheaderData')->name('editsheaderData');
    Route::get('getServicesData', 'SearlcoHomeController@getServicesData')->name('getServicesData');
    Route::get('deleteServicesData', 'SearlcoHomeController@deleteServicesData')->name('deleteServicesData');
    Route::post('RemoveServicesData', 'SearlcoHomeController@RemoveServicesData')->name('RemoveServicesData');
    Route::get('EditServicesData', 'SearlcoHomeController@EditServicesData')->name('EditServicesData');
    Route::get('editsServicesData', 'SearlcoHomeController@editsServicesData')->name('editsServicesData');
    Route::get('getCardData', 'SearlcoHomeController@getCardData')->name('getCardData');
    Route::get('deleteCardData', 'SearlcoHomeController@deleteCardData')->name('deleteCardData');
    Route::post('RemoveCardData', 'SearlcoHomeController@RemoveCardData')->name('RemoveCardData');
    Route::get('EditCardData', 'SearlcoHomeController@EditCardData')->name('EditCardData');
    Route::post('editsCardData', 'SearlcoHomeController@editsCardData')->name('editsCardData');
    // .............................................
    Route::get('getSearlcoNetworkData', 'SearlcoHomeController@getSearlcoNetworkData')->name('getSearlcoNetworkData');
    Route::get('deleteSearlcoNetworkData', 'SearlcoHomeController@deleteSearlcoNetworkData')->name('deleteSearlcoNetworkData');
    Route::post('RemoveSearlcoNetworkData', 'SearlcoHomeController@RemoveSearlcoNetworkData')->name('RemoveSearlcoNetworkData');
    Route::get('EditSearlcoNetworkData', 'SearlcoHomeController@EditSearlcoNetworkData')->name('EditSearlcoNetworkData');
    Route::get('editsSearlcoNetworkData', 'SearlcoHomeController@editsSearlcoNetworkData')->name('editsSearlcoNetworkData');
    Route::get('getSearlcoNetworkCardData', 'SearlcoHomeController@getSearlcoNetworkCardData')->name('getSearlcoNetworkCardData');
    Route::get('deleteSearlcoNetworkCardData', 'SearlcoHomeController@deleteSearlcoNetworkCardData')->name('deleteSearlcoNetworkCardData');
    Route::post('RemoveSearlcoNetworkCardData', 'SearlcoHomeController@RemoveSearlcoNetworkCardData')->name('RemoveSearlcoNetworkCardData');
    Route::get('EditSearlcoNetworkCardData', 'SearlcoHomeController@EditSearlcoNetworkCardData')->name('EditSearlcoNetworkCardData');
    Route::post('editsSearlcoNetworkCardData', 'SearlcoHomeController@editsSearlcoNetworkCardData')->name('editsSearlcoNetworkCardData');
    // .............................................
    // .............................................
    Route::get('getFeaturesData', 'SearlcoHomeController@getFeaturesData')->name('getFeaturesData');
    Route::get('deleteFeaturesData', 'SearlcoHomeController@deleteFeaturesData')->name('deleteFeaturesData');
    Route::post('RemoveFeaturesData', 'SearlcoHomeController@RemoveFeaturesData')->name('RemoveFeaturesData');
    Route::get('EditFeaturesData', 'SearlcoHomeController@EditFeaturesData')->name('EditFeaturesData');
    Route::get('editsFeaturesData', 'SearlcoHomeController@editsFeaturesData')->name('editsFeaturesData');
    Route::get('getFeaturesCardData', 'SearlcoHomeController@getFeaturesCardData')->name('getFeaturesCardData');
    Route::get('deleteFeaturesCardData', 'SearlcoHomeController@deleteFeaturesCardData')->name('deleteFeaturesCardData');
    Route::post('RemoveFeaturesCardData', 'SearlcoHomeController@RemoveFeaturesCardData')->name('RemoveFeaturesCardData');
    Route::get('EditFeaturesCardData', 'SearlcoHomeController@EditFeaturesCardData')->name('EditFeaturesCardData');
    Route::get('editsFeaturesCardData', 'SearlcoHomeController@editsFeaturesCardData')->name('editsFeaturesCardData');
    // .............................................
    // .............................................
    Route::get('getStandardData', 'SearlcoHomeController@getStandardData')->name('getStandardData');
    Route::get('deleteStandardData', 'SearlcoHomeController@deleteStandardData')->name('deleteStandardData');
    Route::post('RemoveStandardData', 'SearlcoHomeController@RemoveStandardData')->name('RemoveStandardData');
    Route::get('EditStandardData', 'SearlcoHomeController@EditStandardData')->name('EditStandardData');
    Route::get('editsStandardData', 'SearlcoHomeController@editsStandardData')->name('editsStandardData');
    Route::get('getStandardCardData', 'SearlcoHomeController@getStandardCardData')->name('getStandardCardData');
    Route::get('deleteStandardCardData', 'SearlcoHomeController@deleteStandardCardData')->name('deleteStandardCardData');
    Route::post('RemoveStandardCardData', 'SearlcoHomeController@RemoveStandardCardData')->name('RemoveStandardCardData');
    Route::get('EditStandardCardData', 'SearlcoHomeController@EditStandardCardData')->name('EditStandardCardData');
    Route::get('editsStandardCardData', 'SearlcoHomeController@editsStandardCardData')->name('editsStandardCardData');
    // .............................................
    // .............................................
    Route::get('getTrustedData', 'SearlcoHomeController@getTrustedData')->name('getTrustedData');
    Route::get('deleteTrustedData', 'SearlcoHomeController@deleteTrustedData')->name('deleteTrustedData');
    Route::post('RemoveTrustedData', 'SearlcoHomeController@RemoveTrustedData')->name('RemoveTrustedData');
    Route::get('EditTrustedData', 'SearlcoHomeController@EditTrustedData')->name('EditTrustedData');
    Route::post('editsTrustedData', 'SearlcoHomeController@editsTrustedData')->name('editsTrustedData');
    Route::get('getTrustedCardData', 'SearlcoHomeController@getTrustedCardData')->name('getTrustedCardData');
    Route::get('deleteTrustedCardData', 'SearlcoHomeController@deleteTrustedCardData')->name('deleteTrustedCardData');
    Route::post('RemoveTrustedCardData', 'SearlcoHomeController@RemoveTrustedCardData')->name('RemoveTrustedCardData');
    Route::get('EditTrustedCardData', 'SearlcoHomeController@EditTrustedCardData')->name('EditTrustedCardData');
    Route::post('editsTrustedCardData', 'SearlcoHomeController@editsTrustedCardData')->name('editsTrustedCardData');
    // .............................................
    Route::get('getContactData', 'SearlcoHomeController@getContactData')->name('getContactData');
    Route::get('deleteContactData', 'SearlcoHomeController@deleteContactData')->name('deleteContactData');
    Route::post('RemoveContactData', 'SearlcoHomeController@RemoveContactData')->name('RemoveContactData');
    Route::get('EditContactData', 'SearlcoHomeController@EditContactData')->name('EditContactData');
    Route::post('editsContactData', 'SearlcoHomeController@editsContactData')->name('editsContactData');
    Route::get('getMenuData', 'SearlcoHomeController@getMenuData')->name('getMenuData');
    Route::get('deleteMenuData', 'SearlcoHomeController@deleteMenuData')->name('deleteMenuData');
    Route::post('RemoveMenuData', 'SearlcoHomeController@RemoveMenuData')->name('RemoveMenuData');
    Route::get('EditMenuData', 'SearlcoHomeController@EditMenuData')->name('EditMenuData');
    Route::get('editsMenuData', 'SearlcoHomeController@editsMenuData')->name('editsMenuData');
    //..........................Change Status .................................................................
    Route::get('changeTitleStatus', 'SearlcoHomeController@changeTitleStatus')->name('changeTitleStatus');
    Route::post('updateTitleStatus', 'SearlcoHomeController@updateTitleStatus')->name('updateTitleStatus');

    Route::get('changeHeaderStatus', 'SearlcoHomeController@changeHeaderStatus')->name('changeHeaderStatus');
    Route::post('updateHeaderStatus', 'SearlcoHomeController@updateHeaderStatus')->name('updateHeaderStatus');

    Route::get('changeTrustedStatus', 'SearlcoHomeController@changeTrustedStatus')->name('changeTrustedStatus');
    Route::post('updateTrustedStatus', 'SearlcoHomeController@updateTrustedStatus')->name('updateTrustedStatus');

    Route::get('changeServicesStatus', 'SearlcoHomeController@changeServicesStatus')->name('changeServicesStatus');
    Route::post('updateServicesStatus', 'SearlcoHomeController@updateServicesStatus')->name('updateServicesStatus');

    Route::get('changeContactStatus', 'SearlcoHomeController@changeContactStatus')->name('changeContactStatus');
    Route::post('updateContactStatus', 'SearlcoHomeController@updateContactStatus')->name('updateContactStatus');

    Route::get('changeFeaturesStatus', 'SearlcoHomeController@changeFeaturesStatus')->name('changeFeaturesStatus');
    Route::post('updateFeaturesStatus', 'SearlcoHomeController@updateFeaturesStatus')->name('updateFeaturesStatus');

    Route::get('changeNetworkStatus', 'SearlcoHomeController@changeNetworkStatus')->name('changeNetworkStatus');
    Route::post('updateNetworkStatus', 'SearlcoHomeController@updateNetworkStatus')->name('updateNetworkStatus');

    Route::get('changeStandardStatus', 'SearlcoHomeController@changeStandardStatus')->name('changeStandardStatus');
    Route::post('updateStandardStatus', 'SearlcoHomeController@updateStandardStatus')->name('updateStandardStatus');
});



Route::get('/indexClone', function () {
    return view('merchant.indexClone');
});

Route::get('/indexClone', function () {
    return view('affiliate.indexClone');
});
Route::get('clear-cache', function () {
   \Artisan::call('optimize:clear');
	\Artisan::call('config:cache');
	\Artisan::call('cache:clear');
	return "ok";
    return back();
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'UserController@index')->name('user');
Route::get('/admin', 'AdminController@index')->name('admin.home');
Route::get('/totalkeywords', 'AdminController@totalkeywords')->name('admin.totalkeywords');
Route::get('/getTotalKeywords', 'AdminController@getTotalKeywords')->name('admin.getTotalKeywords');
// Route::get('/saveDetail', function(){
// })->name('admin.home');

Route::get('/redUrl','PartnersMerchantController@countClick');

Route::post('/AddBrandPower','MerchantController@AddBrandPower');

//Route::get('/mafeTest','MerchantController@AddBrandPower');


