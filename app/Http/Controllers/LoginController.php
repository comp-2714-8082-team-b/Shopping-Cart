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
use App\User as User;

/**
 * Description of LoginController
 *
 * @author DavinDeol
 */
class LoginController extends Controller {
    
    /**
     * 
     * @return login view
     */
    public function login()
    {
        $data = array();
        $data["title"] = "Login";
        return view('login', compact('data'));
    }
    
    /**
     * This method takes the user's entered email and passwords and tests to see
     * if they're valid. If they are then it returns the name of the user,
     * otherwise it'll return false.
     * 
     * @param request -Stores the form data
     * @returns whether or not the user was valid
     */
    public function submitLogin(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|email|max:127',
                'password' => 'required'
            ]
        );

        if (!$validator->fails()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->input('rememberMe'))) {
                Auth::login(User::find($request->input('email')));
                return redirect()->route('home');
            } else {
                return redirect()->back()->withInput($request->input())->withErrors([0 => "Invalid login"]);
            }
        } else {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
    
    /**
     * 
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
