<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use PDO;
use PhpParser\Node\Expr\Cast\Object_;

class SiteHelper
{
    public function getCategoryName($merchant_id)
    {
        $mer_cat = DB::table('partners_merchant')->select(["partners_category.cat_name"])
        ->join('partners_category', 'partners_merchant.merchant_category', '=', 'partners_category.cat_id')
        ->where('merchant_id', $merchant_id)->get();
        $category=array();
        foreach($mer_cat as $m_cat)
        {
            $category=$m_cat->cat_name;
        }
        return $category;
    }
    public function getCountryName($merchant_id)
    {
        
        $merchant_country = DB::table('partners_merchant')->select(["partners_country.country_name"])
        ->join('partners_country', 'partners_merchant.merchant_country', '=', 'partners_country.country_no')
        ->where('merchant_id',$merchant_id)->get();
        $cny=array();
        foreach($merchant_country as $mer_cnty)
        {
            $cny=$mer_cnty->country_name;
        }
        return $cny;
    }
    public function getCountryOfPromotionName($merchant_id)
    {
        $country_promotion = DB::table('mer_cop')->select(["partners_country.country_name"])
        ->join('partners_country', 'mer_cop.cop_id', '=', 'partners_country.country_no')
        ->where('client_id', $merchant_id)->get();
        $country_pro="";
        foreach($country_promotion as $c_promotion)
        {
            // $country_pro.=$c_promotion->country_name;
            $country_pro .= $c_promotion->country_name . "<br />";
        }
        $final_pro_country = rtrim($country_pro, '<br />');
        return $final_pro_country;
    }
    public function getAffCountryOfPromotionName($affiliate_id)
    {
        $country_promotion = DB::table('aff_cop')->select(["partners_country.country_name"])
        ->join('partners_country', 'aff_cop.cop_id', '=', 'partners_country.country_no')
        ->where('client_id', $affiliate_id)->get();
        $country_pro="";
        foreach($country_promotion as $c_promotion)
        {
            // $country_pro.=$c_promotion->country_name;
            $country_pro .= $c_promotion->country_name . "<br />";
        }
        $final_pro_country = rtrim($country_pro, '<br />');
        return $final_pro_country;
    }
    public function getAffCategoryName($affiliate_id)
    {
        $Affiliate_categories = DB::table('aff_cates')->select(["partners_category.cat_name"])
        ->join('partners_category', 'aff_cates.cates_id', '=', 'partners_category.cat_id')
        ->where('client_id', $affiliate_id)->get();
        $Affcategory="";
        foreach($Affiliate_categories as $Aff_categories)
        {
            // $country_pro.=$c_promotion->country_name;
            $Affcategory .= $Aff_categories->cat_name . "<br />";
        }
        $final_category_Name = rtrim($Affcategory, '<br />');
        return $final_category_Name;
    }




    public  function  getAdvLinks($program_id, $merchant_id)
    {
        switch ($program_id) {
            case '0':
                $banner = DB::table('partners_banner')
                    ->where(['banner_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();

                $popup = DB::table('partners_popup')
                    ->where(['popup_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();

                $flash = DB::table('partners_flash')
                    ->where(['flash_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();

                $html = DB::table('partners_html')
                    ->where(['html_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();

                $text = DB::table('partners_text')
                    ->where(['text_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();

                $text_old = DB::table('partners_text_old')
                    ->where(['text_programid' => $program_id, 'program_merchantid' => $merchant_id])
                    ->count();
                break;
            default:
                $banner = DB::table('partners_banner')
                    ->where('banner_programid', '=', $program_id)
                    ->count();

                $popup = DB::table('partners_popup')
                    ->where('popup_programid', '=', $program_id)
                    ->count();

                $flash = DB::table('partners_flash')
                    ->where('flash_programid', '=', $program_id)
                    ->count();

                $html = DB::table('partners_html')
                    ->where('html_programid', '=', $program_id)
                    ->count();

                $text = DB::table('partners_text')
                    ->where('text_programid', '=', $program_id)
                    ->count();

                $text_old = DB::table('partners_text_old')
                    ->where('text_programid', '=', $program_id)
                    ->count();

                break;
        }

        return compact('banner', 'popup', 'flash', 'html', 'text', 'text_old');
    }
    // public static function  GetPaymentPendingDetails($id, $flag)
    // {
    //     session(['id' => $id]);
    //     switch ($flag) {
    //         case 1:   //merchant
    //             $result1 = DB::table('partners_joinpgm', 'j')->select('j.joinpgm_id')
    //                 ->join('partners_program as p', function ($join) {
    //                     $join->on('j.joinpgm_programid', '=', 'p.program_id')
    //                         ->where('program_merchantid', '=', session('id'));
    //                 })
    //                 ->get();
    //             // $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
    //             break;
    //         case 2: //affiliate
    //             $result1 = DB::table('partners_joinpgm')
    //                 ->where('joinpgm_affiliateid', '=', $id)
    //                 ->get();
    //             // $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
    //             break;
    //     }

    //     $pendingamnt       = 0;


    //     foreach ($result1 as $rows) {
    //         $joinid = $rows->joinpgm_id;
    //         // $sql = "SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
    //         $result = DB::table('partners_transaction')->select(['transaction_id','transaction_recur','transaction_amttobepaid'])
    //             ->where('transaction_joinpgmid', '=', $joinid)
    //             ->where('transaction_status', '=', 'pending')
    //             ->get();
    //         foreach ($result as $row) {
    //             $transactionId    = $row->transaction_id;
    //             $recur      =     $row->transaction_recur;
    //             // If the sale commission is of recurring type
    //             if ($recur == '1') {
    //                 // $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
    //                 $res_Recur =  DB::table('partners_recur')->select('recur_id')
    //                     ->where('recur_transactionid', '=', $transactionId)
    //                     ->first();
    //                 if ($res_Recur) {
    //                     // $row_recur    = $res_Recur;
    //                     $recurId    = $res_Recur->recur_id;
    //                     // $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
    //                     $res_recurpay = DB::table('partners_recurpayments')->select('recurpayments_amount')
    //                         ->where('recurpayments_recurid', '=', $recurId)
    //                         ->where('recurpayments_status', '=', 'pending')
    //                         ->first();
    //                     if ($res_recurpay) {
    //                         // $row_recurpay     = $res_recurpay;
    //                         $pendingamnt      =  $res_recurpay->recurpayments_amount + $pendingamnt;
    //                     }
    //                 }
    //             } else {

    //                 $pendingamnt = $row->transaction_amttobepaid + $pendingamnt; //total pending amnt
    //             }
    //         }
    //         $total = $pendingamnt;
    //         return $total;
    //     }
    // }

    public static function  GetPaymentPendingDetails($id, $flag)
    {
        session(['id' => $id]);
        switch ($flag) {
            case 1:   //merchant
                $result1 = DB::table('partners_joinpgm', 'j')->select('j.joinpgm_id')
                    ->join('partners_program as p', function ($join) {
                        $join->on('j.joinpgm_programid', '=', 'p.program_id')
                            ->where('program_merchantid', '=', session('id'));
                    })
                    ->cursor();
                    
                // $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
                break;
            case 2: //affiliate
                $result1 = DB::table('partners_joinpgm')
                    ->where('joinpgm_affiliateid', '=', $id)
                    ->cursor();
                // $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
                break;
        }

        $pendingamnt       = 0;


        foreach ($result1 as $rows) {
            $joinid = $rows->joinpgm_id;
            // $sql = "SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
            $result = DB::table('partners_transaction')->select(['transaction_id','transaction_recur','transaction_amttobepaid'])
                ->where('transaction_joinpgmid', '=', $joinid)
                ->where('transaction_status', '=', 'pending')->orderBy('transaction_status','desc')
                ->chunk(2,function($result) use($pendingamnt){
                    foreach ($result as $row) {
                        $transactionId    = $row->transaction_id;
                        $recur      =     $row->transaction_recur;
                        // If the sale commission is of recurring type
                        if ($recur == '1') {
                            // $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                            $res_Recur =  DB::table('partners_recur')->select('recur_id')
                                ->where('recur_transactionid', '=', $transactionId)
                                ->first();
                            if ($res_Recur) {
                                // $row_recur    = $res_Recur;
                                $recurId    = $res_Recur->recur_id;
                                // $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
                                $res_recurpay = DB::table('partners_recurpayments')->select('recurpayments_amount')
                                    ->where('recurpayments_recurid', '=', $recurId)
                                    ->where('recurpayments_status', '=', 'pending')
                                    ->first();
                                if ($res_recurpay) {
                                    // $row_recurpay     = $res_recurpay;
                                    $pendingamnt      =  $res_recurpay->recurpayments_amount + $pendingamnt;
                                }
                            }
                        } else {
        
                            $pendingamnt = $row->transaction_amttobepaid + $pendingamnt; //total pending amnt
                        }
                    }
                });
            
            $total = $pendingamnt;
            return $total;
        }
    }





    // public static function  GetPaymentPendingDetails($id, $flag)
    // {
    //     session(['id' => $id]);
    //     switch ($flag) {
    //         case 1:   //merchant
    //             $result1 = DB::table('partners_joinpgm', 'j')
    //                 ->join('partners_program as p', function ($join) {
    //                     $join->on('j.joinpgm_programid', '=', 'p.program_id')
    //                         ->where('program_merchantid', '=', session('id'));
    //                 })->get();
    //             break;
    //         case 2: //affiliate
    //             $result1 = DB::table('partners_joinpgm')
    //                 ->where('joinpgm_affiliateid', '=', $id)
    //                 ->get();
    //             break;
    //     }

    //     $pendingamnt       = 0;


    //     foreach ($result1 as $rows) {
    //         $joinid = $rows->joinpgm_id;
    //         // $sql = "SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
    //         $result = DB::table('partners_transaction')
    //             ->where('transaction_joinpgmid', '=', $joinid)
    //             ->where('transaction_status', '=', 'pending')
    //             ->get();
    //         foreach ($result as $row) {
    //             $transactionId    = $row->transaction_id;
    //             $recur      =     $row->transaction_recur;
    //             // If the sale commission is of recurring type
    //             if ($recur == '1') {
    //                 // $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
    //                 $res_Recur =  DB::table('partners_recur')
    //                     ->where('recur_transactionid', '=', $transactionId)
    //                     ->first();
    //                 if ($res_Recur) {
    //                     $row_recur    = $res_Recur;
    //                     $recurId    = $row_recur->recur_id;
    //                     // $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
    //                     $res_recurpay = DB::table('partners_recurpayments')
    //                         ->where('recurpayments_recurid', '=', $recurId)
    //                         ->where('recurpayments_status', '=', 'pending')
    //                         ->first();
    //                     if ($res_recurpay) {
    //                         $row_recurpay     = $res_recurpay;
    //                         $pendingamnt      =  $row_recurpay->recurpayments_amount + $pendingamnt;
    //                     }
    //                 }
    //             } else {

    //                 $pendingamnt = $row->transaction_amttobepaid + $pendingamnt; //total pending amnt
    //             }
    //         }
    //         $total = $pendingamnt;
    //         return $total;
    //     }
    // }
    public static function  GetPaymentApprovedDetails($id, $flag)
    {
        switch ($flag) {
            case 1:   //merchant
                $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
                break;
            case 2: //affiliate
                $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
                break;
        }
        $result1        = DB::select($sql);

        $approvedamnt    = 0;


        foreach ($result1 as $rows) {
            $joinid = $rows->joinpgm_id;



            $sql = "SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                    $res_Recur = DB::select($sql_Recur);
                    if ($res_Recur) {
                        $row_recur    = $res_Recur[0];
                        $recurId    = $row_recur->recur_id;
                        $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
                        $res_recurpay = DB::select($sql_recurpay);
                        if ($res_recurpay) {
                            $row_recurpay     = $res_recurpay[0];
                            $approvedamnt      =  $row_recurpay->recurpayments_amount + $approvedamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $approvedamnt = $row->transaction_amttobepaid + $approvedamnt; //total pending amnt
                }
            }
            $total = $approvedamnt;
            return $total;
        }
    }
    public static function  GetPaymentPaidDetails($id, $flag)
    {
        switch ($flag) {
            case 1:   //merchant
                $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
                break;
            case 2: //affiliate
                $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
                break;
        }
        $result1        = DB::select($sql);
        $paidamnt        = 0;


        foreach ($result1 as $rows) {
            $joinid = $rows->joinpgm_id;
            $sql = "SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                    $res_Recur = DB::select($sql_Recur);
                    if ($res_Recur) {
                        $row_recur    = $res_Recur[0];
                        $recurId    = $row_recur->recur_id;
                        $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
                        $res_recurpay = DB::select($sql_recurpay);
                        if ($res_recurpay) {
                            $row_recurpay     = $res_recurpay[0];
                            $paidamnt      =  $row_recurpay->recurpayments_amount + $paidamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $paidamnt = $row->transaction_amttobepaid + $paidamnt; //total pending amnt
                }
            }




            $total = $paidamnt;
            return $total;
        }
    }
    public static function  GetPaymentRejectedDetails($id, $flag)
    {
        switch ($flag) {
            case 1:   //merchant
                $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
                break;
            case 2: //affiliate
                $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
                break;
        }
        $result1        = DB::select($sql);

        $rejectedamnt    = 0;

        foreach ($result1 as $rows) {
            $joinid = $rows->joinpgm_id;
            $sql = "SELECT * from partners_transaction where transaction_status='reversed' and transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $rejectedamnt = $row->transaction_amttobepaid + $rejectedamnt; //total sale amnt
            }
            //Calculate reversed commissions fro Recurring sales
            $sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE " .
                " transaction_joinpgmid='$joinid' AND recur_transactionid=transaction_id AND " .
                " recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";

            $res_rev = DB::select($sql_rev);
            if ($res_rev) {
                foreach ($res_rev as $row_rev) {
                    $rejectedamnt = $row_rev->recurpayments_amount + $rejectedamnt;
                }
            }

            $total = $rejectedamnt;
            return ($total);
        }
    }
    public static function  GetPaymentDetails($id, $flag)
    {

        switch ($flag) {
            case 1:   //merchant
                $sql = "SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
                break;
            case 2: //affiliate
                $sql = "SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
                break;
        }
        $result1        = DB::select($sql);
        $pendingamnt       = 0;
        $approvedamnt    = 0;
        $paidamnt        = 0;
        $rejectedamnt    = 0;

        foreach ($result1 as $rows) {
            $joinid = $rows->joinpgm_id;
            $sql = "SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                    $res_Recur = DB::select($sql_Recur);
                    if ($res_Recur) {
                        $row_recur    = $res_Recur[0];
                        $recurId    = $row_recur->recur_id;
                        $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
                        $res_recurpay = DB::select($sql_recurpay);
                        if ($res_recurpay) {
                            $row_recurpay     = $res_recurpay[0];
                            $pendingamnt      =  $row_recurpay->recurpayments_amount + $pendingamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $pendingamnt = $row->transaction_amttobepaid + $pendingamnt; //total pending amnt
                }
            }


            $sql = "SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                    $res_Recur = DB::select($sql_Recur);
                    if ($res_Recur) {
                        $row_recur    = $res_Recur[0];
                        $recurId    = $row_recur->recur_id;
                        $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
                        $res_recurpay = DB::select($sql_recurpay);
                        if ($res_recurpay) {
                            $row_recurpay     = $res_recurpay[0];
                            $approvedamnt      =  $row_recurpay->recurpayments_amount + $approvedamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $approvedamnt = $row->transaction_amttobepaid + $approvedamnt; //total pending amnt
                }
            }


            $joinid = $rows->joinpgm_id;
            $sql = "SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $transactionId    = $row->transaction_id;
                $recur      =     $row->transaction_recur;
                // If the sale commission is of recurring type
                if ($recur == '1') {
                    $sql_Recur     = "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
                    $res_Recur = DB::select($sql_Recur);
                    if ($res_Recur) {
                        $row_recur    = $res_Recur[0];
                        $recurId    = $row_recur->recur_id;
                        $sql_recurpay    = "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
                        $res_recurpay = DB::select($sql_recurpay);
                        if ($res_recurpay) {
                            $row_recurpay     = $res_recurpay[0];
                            $paidamnt      =  $row_recurpay->recurpayments_amount + $paidamnt;
                        }
                    }
                } else {
                    // END Modified on 23-JUNE-06
                    $paidamnt = $row->transaction_amttobepaid + $paidamnt; //total pending amnt
                }
            }


            $joinid = $rows->joinpgm_id;
            $sql = "SELECT * from partners_transaction where transaction_status='reversed' and transaction_joinpgmid='$joinid'";
            $result = DB::select($sql);
            foreach ($result as $row) {
                $rejectedamnt = $row->transaction_amttobepaid + $rejectedamnt; //total sale amnt
            }
            //Calculate reversed commissions fro Recurring sales
            $sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE " .
                " transaction_joinpgmid='$joinid' AND recur_transactionid=transaction_id AND " .
                " recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";

            $res_rev = DB::select($sql_rev);
            if ($res_rev) {
                foreach ($res_rev as $row_rev) {
                    $rejectedamnt = $row_rev->recurpayments_amount + $rejectedamnt;
                }
            }
            //End Reverse Calculation



            $total = $approvedamnt . "~" . $pendingamnt . "~" . $paidamnt . "~" . $rejectedamnt;
            return ($total);
        }
    }

    public static function  GetRawTrans($type, $mid, $aid, $pgmid, $linkid,  $from, $to, $date)
    {
        $sum = array();
        $i = 0;

        $data = array();

        # finds for a perticular merchant

        // if ($mid != 0 ) {
        //     $data['transdaily_merchantid']=$mid;

        // }
        // if ($aid != 0 ) {
        //     $data['transdaily_affiliateid']=$aid;


        // }
        // if ($pgmid != 0 ) {
        //     $data['transdaily_programid']=$pgmid;


        // }
        // if ($linkid != '') {
        //     $data['transdaily_linkid']=$linkid;


        // }
        // dd($data);
        if ($to != '' && $from != '' && $date != '') {
            $datas = DB::table('partners_rawtrans_daily')

                ->where([
                    'transdaily_merchantid' => $mid,
                    'transdaily_affiliateid' => $aid,
                    'transdaily_programid' => $pgmid,
                    'transdaily_linkid' => $linkid,


                ])

                ->orWhere('transdaily_date', 'like', '%' . $date . '%')

                ->whereBetween('transdaily_date', array($from, $to))
                ->get();
        } elseif ($to != '' && $from != '') {
            $datas = DB::table('partners_rawtrans_daily')
                ->where([
                    'transdaily_merchantid' => $mid,
                    'transdaily_affiliateid' => $aid,
                    'transdaily_programid' => $pgmid,
                    'transdaily_linkid' => $linkid,


                ])
                ->whereBetween('transdaily_date', array($from, $to))
                ->get();
        } elseif ($date != '') {
            $datas = DB::table('partners_rawtrans_daily')
                ->where([
                    'transdaily_merchantid' => $mid,
                    'transdaily_affiliateid' => $aid,
                    'transdaily_programid' => $pgmid,
                    'transdaily_linkid' => $linkid,


                ])
                ->orWhere('transdaily_date', 'like', '%' . $date . '%')
                ->get();
        } else {
            $datas = DB::table('partners_rawtrans_daily')->get();
        }




        if ($type == 'impression') {
            foreach ($datas as $row) {
                $sum[$i] = $row->transdaily_impression;
                $i++;
            }
        }

        if ($type == 'click') {
            foreach ($datas as $row) {
                $sum[$i] = $row->transdaily_click;
                $i++;
            }
        }



        $totalRecord =  array_sum($sum);

        // dd($datas);



        return $totalRecord;
    }


    public static function slug(string $str): string
    {
        $str = self::stripVnUnicode($str);
        $str = preg_replace('/[^A-Za-z0-9-]/', ' ', $str);
        $str = preg_replace('/ +/', ' ', $str);
        $str = trim($str);
        $str = str_replace(' ', '-', $str);
        $str = preg_replace('/-+/', '-', $str);
        $str =  preg_replace("/-$/", '', $str);
        return strtolower($str);
    }
    public static function stripVnUnicode(string $str): string
    {
        if (!$str) {
            return false;
        }
        $str = strip_tags($str);
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        ];
        foreach ($unicode as $key  => $value) {
            $str = preg_replace("/($value)/i", $key, $str);
        }
        return $str;
    }
    public static function date2mysql($date)
    {
        $tmp        = explode('/', $date);
        if (count($tmp) != 3) {
            $tmp        = explode('-', $date);
            if (count($tmp) != 3) return "0000-00-00";
        }
        $date        = "$tmp[2]-$tmp[1]-$tmp[0]";
        return $date;
    }

    public static function format_date($dob, $time = 0)
    {
        $tmp        = explode(" ", $dob);
        $date2        = explode("/", $tmp[0]);
        $dob        = $date2[2] . "/" . $date2[0] . "/" . $date2[1];
        if ($time)
            return $dob . " " . $tmp[1];
        else
            return $dob;
    }

    public static function sideMenu()
    {
        $menu = array(
            array(
                "name" => "Dashboard",
                "href" => "admin.home",
                "icon" => "icon-dashboard",
            ),
            array(
                "name" => "Merchants",
                "href" => "Merchant.index",
                "icon" => "icon-briefcase",
            ),
            array(
                "name" => "Affiliates",
                "href" => "Affiliate.index",
                "icon" => "icon-th-large",
            ),
            array(
                "name" => "Programs",
                "href" => "Program.index",
                "icon" => "icon-tasks",
            ),
            array(
                "name" => "Payments",
                "href" => "payment.paymentHistoryForm",
                "icon" => "icon-book",
            ),
            array(
                "name" => "Reports",
                "href" => "Report.index",
                "icon" => "icon-signal",
            ),
            array(
                "name" => "Options",
                "href" => "Options.index",
                "icon" => "icon-wrench",
            ),
            array(
                "name" => "PGM Status",
                "href" => "PGMStatus.index",
                "icon" => "icon-foursquare",

            ),
            array(
                "name" => "Networks",
                "href" => "network.index",
                "icon" => "icon-won",


            ),
            array(
                "name" => "Searlco Home",
                "href" => "searlco.index",
                "icon" => "icon-fire",
                "submenu" => array(
                    array(
                        "name" => "Site Title",
                        "href" => "searlco.titleView",
                        "icon" => "icon-dashboard",
                    ),
                    array(
                        "name" => "Header",
                        "href" => "searlco.headerView",
                        "icon" => "",

                    ),
                    array(
                        "name" => "Slider",
                        "href" => "searlco.sliderView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Services",
                        "href" => "searlco.servicesView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Searlco Network ",
                        "href" => "searlco.searlcoNetworkView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Features",
                        "href" => "searlco.featuresView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Standards",
                        "href" => "searlco.standardView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Trusted Brands",
                        "href" => "searlco.trustedBrandsView",
                        "icon" => "",

                    ),

                    array(
                        "name" => "Contact",
                        "href" => "searlco.contactView",
                        "icon" => "",

                    ),

                )
            ),


        );
        return $menu;
    }
    public static function constants()
    {
    }
    public static function getConstant($key)
    {


        $constant  = DB::table('admin_constants')->where(['constant_key' => $key])
            ->select('constant_name')
            ->first();
        return $constant->constant_name;
    }

    public static function setConstant($key, $value)
    {

        return DB::table('admin_constants')
            ->where(['constant_key' => $key])
            ->limit(1)
            ->update(array('constant_name' => $value));
    }

    public static function recursiveArray($arr)
    {

        $count = 0;
        $valuesPrint = '';
        global $items;

        // Check input is an array
        if (!is_array($arr)) {
            die("ERROR: Input is not an array");
        }

        /*
            Loop through array, if value is itself an array recursively call the function,
            else add the value found to the output items array,
            and increment counter by 1 for each value found
            */
        foreach ($arr as $a) {
            if (is_array($a)) {
                SiteHelper::recursiveArray($a);
                $count++;
            } else {
                if ($count > 0) {
                    $items[] = $a;
                } else {
                    echo '<li>' . $a . '</li>';
                }
            }
        }

        // Return total count and values found in array
        return array('total' => $count, 'values' => $items);
    }
    public static function ConvertToPreviousBaseCurrency($currrencyCode)
    {

        session(['currrencyCode' => $currrencyCode]);
        $data = DB::table('partners_currency', 'C')
            ->join('partners_currency_relation as R', function ($join) {

                $join->on('C.currency_code', '=', 'R.relation_currency_code')
                    ->where('C.currency_code', '=',   session('currrencyCode'));
            })
            ->select('C.*', 'R.*')
            ->orderby('relation_date', 'DESC')
            ->distinct()
            ->first();

        if ($data) {

            $currRelation = $data->relation_value;
            $ret = array();

            //Admin_pay
            $sql_admin = "Update admin_pay SET pay_amount = pay_amount / ? ";  //die("sql = ".$sql_admin);
            $ret[] = DB::update($sql_admin, [$currRelation]);

            //affiliate_pay
            $sql_aff_pay  = "UPDATE affiliate_pay SET pay_amount = pay_amount / ? ";
            $ret[] = DB::update($sql_aff_pay, [$currRelation]);

            //merchant_pay
            $qry = "UPDATE merchant_pay SET pay_amount  = pay_amount / ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_addmoney
            $qry = "Update partners_addmoney SET addmoney_amount  = addmoney_amount / ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_adjustment
            $qry = "Update partners_adjustment SET adjust_amount = adjust_amount / ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_fee
            $qry = "Update partners_fee SET adjust_amount = adjust_amount  / ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            $sql_pgm = "UPDATE partners_program SET program_impressionrate=program_impressionrate /? ,
				program_clickrate=program_clickrate/? ";
            $ret[] = DB::update($sql_pgm, [$currRelation, $currRelation]);

            $sql_comm = "UPDATE partners_pgm_commission SET commission_leadrate=commission_leadrate/? ";
            $ret[] = DB::update($sql_comm, [$currRelation]);

            $sql_comm2 = "UPDATE partners_pgm_commission SET commission_salerate=commission_salerate/?
				WHERE commission_saletype != '%' ";
            $ret[] = DB::update($sql_comm2, [$currRelation]);

            //partners_group
            $qry = "Update partners_group SET group_clickrate = group_clickrate / ? , " .
                " group_leadrate = group_leadrate /  ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            //	partners_invoice
            $qry = "UPDATE partners_invoice SET invoice_amount = invoice_amount /  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_ipblocking
            $qry = "UPDATE partners_ipblocking SET ipblocking_click = ipblocking_click  / ? , " .
                " ipblocking_lead = ipblocking_lead   / ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            $qry = "UPDATE partners_ipblocking SET ipblocking_sale = ipblocking_sale / ? " .
                " WHERE ipblocking_saletype != '%' ";
            $ret[] = DB::update($qry, [$currRelation]);


            //	partners_payment
            $qry = "UPDATE partners_payment SET pay_amount = pay_amount /  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_recur
            $qry = "UPDATE partners_recur SET recur_totalcommission = recur_totalcommission /  ? , " .
                " recur_balanceamt = recur_balanceamt /  ? , " .
                " recur_total_subsalecommission = recur_total_subsalecommission /  ? , " .
                " recur_balance_subsaleamt = recur_balance_subsaleamt /   ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation, $currRelation, $currRelation]);

            //partners_recurpayments
            $qry = "UPDATE partners_recurpayments SET recurpayments_amount = recurpayments_amount /  ? , " .
                " recurpayments_subsaleamount = recurpayments_subsaleamount /  ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            //partners_request
            $qry = "UPDATE partners_request SET request_amount = request_amount  /  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_track_revenue
            $qry = "UPDATE partners_track_revenue SET revenue_amount =revenue_amount   /  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_transaction
            $qry = "UPDATE partners_transaction SET transaction_amttobepaid = transaction_amttobepaid  /  ? , " .
                " transaction_amountpaid = transaction_amountpaid  /  ?, " .
                " transaction_subsale = transaction_subsale /  ? , " .
                " transaction_reverseamount = transaction_reverseamount /  ? , " .
                " transaction_adminpaid = transaction_adminpaid /  ? , " .
                " transaction_subsalepaid = transaction_subsalepaid /  ?  ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation, $currRelation, $currRelation, $currRelation, $currRelation]);

            if (in_array('', $ret)) {
                return 3;
            }
        } else {

            return 2;
        }
    }
    public static function ConvertToNewBaseCurrency($currrencyCode)
    {

        session(['currrencyCode' => $currrencyCode]);
        $data = DB::table('partners_currency', 'C')
            ->join('partners_currency_relation as R', function ($join) {

                $join->on('C.currency_code', '=', 'R.relation_currency_code')
                    ->where('C.currency_code', '=',   session('currrencyCode'));
            })
            ->select('C.*', 'R.*')
            ->orderby('relation_date', 'DESC')
            ->distinct()
            ->first();

        if ($data) {

            $currRelation = $data->relation_value;
            $ret = array();

            //Admin_pay
            $sql_admin = "Update admin_pay SET pay_amount = pay_amount * ? ";  //die("sql = ".$sql_admin);
            $ret[] = DB::update($sql_admin, [$currRelation]);

            //affiliate_pay
            $sql_aff_pay  = "UPDATE affiliate_pay SET pay_amount = pay_amount * ? ";
            $ret[] = DB::update($sql_aff_pay, [$currRelation]);

            //merchant_pay
            $qry = "UPDATE merchant_pay SET pay_amount  = pay_amount * ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_addmoney
            $qry = "Update partners_addmoney SET addmoney_amount  = addmoney_amount * ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_adjustment
            $qry = "Update partners_adjustment SET adjust_amount = adjust_amount * ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_fee
            $qry = "Update partners_fee SET adjust_amount = adjust_amount  * ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            $sql_pgm = "UPDATE partners_program SET program_impressionrate=program_impressionrate *? ,
				program_clickrate=program_clickrate*? ";
            $ret[] = DB::update($sql_pgm, [$currRelation, $currRelation]);

            $sql_comm = "UPDATE partners_pgm_commission SET commission_leadrate=commission_leadrate*? ";
            $ret[] = DB::update($sql_comm, [$currRelation]);

            $sql_comm2 = "UPDATE partners_pgm_commission SET commission_salerate=commission_salerate*?
				WHERE commission_saletype != '%' ";
            $ret[] = DB::update($sql_comm2, [$currRelation]);

            //partners_group
            $qry = "Update partners_group SET group_clickrate = group_clickrate * ? , " .
                " group_leadrate = group_leadrate *  ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            //	partners_invoice
            $qry = "UPDATE partners_invoice SET invoice_amount = invoice_amount *  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_ipblocking
            $qry = "UPDATE partners_ipblocking SET ipblocking_click = ipblocking_click  * ? , " .
                " ipblocking_lead = ipblocking_lead   * ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            $qry = "UPDATE partners_ipblocking SET ipblocking_sale = ipblocking_sale * ? " .
                " WHERE ipblocking_saletype != '%' ";
            $ret[] = DB::update($qry, [$currRelation]);


            //	partners_payment
            $qry = "UPDATE partners_payment SET pay_amount = pay_amount *  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_recur
            $qry = "UPDATE partners_recur SET recur_totalcommission = recur_totalcommission *  ? , " .
                " recur_balanceamt = recur_balanceamt *  ? , " .
                " recur_total_subsalecommission = recur_total_subsalecommission *  ? , " .
                " recur_balance_subsaleamt = recur_balance_subsaleamt *   ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation, $currRelation, $currRelation]);

            //partners_recurpayments
            $qry = "UPDATE partners_recurpayments SET recurpayments_amount = recurpayments_amount *  ? , " .
                " recurpayments_subsaleamount = recurpayments_subsaleamount *  ? ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation]);

            //partners_request
            $qry = "UPDATE partners_request SET request_amount = request_amount  *  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_track_revenue
            $qry = "UPDATE partners_track_revenue SET revenue_amount =revenue_amount   *  ? ";
            $ret[] = DB::update($qry, [$currRelation]);

            //partners_transaction
            $qry = "UPDATE partners_transaction SET transaction_amttobepaid = transaction_amttobepaid  *  ? , " .
                " transaction_amountpaid = transaction_amountpaid  *  ?, " .
                " transaction_subsale = transaction_subsale *  ? , " .
                " transaction_reverseamount = transaction_reverseamount *  ? , " .
                " transaction_adminpaid = transaction_adminpaid *  ? , " .
                " transaction_subsalepaid = transaction_subsalepaid *  ?  ";
            $ret[] = DB::update($qry, [$currRelation, $currRelation, $currRelation, $currRelation, $currRelation, $currRelation]);

            if (in_array('', $ret)) {
                return 3;
            }
        } else {

            return 2;
        }
    }
    // Function to get the client IP address
    public static function getIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public static function testMail($to, $subject, $body)
    {


        $from =     'info@searlco.net';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: " . $from;
        mail($to, $subject, $body, $headers) or die("mail error");
    }
    public static function sendMerchantMail($object, $eventName)
    {
        $data = DB::table('partners_adminmail')
            ->where('adminmail_eventname', '=', $eventName)
            ->first();
        $body = $data->adminmail_message;


        $body = str_replace("[mer_firstname]", $object->merchant_firstname, $body);
        $body = str_replace("[mer_lastname]", $object->merchant_lastname, $body);
        $body = str_replace("[mer_company]", $object->merchant_company, $body);
        $body = str_replace("[mer_email]", $object->login_email, $body);
        $body = str_replace("[mer_loginlink]", $object->merchant_url, $body);
        $body = str_replace("[mer_password]", $object->login_password, $body);

        $body = str_replace("[from]", '$object->admin_email', $body);
        $body = str_replace("[commission]", '$object->commission_amount', $body);
        $body = str_replace("[program]", '$object->program_url', $body);
        $body = str_replace("[type]", '$object->transaction_type', $body);
        $body = str_replace("[date]", '$object->transaction_dateoftransaction', $body);
        $body = str_replace("[today]", date('d:m:Y'), $body);

        $from =     'info@searlco.net';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: " . $from;
        mail('fasehahmedwork@gmail.com', $data->adminmail_subject, $body, $headers) or die("mail error");
    }
    public static function sendAffiliateMail($object, $eventName)
    {
        $data = DB::table('partners_adminmail')
            ->where('adminmail_eventname', '=', $eventName)
            ->first();
        $body = $data->adminmail_message;
        $body = str_replace("[aff_firstname]", $object->affiliate_firstname, $body);
        $body = str_replace("[aff_lastname]", $object->affiliate_lastname, $body);
        $body = str_replace("[aff_company]", $object->affiliate_company, $body);
        $body = str_replace("[aff_email]", $object->login_email, $body);
        $body = str_replace("[aff_loginlink]", $object->affiliate_url, $body);
        $body = str_replace("[aff_password]", $object->login_password, $body);

        $body = str_replace("[from]", '$object->admin_email', $body);
        $body = str_replace("[commission]", '$object->commission_amount', $body);
        $body = str_replace("[program]", '$object->program_url', $body);
        $body = str_replace("[type]", '$object->transaction_type', $body);
        $body = str_replace("[date]", '$object->transaction_dateoftransaction', $body);
        $body = str_replace("[today]", date('d:m:Y'), $body);

        $from =     'info@searlco.net';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: " . $from;
        mail('fasehahmedwork@gmail.com', $data->adminmail_subject, $body, $headers) or die("mail error");
    }

    public static function sendTransactionMail($object, $eventName)
    {
        $data = DB::table('partners_adminmail')
            ->where('adminmail_eventname', '=', $eventName)
            ->first();
        $body = $data->adminmail_message;

        $body = str_replace("[aff_firstname]", $object->affiliate_firstname, $body);
        $body = str_replace("[aff_lastname]", $object->affiliate_lastname, $body);
        $body = str_replace("[aff_company]", $object->affiliate_company, $body);
        $body = str_replace("[aff_email]", $object->login_email, $body);
        $body = str_replace("[aff_loginlink]", $object->affiliate_url, $body);
        $body = str_replace("[aff_password]", $object->login_password, $body);

        $body = str_replace("[mer_firstname]", $object->merchant_firstname, $body);
        $body = str_replace("[mer_lastname]", $object->merchant_lastname, $body);
        $body = str_replace("[mer_company]", $object->merchant_company, $body);
        $body = str_replace("[mer_email]", $object->login_email, $body);
        $body = str_replace("[mer_loginlink]", $object->merchant_url, $body);
        $body = str_replace("[mer_password]", $object->login_password, $body);

        $body = str_replace("[from]", '$object->admin_email', $body);
        $body = str_replace("[commission]", '$object->commission_amount', $body);
        $body = str_replace("[program]", '$object->program_url', $body);
        $body = str_replace("[type]", $object->transaction_type, $body);
        $body = str_replace("[date]", $object->transaction_dateoftransaction, $body);
        $body = str_replace("[today]", date('d:m:Y'), $body);

        $from =     'info@searlco.net';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: " . $from;
        mail('fareedrajpoot324@gmail.com', $data->adminmail_subject, $body, $headers) or die("mail error");
    }
}
