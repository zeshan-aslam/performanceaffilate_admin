<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Utilities\AwinHelper;
use App\Utilities\SiteHelper;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AwinController extends Controller
{

    private $token='Bearer 8c6f4b5c-c66e-4a54-b610-6406504478e5';
    public function __construct()
    {
        $this->middleware('auth');
  
    }
    public function index()
    {

        $client = new Client();
        $url = "https://api.awin.com/accounts?type=publisher";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'Authorization' => $this->token
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);
        $data = json_decode($response->getBody()->getContents());
        return view('network.awin.index', compact('data'));
    }
    public function account()
    {

        $client = new Client();
        $url = "https://api.awin.com/accounts?type=publisher";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'Authorization' => $this->token
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);
        $data = json_decode($response->getBody()->getContents());
        return view('network.awin.account', compact('data'));
    }
    public function program($id)
    {
        $data = array();
        $client = new Client();
        $url = "https://api.awin.com/publishers/$id/transactions/?startDate=2017-02-20T00%3A00%3A00&endDate=2017-02-21T01%3A59%3A59&timezone=UTC";
        $params = [
            //If you have any Params Pass here
        ];
        $headers = [
            'Authorization' => $this->token
        ];
        try {
            $response = $client->request('GET', $url, [
                // 'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);

            $data = json_decode($response->getBody()->getContents());
          return view('network.awin.program', compact('data'));
        } catch (\Exception $e) {
           // return $e->getMessage();
            return view('network.awin.program', compact('data'))->with('error',$e->getMessage());
        }

    }
    public function publisher($id)
    {
        return view('network.awin.publisher',compact('id'));
    }
    public function commissiongroup($id)
    {

    }
    public function awinTransaction(Request $request)
    {
        $data=$request->AwinTransactionPush;
        $transactionId=DB::table('awin_notification')->insertGetId(
            [
                'transactionId' => $data->transactionId,
                'transactionDate' => $data->transactionDate,
                'transactionCurrency'=>$data->transactionCurrency,
                'transactionAmount' => $data->transactionAmount,
                'affiliateId' => $data->affiliateId,
                'merchantId' => $data->merchantId,
                'groupId' => $data->	groupId,
                'bannerId' => $data->bannerId,
                'clickRef' => $data->clickRef,
                'clickThroughTime' => $data->clickThroughTime,
                'ip' => $data->ip,
                'commission' => $data->	commission,
                'clickTime' => $data->clickTime,
                'url' => $data->url,
                'phrase' => $data->phrase,
                'searchEngine' => $data->searchEngine,
            ]
        );
        if($transactionId){
            $date=date('Y-m-d h:i:s', time());
            foreach($data->commissionGroups as $row){
                $transactionId=DB::table('awin_commission')->insert(
                    [
                        'id' => $row->id,
                        'transactionId' => $transactionId,
                        'name' => $row->name,
                        'code'=>$row->code,
                        'description' => $row->description,
                        'created_at'=>$date
                     
                    ]
                );

            }
          
            foreach($data->products as $row){
                $transactionId=DB::table('awin_product')->insert(
                    [
                        'transactionId' => $transactionId,
                        'productName' => $row->productName,
                        'unitPrice' => $row->unitPrice,
                        'skuType' => $row->skuType,
                        'skuCode' => $row->skuCode,
                        'quantity' => $row->quantity,
                        'category' => $row->category,
                        'cgId' => $row->cgId,
                        'created_at'=>$date

                        
                     
                    ]
                );

            }

        }
     
        
    }
    public function notifications($id)
    {
        return view('network.awin.notifications' ,compact('id'));
    }
    public function getNotifications($id)
    {
        $data=DB::table('awin_transaction')
        ->where('affiliateId','=',$id)
        ->get();

        return response()->json(['data'=>$data]);
    }
    public function getProducts($id)
    {
        $data=DB::table('awin_product')
        ->where('transactionId','=',$id)

        ->get();

        return response()->json($data);
    }
    public function getCommissionGroups($id)
    {
        $data=DB::table('awin_commission')
        ->where('transactionId','=',$id)
        ->get();

        return response()->json($data);
    }
    public function transaction($id)
    {
        return view('network.awin.transaction' ,compact('id'));
    }
    public function getTransactions($id)
    {
        $data = array();
        $client = new Client();
        $url = "https://api.awin.com/publishers/$id/transactions/?startDate=2021-07-01T00%3A00%3A00&endDate=2021-07-30T01%3A59%3A59&timezone=UTC&dateType=validation&status=approved";
        $params = [
            //If you have any Params Pass here
        ];
        $headers = [
            'Authorization' => $this->token
        ];
        try {
            $response = $client->request('GET', $url, [
                // 'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);

            $data = json_decode($response->getBody()->getContents());
            $activity=new Activity();
            $activity->url=url()->current();
            $activity->ip=SiteHelper::getIp();
            $activity->user_id=Auth::id();
            $activity->type="Awin";
            $activity->country='';
            $activity->description='Awin Transaction Fetched';
            $activity->save();
          return response()->json(['data'=>$data]); 
        } catch (\Exception $e) {
           // return $e->getMessage();
           return response()->json(['data'=>$data]);        }
    }
    public function getFilteredTransactions(Request $request)
    {
        
        $data = array();
        $response=array();

        $client = new Client();    
           $url = "https://api.awin.com/publishers/$request->id/transactions/?startDate=".$request->startDate."T00%3A00%3A00&endDate=".$request->endDate."T01%3A59%3A59&timezone=$request->timezone&dateType=$request->dateType&status=$request->status";
           //$url = "https://api.awin.com/publishers/$request->id/transactions/?startDate=".$request->startDate."T00%3A00%3A00&endDate=".$request->endDate."T01%3A59%3A59";

        $params = [
            //If you have any Params Pass here
        ];
        $headers = [
            'Authorization' => $this->token
        ];
    //   $i=0;
    //     while(true){

    //         date("Y-m-d", strtotime("+".$i."month", $request->startdate));
    //         $i++;
    //         if(){

    //         }


    //     }
        
        try {
            $response = $client->request('GET', $url, [
                // 'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
                  $i=0;

            $data = json_decode($response->getBody()->getContents());
            $publisher=AwinHelper::getPublisher($request->id);
            
            foreach($data as $row){
                $data[$i]->publisher=$publisher;
                $i++;
            }
            $activity=new Activity();
            $activity->url=url()->current();
            $activity->ip=SiteHelper::getIp();
            $activity->user_id=Auth::id();
            $activity->type="Awin";
            $activity->country='';
            $activity->description='Awin Transaction Fetched';
            $activity->save();

          return response()->json($data); 

        } catch (\Exception $e) {
           // return $e->getMessage();
           return response()->json(['Error'=>substr($e->getMessage(),strpos($e->getMessage(),'description')+14,-3)]);       
         }

    }
    public function report($id)
    {
        return "Report View";

    }

    public function awinBackup()
    {

    }
}
