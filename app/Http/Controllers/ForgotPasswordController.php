<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Mail;

/**
 * Description of ForgotPasswordController
 *
 * @author DavinDeol
 */
class ForgotPasswordController extends Controller {
    public function forgotPassword()
    {
        return view('ForgotPassword/forgotPassword');
    }
    public function submitForgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), ['email' => 'required|filled|max:127|exists:Users,email']);
        if (!$validator->fails()) {
            $email = $request->input('email');
            $token = str_random(20);
            $previousLinks = DB::select("SELECT * FROM PasswordResets WHERE email='$email'");
            
            if (!empty($previousLinks)) {
                DB::delete("DELETE FROM PasswordResets WHERE email='$email'");
            }
            
            DB::insert("INSERT INTO PasswordResets (email, token) VALUES ('$email', '$token')");
            Mail::send('Email.resetPassword', ['token' => $token], function ($m) use ($email) {
                $m->to($email)->subject("Password Reset Link");
            });
            $data = array();
            $data['title'] = "Reset Password Link Sent";
            return view('ForgotPassword/emailSent', compact('data'));
        } else {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
}
