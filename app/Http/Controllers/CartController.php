<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // For getting POST request data
use Validator;
/**
 * Description of Inventory
 *
 * @author DavinDeol
 */
class CartController extends Controller {
    /**
     * 
     * @return cart page
     */
    public function cartPage()
    {
        $user = Auth::user();
        $data = array();
        $data["title"] = "Cart";
        $itemsInCart = DB::select("SELECT * FROM Cart WHERE email='$user->email'")[0];
        $itemsInCart = json_decode(json_encode($itemsInCart), true);

        return view('cart', compact('data', 'itemsInCart'));
    }

    /**
     *
     * @param Request $request - data passed from the inventory view
     * @return statement on whether the function worked, and a message to print
     *          to the user.
     */
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required',
                'requestedQuantity' => 'required',
            ]
        );
        if (!$validator->fails()) {
            $user = Auth::user();
            $modelNumber = $request->input("modelNumber");
            $requestedQuantity = $request->input("requestedQuantity");

            for ($i = 0; $i < $requestedQuantity; $i++) {
                $items = DB::insert("INSERT INTO Cart (email, modelNumber$i) VALUES ('$user->email', '$modelNumber')");
            }

            $itemName = DB::select("SELECT itemName FROM Item WHERE modelNumber = $modelNumber LIMIT 1")[0]->itemName;
            $result = "success";
            $responseData = "Added $requestedQuantity $itemName to cart";
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response() ->json(['result' => $result, 'data' => $responseData]);
    }

    public function checkout(){
      // Gather items from the cart.
      $user = Auth::user();
      $cart = DB::select("SELECT * FROM cartTable WHERE email = '$user->email'")[0];
      DB::insert("INSERT INTO Orders (email, modelNumber0, modelNumber1, modelNumber2, modelNumber3, modelNumber4, modelNumber5, modelNumber6, modelNumber7, modelNumber8, modelNumber9, deliveryAddress, estDeliveryDate) VALUES ($cart->email,
      $cart->modelNumber0,
      $cart->modelNumber1,
      $cart->modelNumber2,
      $cart->modelNumber3,
      $cart->modelNumber4,
      $cart->modelNumber5,
      $cart->modelNumber6,
      $cart->modelNumber7,
      $cart->modelNumber8,
      $cart->modelNumber9,
      'hello',
      '1970-01-01 00:00:01')");


      DB::delete("DELETE FROM cartTable WHERE email = 'davindeol@gmail.com'");
    }
}
