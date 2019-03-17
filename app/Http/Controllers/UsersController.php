<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Http\Request;
/**
 * Description of UsersController
 *
 * @author DavinDeol
 */
class UsersController extends Controller {
    /**
     * 
     * @return the page where the administrator updates or deletes users
     */
    public function manageUsersPage()
    {
        $data = array();
        $data['title'] = "Manage Users";
        
        $users = DB::select("SELECT * FROM Users");
        
        return view('Admin/manageUsers', compact('data', 'users'));
    }
    
    /**
     * 
     * @param Request $request - data passed from user
     * @return whether or not the function worked and what message to display
     */
    public function updateUser(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|filled|email|max:127|exists:Users,email',
                'userName' => 'required|filled|min:6|max:63',
                'firstName' => 'required|filled|min:1|max:63|alpha',
                'lastName' => 'present',
                'type' => 'required|exists:Users,type'
            ]
        );
        if (!$validator->fails()) {
            $email = $request->input("email");
            $username = $request->input("userName");
            $firstName = $request->input("firstName");
            $lastName = $request->input("lastName");
            $type = $request->input("type");
            DB::update("UPDATE Users SET "
                    . "userName='$username', "
                    . "firstName='$firstName', "
                    . "lastName='$lastName', "
                    . "type='$type', "
                    . "updated_at=NOW()"
                    . "WHERE email='$email'");
            $result = "success";
            $responseData = "Updated $firstName's information";
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response() ->json(['result' => $result, 'data' => $responseData]);
    }
}
