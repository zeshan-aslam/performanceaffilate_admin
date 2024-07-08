<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FetchAwinData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $countTrans=DB::table('partners_transactions')->count();
        $transCount=DB::table('transCount')->first();
        if ($transCount->countTrans > $countTrans) {
            $lastTransID=DB::table('partners_transactions')->max('transaction_id');
            DB::table('transCount')->where('id','=',1)
            ->update([
                'countTrans'=>$countTrans,
                'lastTransID'=>$lastTransID
            ]);
            $transactions=DB::table('partners_transactions')->where('transaction_id','=',$lastTransID)
            ->update([
                'countTrans'=>$countTrans,
                'lastTransID'=>$lastTransID
            ]);
            

        }
     
    }
}
