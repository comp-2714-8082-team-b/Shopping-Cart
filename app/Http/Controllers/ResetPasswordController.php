<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Description of ResetPasswordController
 *
 * @author DavinDeol
 */
class ResetPasswordController extends Controller {
    public function resetPassword($token) {
        $data = array();
        $data['title'] = "Reset Password";
        if (empty(DB::select("SELECT * FROM PasswordResets WHERE token='$token'"))) {
            return redirect()->route('home');
        } else {
            return view('ResetPassword/resetPassword', compact('data', 'token'));
        }
    }
    public function submitResetPassword(Request $request, $token) {
        $validator = \Validator::make($request->all(),
            [
                'newPassword' => 'required|same:confirmationPassword',
                'confirmationPassword' => 'required'
            ]
        );

        if (!$validator->fails()) {
            $password = Hash::make($request->input("newPassword"));
            $user = DB::select("SELECT * FROM PasswordResets WHERE token='$token'");
            if (!empty($user)) {
                $email = $user[0]->email;
                DB::update("UPDATE Users SET password='$password' WHERE email='$email'");
                DB::delete();
            }
            return redirect()->route('login');
        } else {
            return $validator->errors()->messages();
        }
    }
}
