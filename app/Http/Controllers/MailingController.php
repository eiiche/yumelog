<?php

namespace App\Http\Controllers;

use App\Mail\notification;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function information(Request $request){
        $destination ="";
        $title ="";
        $text = "";
        $schedule="";



        Mail::to($request->user())
            ->bcc($evenMoreUsers)
            ->later($schedule, new notification());


    }
}
