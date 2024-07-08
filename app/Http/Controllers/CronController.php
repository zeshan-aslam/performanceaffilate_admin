<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\SiteHelper;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CronController extends Controller
{
    private $aiwntoken = 'Bearer 8c6f4b5c-c66e-4a54-b610-6406504478e5';
    private $cjtoken = 'Bearer 6tg0ym09recnbjz5thpfcynpem';

    public function AwinBackup()
    {
        $data = array();

        $id = 37293;
        $client = new Client();
        // $url = "https://api.awin.com/publishers/$id/transactions/?startDate=2021-07-01T01%3A00%3A00&endDate=2021-07-31T23%3A59%3A59&timezone=UTC&dateType=validation&status=approved";
        $startDate = date('Y-m-d', strtotime('- 24 hours'));
        $endDate = date('Y-m-d');


        $url = "https://api.awin.com/publishers/$id/transactions/?startDate=" . $startDate . "T00%3A00%3A00&endDate=" . date('Y-m-d') . "T23%3A59%3A59&timezone=UTC&dateType=validation&status=approved";
        $params = [
            //If you have any Params Pass here
        ];
        $headers = [
            'Authorization' => $this->aiwntoken
        ];
        try {
            $response = $client->request('GET', $url, [
                // 'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);

            $data = json_decode($response->getBody()->getContents());

            foreach ($data as $row) {

                #checking if this Awin Data is already in awin_transaction by Id
                $checkAwin = DB::table('awin_transaction')
                    ->where('transactionId', '=', $row->id)
                    ->exists();

                if (!$checkAwin) {
                    DB::table('awin_transaction')->insert([
                        'transactionId' => $row->id,
                        'url' => $row->url,
                        'advertiserId' => $row->advertiserId,
                        'publisherId' => $row->publisherId,
                        'siteName' => $row->siteName,
                        'commissionAmount' => $row->commissionAmount->amount,
                        'commissionCurrency' => $row->commissionAmount->currency,
                        'saleAmount' => $row->saleAmount->amount,
                        'saleCurrency' => $row->saleAmount->currency,
                        'clickRef' => ($row->clickRefs != null) ? $row->clickRefs->clickRef : "",
                        'clickDate' => $row->clickDate,
                        'transactionDate' => $row->transactionDate,
                        'validationDate' => $row->validationDate,
                        'orderRef' => $row->orderRef,
                        'customerCountry' => $row->customerCountry,
                        'clickDevice' => $row->clickDevice,
                        'transactionDevice' => $row->transactionDevice,
                        'commissionStatus' => $row->commissionStatus,
                        'voucherCodeUsed' => $row->voucherCodeUsed,
                        'voucherCode' => $row->voucherCode,

                    ]);
                    echo "<br>Saving to Our DB from Awin...." . $row->id;
                } else {
                    echo "<br>Already in Our DB...." . $row->id;
                }
            }
            #Let the Process wait for 1 second and set the Data into awin_transaction Table
            sleep(1);

            #counting Both partners_transaction & awin_transaction Rows
            $countTrans = DB::table('partners_transaction')->count();
            $countAwinTrans = DB::table('awin_transaction')->count();
            #getting Last Saved logs from Previous Cron from transCount Table
            $transCount = DB::table('transCount')
                ->where('name', 'awin')
                ->orderBy('id', 'desc')
                ->first();

            #checking if transCount->noOfAwinTrans < awin_transaction Rows
            #Detecting New Transactions from Awin 
            if ($transCount->countAwinTrans < $countAwinTrans) {
                #geting Latest Id of partners_transaction & awin_transaction
                $lastTransID = DB::table('partners_transaction')->max('transaction_id');
                $lastAwinTransID = DB::table('awin_transaction')->max('id');

                // geting Data from partners_transaction & awin_transaction between  
                // previously Saved partners_transaction->transaction_id in transCount->lastTransID
                // & previously Saved awin_transaction->id in transCount->lastAwinTransID to last rows 

                $transactions = DB::table('partners_transaction')->whereBetween('transaction_id', [$transCount->lastTransID, $lastTransID])
                    ->get();
                $awinTransactions = DB::table('awin_transaction')->whereBetween('id', [$transCount->lastAwinTransID, $lastAwinTransID])
                    ->get();
                #inserting New Logs to transCount Table

                DB::table('transCount')
                    ->insert([
                        'countAwinTrans' => $countAwinTrans,
                        'countTrans' => $countTrans,
                        'lastTransID' => $lastTransID,
                        'lastAwinTransID' => $lastAwinTransID,
                        'noOfTrans' => count($transactions) - 1,
                        'name' => 'awin',
                        'noOfAwinTrans' => count($awinTransactions) - 1,
                    ]);

                $i = 0;
                $countMatch = 0;
                #processing Detected awin_Transactions to save it into partners_transaction
                foreach ($awinTransactions as $row) {
                    $i++;
                    if ($i != 1) {
                        #getting partners_transaction row by awin_transaction->clickRef that was from Awin APIs
                        $transData = DB::table('partners_transaction')
                            ->where('transaction_id', '=', $row->clickRef)
                            ->orderBy('transaction_id', 'desc')
                            ->first();


                        #if Has partners_transaction->transaction_id matched with ClickRef of awin_transactions
                        if ($transData) {
                            #inserting all the Matched Transactions from Awin ClickRef & partners_transaction->transaction_id
                            # to awin_match Table by which ClickRef

                            DB::table('network_match')
                                ->insert([
                                    'transactionId' => $transData->transaction_id,
                                    'network_transactionId' => $row->transactionId,
                                    'ref' => $row->clickRef,
                                    'name' => 'awin',
                                ]);
                            # updating Matched partners_transaction Columns by Matched Id
                            if ($transData->transaction_type != "sale") {
                                DB::table('partners_transaction')
                                    ->where('transaction_id', '=', $transData->transaction_id)
                                    ->update([
                                        'transaction_admin_amount' => $row->commissionAmount * 0.20,
                                        'transaction_amttobepaid' => $row->commissionAmount * 0.80,
                                        'transaction_status' => 'pending',
                                        'transaction_type' => 'sale',
                                        'transaction_country' => ($row->customerCountry != NULL) ? $row->customerCountry : "",
                                    ]);
                            }


                            #Partners_Revenue Area
                            //     $joinpgmid=DB::table('partners_joinpgm')
                            //   ->where('joinpgmid_id', '=', $transData->transaction_joinpgmid)
                            //   ->first();
                            //   DB::table('partners_track_revenue')
                            //   ->insert([
                            //       'revenue_trans_type' => 'sale',
                            //       'revenue_amount' => $row->saleAmount,
                            //       'revenue_date' => '$row->transactionDate,
                            //       'revenue_transaction_id' => $transData->transaction_id,
                            //      'revenue_merchantid' =>$joinpgmid->joinpgm_merchantId,
                            //   ]);

                            #End Partners_Revenue Area#Partners_Revenue Area


                            echo "<br>Updating to Our Transactions from Awin...." . $transData->transaction_id;


                            $countMatch++;
                        }
                        #if Not Has partners_transaction->transaction_id matched with ClickRef of awin_transactions
                        else {
                            # Not Matched Transactions


                            DB::table('network_match')
                                ->insert([
                                    'transactionId' => 0,
                                    'network_transactionId' => $row->transactionId,
                                    'ref' => 0,
                                    'name' => 'awin',
                                ]);
                            $hasTransCopyData = DB::table('partners_transaction_copy')
                                ->where('transaction_id', '=', $row->transactionId)
                                ->exists();
                            if (!$hasTransCopyData) {

                                DB::table('partners_transaction_copy')
                                    ->insert([

                                        'transaction_id' => $row->transactionId,
                                        'transaction_dateoftransaction' => substr($row->transactionDate, 0, 10),
                                        'transaction_dateofpayment' => ($row->validationDate != NULL) ? $row->validationDate : "",
                                        'transaction_admin_amount' => $row->commissionAmount * 0.20,
                                        'transaction_amttobepaid' => $row->commissionAmount * 0.80,
                                        'transaction_status' => 'pending',
                                        'transaction_country' => ($row->customerCountry != NULL) ? $row->customerCountry : "",
                                        'transaction_referer' => 'example.com',
                                        'transaction_orderid' => ($row->orderRef != NULL) ? $row->orderRef : "",
                                        'transaction_ip' => '00.00.000',
                                        'transaction_type' => 'sale',
                                        'transaction_subid' => '0000',
                                        'transaction_transactiontime' => $row->transactionDate,
                                        'aiapproved' => 0,
                                        'aiscore' => 0
                                    ]);

                                echo "<br>Inserting Not Matched Records to Our DB from Awin...." . $row->transactionId;
                            }
                        } # End Not Matched Transactions
                    }
                } # End Looop

                echo "<br>Total New Detected Awin Transactions = <b>" . (count($awinTransactions) - 1) . "</b>";
                echo "<br> No of Matched =<b>" . $countMatch . "</b>";
            }
            #End Detecting New Transactions from Awin 
            else {
                echo "<br>No New Transaction Found";
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // echo "<br>Data " . count($data);
        echo "<br>Cron Run At " . date('Y-m-d H:i:s');
    }
    public function CjBackup()
    {
        try {

            $client = new Client();
            $response = $client->request('post', 'https://commissions.api.cj.com/query', [
                'headers' => [
                    'Authorization' => $this->cjtoken,
                    'Content-Type' => 'application/json'
                ],
                'body' =>
                '{ 
                publisherCommissions(
                    forPublishers: ["2813838"], 
                    sincePostingDate:"2022-06-01T00:00:00Z",
                    beforePostingDate:"2022-06-17T00:00:00Z"
                    )
                   {
                        count
                        payloadComplete
                        records 
                          {
                            commissionId
                            actionTrackerName 
                            websiteName
                            advertiserName
                            postingDate
                            pubCommissionAmountUsd 
                            original
                            saleAmountUsd
                            orderId
                            items 
                                  { 
                                     quantity
                                     perItemSaleAmountPubCurrency
                                     totalCommissionPubCurrency
                                   }
                            }
                    }
                }'
            ]);
            // $CJData= $response->getBody()->getContents();
            return  $response;
        } catch (\Exception $e) {
            return  dd($e);
        }
    }
}
