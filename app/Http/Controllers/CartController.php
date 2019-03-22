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
        $cart = DB::select("SELECT * FROM Cart WHERE email='$user->email'");
        if (!$cart) {
            DB::insert("INSERT INTO Cart (email) VALUES ('$user->email')");
            $cart = DB::select("SELECT * FROM Cart WHERE email='$user->email'");
        }
        $cartId = $cart[0]->cartId;
        $items = DB::select ("SELECT DISTINCT i.modelNumber, i.itemName, i.itemPrice, i.salePrice, i.brandName, i.stockQuantity, i.description, GROUP_CONCAT(DISTINCT(c.categoryName) SEPARATOR ', ') as categories, GROUP_CONCAT(DISTINCT(p.imgUrl) SEPARATOR ', ') as pictures FROM CartToItem ci "
                . "JOIN Item i ON ci.modelNumber = i.modelNumber "
                . "LEFT JOIN Category c ON i.modelNumber=c.modelNumber "
                . "JOIN Picture p ON i.modelNumber=p.modelNumber "
                . "WHERE ci.cartID='$cartId' GROUP BY ci.modelNumber");

        return view('cart', compact('itemsInCart', 'items'));
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
      return __METHOD__;
    }
}
