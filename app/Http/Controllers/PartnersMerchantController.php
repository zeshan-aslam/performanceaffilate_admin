<?php

namespace App\Http\Controllers;

use App\Models\PartnerIpStat;
use App\Models\PartnerMerchant;
use App\Models\PartnerOwnerIp;
use App\Models\PartnerProgram;
use App\Models\PartnersAffiliate;
use App\Models\PartnersJoinPgm;
use App\Models\PartnerTextOld;
use App\Models\ProgramAffiliate;
use App\Models\VerifyToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;

class PartnersMerchantController extends Controller
{
    public function getPartners(Request $request)
    {
        $affiliate_key = $request->header('Api-Key');
        // to check this key belongs to which program affliate
        $partner_affliate = PartnersAffiliate::where('affiliate_secretkey',$affiliate_key)->first();
        if ($partner_affliate) {
            // check if cache file exists for partner for today date  --affiliate_secretkey-af
            //  i.e  current date-1a2v3a4z5c6h7a8t9b0ots2c5ri00pt-af
            //  if file exists return json from file
            //  if file does not exists run process create a new cache file for today date and return response
            $filename = now()->toDateString().'--'.$affiliate_key.'-af.json';
            if (file_exists( public_path()."/affiliateFile/".$filename)){
                try
                {
                    $contents = File::get(public_path()."/affiliateFile/".$filename);

                    return response()->json(['data'=> json_decode($contents)] ,201);

                }
                catch (Illuminate\Contracts\Filesystem\FileNotFoundException $exception)
                {
                    return response()->json('File text is Not Readable form', 404);
                }
            }

            // to get the  PartnersJoinPgm record  check the affliate id
            $partner_join_pgms = PartnersJoinPgm::where('joinpgm_affiliateid',$partner_affliate->affiliate_id )
            // to check the merchant_status is approved
            ->whereHas('merchant',function($query){
                $query->where('merchant_status','approved');
            })
            // to check the program_status is active
            ->whereHas('program',function($query){
                $query->where('program_status','active');
            })
               // to check the joinpgm_status is approved
            ->where('joinpgm_status','approved')->get();



            //  check if partner programs is not null
            if($partner_join_pgms ){

                $links =[];
                $search_worlds =[];
                $search_records =[];
                foreach($partner_join_pgms as $partner_join_pgm){
                    // we go to the partners_text_old table to get the link
                    // to check the text_status is active
                    if(!is_null($partner_join_pgm->program->text)){

                        if ($partner_join_pgm->program->text->text_status  =='active') {
                            $link =  $partner_join_pgm->program->text->text_url;
                            //  replace the
                            $new_link = str_replace('{CLICKID}', 'LX-0000', $link);
                            // array_push($links, $new_link);
                            $search_world =   $partner_join_pgm->merchant->brands ?? $partner_join_pgm->merchant->brands;

                            if ($search_world !=="") {
                                array_push($search_records, (object) ['text_id'=>$partner_join_pgm->program->text->id,'word' => $search_world]);
                            }
                        }
                    }
                    // return response()->json('Partners text is Not found', 404);
                }
                // return $search_records;
                $this->createFile($search_records,$affiliate_key);
                    return response()->json(['data'=> $search_records] ,201);

            }

            return response()->json('Partners Pgm is Not Active', 404);
        } else {
            return response()->json('Token Error', 404);
        }
    }

    public function getTokens(Request $request)
    {
        // Fetch all  verify_tokens
        $data = VerifyToken::all();
        return response()->json(['Partners Merchant', 'data' => $data, 201]);
    }

    public function saveDetail(Request $request)
    {
        return  1;

        // take the ip and link
        $user_ip = $request->ip();
        $user_url = $request->url;

        // table partners_ipstats
        $affiliate_key = $request->header('Api-Key');
        // to check this key belongs to which program affliate
        $partner_affliate = PartnersAffiliate::where('affiliate_secretkey',$affiliate_key)->first();

        if(count($partner_affliate)  >0){
            // table name partners_owner_auid_ip
            // save the record againist the record

            $data = PartnerIpStat::create([
                'ownerid'=>	$partner_affliate->affiliate_id,
                'AUIDS'=>'',
                'ipid'=> $user_ip, 
            ]);          
          return response()->json(['Partners Merchant', 'data' => $data, 201]);
        }

        return response()->json(['messgage'=>'No user Found', 'data' => [], 400]);
    }

    public function createFile($data,$key){
        $yesterday = Carbon::yesterday();
        $old_file =$yesterday->toDateString().'--'.$key.'-af.json';
        // if old file exit of yesterday delete that file
        if (file_exists(public_path()."/affiliateFile/".$old_file)) {
            File::delete(public_path()."/affiliateFile/".$old_file);
        }

        //  creating new file
        $data = json_encode($data);
        $file = now()->toDateString().'--'.$key.'-af.json';
        $destinationPath=public_path()."/affiliateFile/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$data);
        return response()->download($destinationPath.$file);
      }
}
