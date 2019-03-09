<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Support\Facades\Hash;

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
        return view('forgotPassword', compact('data'));
    }
    public function submitForgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required',
            ]
        );
        if (!$validator->fails()) {
            $email = $request->input('email');
            $user = DB::select("SELECT * FROM Users WHERE email='$email'");
            if (empty($user)) {
                return "User does not exists";
            } else {
                return "User exists";
            }
        } else {
            return $validator->errors()->messages();
        }
    }
}
