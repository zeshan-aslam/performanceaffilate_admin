<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use \App\Mail\testMail;
use Illuminate\Support\Facades\DB;

class TestmailController extends Controller
{
    public function mailsend()
    {
        $details=DB::table('partners_adminmail')
        ->where('adminmail_eventname','=','Reverse Transaction')
        ->first();

    Mail::to('fasehahmedwork@gmail.com')->send(new testMail($details));
   	return view('Emails.thanks');
    }
}
