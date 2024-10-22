<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function show(){
        return response()->json(['message' => 'Verify your email address']); 
    }

    public function verifyEmail(EmailVerificationRequest $request){
        $request->fulfill(); 

        return response()->json(['message' => 'Email verification successful! CONGRATS. YOU ARE NOW A CERTIFIED CHOYA']);
    }

    public function resendEmail(Request $request){
        $request->user()->sendEmailVerificationNotification(); 

        return response()->json(['message' => 'Verification link sent!']);
    }
}
