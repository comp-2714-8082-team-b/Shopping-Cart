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
        $data = array();
        $data['title'] = "Forgot Password";
        return view('ForgotPassword/forgotPassword', compact('data'));
    }
    public function submitForgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), ['email' => 'required']);
        if (!$validator->fails()) {
            $email = $request->input('email');
            $user = DB::select("SELECT * FROM Users WHERE email='$email'");
            if (empty($user)) {
                return "User does not exists";
            } else {
                $user = $user[0];
                $token = str_random(20);
                DB::insert("INSERT INTO PasswordResets (email, token) VALUES ('$email', '$token')");
                Mail::send('Email.resetPassword', ['token' => $token], function ($m) use ($user) {
                    $m->to($user->email, $user->firstName . " " . $user->lastName)->subject("Password Reset Link");
                });
                $data = array();
                $data['title'] = "Reset Password Link Sent";
                return view('ForgotPassword/emailSent', compact('data'));
            }
        } else {
            return $validator->errors()->messages();
        }
    }
}
