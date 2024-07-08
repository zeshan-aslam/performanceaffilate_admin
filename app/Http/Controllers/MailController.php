<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function SendEmail(){
        $details=[
            'Title'=>"Mail From SearlCo.net",
            'body'=>"This is Testing using gmail Acoount ",
        ];

        Mail::to("testsearlco@gmail.com")->send(new TestMail($details));
        return "Email Sent";
    }
}
