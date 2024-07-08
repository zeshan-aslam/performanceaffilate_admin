<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pgmStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
    }
    public function index()
    {
        $pgmstatus = 'inactive';
        if (empty($pgmstatus))
            $pgmstatus        = 'active';    //setting for status

        switch ($pgmstatus) {

            case 'inactive':        //waiting affiliates

                $pic         = "waiting";
                $sql         = " SELECT   * ";
                $sql         = $sql . " FROM partners_program ,partners_merchant ";
                $sql         = $sql . " WHERE program_status='inactive' and merchant_id=program_merchantid  order by merchant_firstname  ";
                break;


            case 'active':        //approved affiliates
                $pic         = "approved";
                $sql         = " SELECT   * ";
                $sql         = $sql . " FROM partners_program ,partners_merchant ";
                $sql         = $sql . " WHERE program_status='active' and merchant_id=program_merchantid order by merchant_firstname  ";
                break;
        }
        $PgmDetails = DB::select($sql);

        $pgmapprovel = DB::table('partners_program')
        ->where('program_status','active')
        ->count();

        $pgmwaiting = DB::table('partners_program')
        ->where('program_status','inactive')
        ->count();

        $merwaiting = DB::table('partners_merchant')
        ->where('merchant_status','waiting')
        ->count();

        $affwaiting = DB::table('partners_affiliate')
        ->where('affiliate_status','waiting')
        ->count();

        return view('pgmstatus.index', compact('PgmDetails','pgmapprovel','pgmwaiting','merwaiting','affwaiting'));
    }

    public function getpgm()
    {
        $pgmstatus = 'inactive';
        if (empty($pgmstatus))
            $pgmstatus        = 'active';    //setting for status

        switch ($pgmstatus) {

            case 'inactive':        //waiting affiliates

                $pic         = "waiting";
                $sql         = " SELECT   * ";
                $sql         = $sql . " FROM partners_program ,partners_merchant ";
                $sql         = $sql . " WHERE program_status='inactive' and merchant_id=program_merchantid  order by merchant_firstname  ";
                break;


            case 'active':        //approved affiliates
                $pic         = "approved";
                $sql         = " SELECT   * ";
                $sql         = $sql . " FROM partners_program ,partners_merchant ";
                $sql         = $sql . " WHERE program_status='active' and merchant_id=program_merchantid order by merchant_firstname  ";
                break;
        }
        $PgmDetails = DB::select($sql);
        
      

        return response()->json(['data' => $PgmDetails]);
    }

public function GetLinks(Request $request)
    {

        $wait = array();
        $approvel = array();

        $pgms = DB::table("partners_program")->where('program_status','active')->get();
        if(count($pgms)>0){

        $i=0;
    foreach($pgms as $row){
        $stat[$i]['program_id'] =$row->program_id;
        $stat[$i]['program_url'] =$row->program_url;
		$stat[$i]['program_status'] =$row->program_status;
        $wait[0] = DB::table('partners_product')->where('prd_programid', $row->program_id)
        ->where('prd_status', 'inactive')
        ->count();

    $approvel[0] = DB::table('partners_product')->where('prd_programid', $row->program_id)
        ->where('prd_status', 'active')
        ->count();
        $stat[$i]['prd_w'] =$wait[0];
        $stat[$i]['prd_a'] =$approvel[0];


    $wait[1] = DB::table('partners_banner')->where('banner_programid', $row->program_id)
        ->where('banner_status', 'inactive')
        ->count();

    $approvel[1] = DB::table('partners_banner')->where('banner_programid', $row->program_id)
        ->where('banner_status', 'active')
        ->count();
        $stat[$i]['banner_w'] =$wait[1];
        $stat[$i]['banner_a'] =$approvel[1];

    $wait[2] = DB::table('partners_text_old')->where('text_programid', $row->program_id)
        ->where('text_status', 'inactive')
        ->count();

    $approvel[2] = DB::table('partners_text_old')->where('text_programid', $row->program_id)
        ->where('text_status', 'active')
        ->count();
        $stat[$i]['text_w'] =$wait[2];
        $stat[$i]['text_a'] =$approvel[2];

    $wait[3] = DB::table('partners_popup')->where('popup_programid', $row->program_id)
        ->where('popup_status', 'inactive')
        ->count();

    $approvel[3] = DB::table('partners_popup')->where('popup_programid', $row->program_id)
        ->where('popup_status', 'active')
        ->count();
        $stat[$i]['popup_w'] =$wait[3];
        $stat[$i]['popup_a'] =$approvel[3];

    $wait[4] = DB::table('partners_flash')->where('flash_programid', $row->program_id)
        ->where('flash_status', 'inactive')
        ->count();

    $approvel[4] = DB::table('partners_flash')->where('flash_programid', $row->program_id)
        ->where('flash_status', 'active')
        ->count();

        $stat[$i]['flash_w'] =$wait[4];
        $stat[$i]['flash_a'] =$approvel[4];

    $wait[5] = DB::table('partners_html')->where('html_programid', $row->program_id)
        ->where('html_status', 'inactive')
        ->count();

    $approvel[5] = DB::table('partners_html')->where('html_programid', $row->program_id)
        ->where('html_status', 'active')
        ->count();

        $stat[$i]['html_w'] =$wait[5];
        $stat[$i]['html_a'] =$approvel[5];

    $wait[6] = DB::table('partners_upload')->where('upload_programid', $row->program_id)
        ->where('upload_status', 'inactive')
        ->count();

    $approvel[6] = DB::table('partners_upload')->where('upload_programid', $row->program_id)
        ->where('upload_status', 'active')
        ->count();

        $stat[$i]['upload_w'] =$wait[6];
        $stat[$i]['upload_a'] =$approvel[6];
        session(['Pid'=>$row->program_id]);
        $mercompany = DB::table('partners_merchant', 'm')
        ->join('partners_program as p',function($join){
        $join->on( 'm.merchant_id', '=', 'p.program_merchantid')
        ->where('p.program_id','=',session('Pid'));
        })
        ->select('m.*')->first();
        if($mercompany){
        $stat[$i]['merchant'] =$mercompany->merchant_company;
        }else{
            $stat[$i]['merchant'] ='no Merchent';
        }
    $wait[8] = DB::table('partners_affiliate')
        ->where('affiliate_status', 'inactive')
        ->get();
        $stat[$i]['affiliate'] =$wait[8];

        $i++;
    }
    return response()->json(['data' => $stat]);
}
else{
    $stat=array();
    return response()->json(['data' => $stat]);
}
}

    public function approvePgm()
    {
      //  $sql = "UPDATE partners_program SET program_status='active' WHERE program_status = 'inactive' ";
                $prginactive = DB::table('partners_program')
                ->where('program_status','inactive')
                ->update(['program_status' => 'active']);

                return redirect()->route('PGMStatus.index')->with("danger", "Sorry, no program(s) found");

    }
    public function rejectPgm(){

       // $sql = "UPDATE partners_program SET program_status='inactive' WHERE program_status = 'active' ";
        $prginactive = DB::table('partners_program')
        ->where('program_status','active')
        ->update(['program_status' => 'inactive']);

        return redirect()->route('PGMStatus.index');

    }

    public function approveMerchants(){
    // $sql = "UPDATE partners_merchant SET merchant_status='approved' WHERE merchant_status = 'waiting' ";
        $merapprove = DB::table('partners_merchant')
                ->where('merchant_status','waiting')
                ->update(['merchant_status' => 'approved']);
      return redirect()->route('PGMStatus.index');

    }

    public function approveAffiliates(){
    //  $sql = "UPDATE partners_affiliate SET affiliate_status='approved' WHERE affiliate_status = 'waiting' ";
            $merapprove = DB::table('partners_affiliate')
            ->where('affiliate_status','waiting')
            ->update(['affiliate_status' => 'approved']);

            return redirect()->route('PGMStatus.index');
    }
    public function rejectMerchants(){
        
        $sql = "SELECT merchant_id AS id FROM partners_merchant WHERE merchant_status = 'waiting'";
        $merapprove=DB::select($sql);
       
        if($merapprove>0){
            foreach($merapprove as $row){
                $id = $row->id;
    
                 $sql1=DB::table('partners_login')->where('login_id',$id)->where('login_flag','m')->delete();

            }
        $sql1=DB::table('partners_merchant')->where('merchant_status','waiting')->delete();

        return redirect()->route('PGMStatus.index');

        }
        }
    public function rejectAffiliates(){

        $sql = "SELECT affiliate_id AS id FROM partners_affiliate WHERE affiliate_status = 'waiting'";
        $affapprove=DB::select($sql);
        if($affapprove>0){
            foreach($affapprove as $row){
                $id = $row->id;
                $sql1=DB::table('partners_login')->where('login_id',$id)->where('login_flag','a')->delete();
         }
            $sql1=DB::table('partners_affiliate')->where('affiliate_status','waiting')->delete();

            return redirect()->route('PGMStatus.index');

        }
    

    }

    public function waitMerchants(){
       
        $sql   =  "SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant where merchant_status like ('waiting')";
        $waitmer=DB::select($sql);
    
       
        return response()->json(['data' => $waitmer]);

        
        }
        public function waitAffiliate(){
       
            $sql   =  "SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate where affiliate_status like ('waiting')";
            $waitaffiliate=DB::select($sql);
        
           
            return response()->json(['data' => $waitaffiliate]);
    
            
            }

}




