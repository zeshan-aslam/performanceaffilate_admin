<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use PDO;
use GuzzleHttp\Client;
use PhpParser\Node\Expr\Cast\Object_;

class AwinHelper
{
    

    public static function getAdvertiser($id){
        $token='Bearer 8c6f4b5c-c66e-4a54-b610-6406504478e5';
        $client = new Client();
        $url = "https://api.awin.com/accounts?type=publisher";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'Authorization' => $token
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);
        $data = json_decode($response->getBody()->getContents());
        foreach($data->accounts as $row){
             if($row->accountId==$id && $row->accountType=='advertiser'){
                 return $row->accountName;

             }

        }
    }
    public static function getPublisher($id){
        $data=DB::table('networks')->where('networkId','=',(int)$id)->first();
        if(!empty($data)){
            return $data->name;

        }
        else{
            return "Unknown";
        }
       
       
    }
}