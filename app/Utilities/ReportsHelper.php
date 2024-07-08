<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;

class ReportsHelper
{
    public static function test()
    {
        return "Test Helper";
    }
    public static function  getLinkInfo($To, $From, $linkid)
    {


        //initiating
        $data = array();
        $click        = 0;
        $lead         = 0;
        $sale         = 0;
        $nClick       = 0;
        $nLead        = 0;
        $nSale        = 0;
        $pendingamnt  = 0;
        $approvedamnt = 0;
        $paidamnt     = 0;
        $rejectedamnt = 0;
        $saleCommission = 0;
        $leadCommission = 0;
        $clickCommission = 0;
        $impressionCommission = 0;
        $impression = 0;

        $dataClick = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))

            ->where([
                'transaction_linkid' => $linkid,
                'transaction_type' => 'click',

            ])->get();
        if (count($dataClick) > 0) {
            foreach ($dataClick as $row) {
                $clickCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $clickCommission;
            }
        }

        $nClick = count($dataClick) + $nClick;
        ////////////////////////////////////////////

        $dataLead = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))
            ->where([
                'transaction_linkid' => $linkid,
                'transaction_type' => 'lead',

            ])->get();

        if (count($dataLead) > 0) {
            foreach ($dataLead as $row) {
                $leadCommission = $row->transaction_amttobepaid + $row->transaction_admin_amount + $leadCommission;
            }
        }
        $nLead = count($dataLead) + $nLead;
        //////////////////////////////////////
        $dataSale = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))
            ->where([
                'transaction_linkid' => $linkid,
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
        $nSale = count($dataSale) + $nSale;

        # Approved Payments

        $dataApproved = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))

            ->where([
                'transaction_linkid' => $linkid,
                'transaction_status' => 'approved',


            ])->get();

        foreach ($dataApproved as $row) {
            $transactionId    = $row->transaction_id;
            $recur      =     $row->transaction_recur;
            // If the sale commission is of recurring type
            if ($recur == '1') {
                $dataApprovedRecur = DB::table('partners_recur')

                    ->where([
                        'recur_transactionid' => $transactionId,


                    ])->get();

                if (count($dataApprovedRecur) > 0) {
                    $row_recur    = $dataApprovedRecur[0];
                    $recurId    = $row_recur->recur_id;
                    $dataApprovedRecurPayments = DB::table('partners_recurpayments')

                        ->where([
                            'recurpayments_recurid' => $recurId,
                            'recurpayments_status' => 'approved',


                        ])->get();
                    if (count($dataApprovedRecurPayments) > 0) {

                        $row_recurpay     = $dataApprovedRecurPayments[0];
                        $approvedamnt      =  $row_recurpay->recurpayments_amount + $approvedamnt;

                    }
                }
            } else {
                // END Modified on 23-JUNE-06
                $approvedamnt = $row->transaction_amttobepaid + $approvedamnt; //total pending amnt
            }
        }

        # End Approved Payments


        #  Paid Payments
        $dataPaid = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))

            ->where([
                'transaction_linkid' => $linkid,


            ])->get();

        foreach ($dataPaid as $row) {
            $transactionId    = $row->transaction_id;
            $recur      =     $row->transaction_recur;
            // If the sale commission is of recurring type
            if ($recur == '1') {
                $dataApprovedRecur = DB::table('partners_recur')

                    ->where([
                        'recur_transactionid' => $transactionId,


                    ])->get();

                if (count($dataApprovedRecur) > 0) {
                    $row_recur    = $dataApprovedRecur[0];
                    $recurId    = $row_recur->recur_id;
                    $dataPaidRecurPayments = DB::table('partners_recurpayments')

                        ->where([
                            'recurpayments_recurid' => $recurId,


                        ])->get();
                    if (count($dataPaidRecurPayments) > 0) {
                        $row_recurpay     = $dataPaidRecurPayments[0];
                        $paidamnt      =  $row_recurpay->recurpayments_amount + $paidamnt;
                    }
                }
            } else {
                // END Modified on 23-JUNE-06
                $paidamnt = $row->transaction_amttobepaid + $paidamnt; //total pending amnt
            }
        }

        # End Paid Payments

        #  Reversed Payments
        $dataReversed = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))

            ->where([
                'transaction_linkid' => $linkid,
                'transaction_status' => 'reversed',


            ])->get();

        foreach ($dataReversed as  $row) {
            $rejectedamnt = $row->transaction_amttobepaid + $rejectedamnt; // total approved amnt
        }  //end while


        $dataReversedRecur = DB::table('partners_transaction', 't')

            ->join('partners_recur as r', 't.transaction_id', '=', 'r.recur_transactionid')
            ->join('partners_recurpayments as rp', 'r.recur_id', '=', 'rp.recurpayments_recurid')
            ->whereBetween('t.transaction_dateoftransaction', array($From, $To))
            ->where([
                'rp.recurpayments_status' => 'reversed',
                "t.transaction_linkid" => $linkid,
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

            ->where([
                'transaction_linkid' => $linkid,
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

        # End Pending Payments


        $dataImpression = DB::table('partners_transaction')
            ->whereBetween('transaction_dateoftransaction', array($From, $To))

            ->where([
                'transaction_linkid' => $linkid,
                'transaction_type' => 'impression',


            ])->get();


        if (count($dataImpression) > 0) {
            foreach ($dataImpression as $row) {
                $imp_amt = $row->transaction_amttobepaid + $row->transaction_admin_amount;
                $date                 =   $row->transaction_dateoftransaction;
                $impressionCommission = $imp_amt + $impressionCommission;
            }
        }  //end while

        $data['nClick'] = $nClick;
        $data['nLead'] = $nLead;
        $data['nImpression'] = 'NULL';
        $data['nSale'] = $nSale;
        $data['clickCommission'] = $clickCommission;
        $data['leadCommission'] = $leadCommission;
        $data['saleCommission'] = $saleCommission;
        $data['impressionCommission'] = $impressionCommission;
        $data['approvedamnt'] = $approvedamnt;
        $data['pendingamnt'] = $pendingamnt;
        $data['paidamnt'] = $paidamnt;
        $data['rejectedamnt'] = $rejectedamnt;
        $data['linkid'] = $linkid;






        return ($data);
    }

    public static function getRecurringTransactions($mid)
    {


        $data = DB::table('partners_affiliate', 'A')
            ->join('partners_joinpgm as J', 'A.affiliate_id', '=', 'J.joinpgm_affiliateid')
            ->join('partners_transaction as T', 'J.joinpgm_id', '=', 'T.transaction_joinpgmid')
            ->join('partners_recur as R', 'T.transaction_id', '=', 'R.recur_transactionid')
            ->select(
                'A.affiliate_id',
                'A.affiliate_firstname',
                'A.affiliate_lastname',
                'T.transaction_id',
                'T.transaction_dateoftransaction',
                'T.transaction_status',
                'T.transaction_amttobepaid',
                'T.transaction_orderid',
                'R.recur_status',
            )
            ->where([
                'T.transaction_recur' => '1',
                "J.joinpgm_merchantid" => $mid,
            ])
            ->get();


        // if(count($data) > 0)
        // {
        // 	foreach($data as $row)
        // 	{
        // 		$this->trans_id[]		= $row->transaction_id;
        // 		$this->aff_name[]		= $row->affiliate_firstname." ".$row->affiliate_lastname;
        // 		$this->aff_id[]			= $row->affiliate_id;
        // 		$this->trans_date[]		= $row->transaction_dateoftransaction;
        // 		$this->trans_status[]	= $row->transaction_status;
        // 		$this->trans_amount[]	= $row->transaction_amttobepaid;
        // 		$this->trans_orderid[]	= $row->transaction_orderid;
        // 		$this->recur_status[] 	= $row->recur_status;
        // 	}
        // 	return true;
        // }
        // else
        // 	return false;

        return $data;
    }

    public static function getRecurringCommissions($display, $mid)
    {



        $data = DB::table('partners_affiliate', 'A')
            ->join('partners_joinpgm as J', 'A.affiliate_id', '=', 'J.joinpgm_affiliateid')
            ->join('partners_transaction as T', 'J.joinpgm_id', '=', 'T.transaction_joinpgmid')
            ->join('partners_recur as R', 'T.transaction_id', '=', 'R.recur_transactionid')
            ->join('partners_recurpayments as P', 'R.recur_id', '=', 'P.recurpayments_recurid')
            ->select(
                'A.affiliate_id',
                'A.affiliate_firstname',
                'A.affiliate_lastname',
                'P.recurpayments_id',
                'P.recurpayments_date',
                'P.recurpayments_status',
                'P.recurpayments_amount',
                'T.transaction_orderid',
            )
            ->where([
                'T.transaction_recur' => '1',
                "J.joinpgm_merchantid" => $mid,
                'P.recurpayments_status' => $display,
                'R.recur_status' => 'Active',
            ])
            ->get();


        return $data;
    }
}
