<?php
////
//namespace App\Http\Controllers;
//
//use App\Mail\notification;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
//
//class MailingController extends Controller
//{
//    public function information(Request $request)
//    {
//        $destination ="";
//        $title ="";
//        $text = "";
//        $schedule="";
//
//        Mail::bcc($request->user())
//            ->later($schedule, new notification());
//    }
//}
