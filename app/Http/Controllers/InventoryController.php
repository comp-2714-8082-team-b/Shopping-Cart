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
class InventoryController extends Controller {

    function arrayToMySQLFriendly($array)
    {
        for ($i = 0; $i < sizeof($array); $i++) {
            $array[$i] = "'" . $array[$i] . "'";
        }
        $array = join(', ', $array);
        return $array;
    }

    /**
     *
     * @return inventory HTML page
     */
    public function inventoryPage()
    {
        $data = array();
        $data["title"] = "Inventory";
        return view('inventory', compact('data'));
    }

    /**
     *
     * @param Request $request - POST request data from form
     * @param type $index - the number of the first row we want. Without this,
     *                      the function will return the first 'x' rows.
     * @return type
     */
    public function getItems(Request $request, $index = 0)
    {
        $validator = Validator::make($request->all(),
            [
                'priceMin' => 'min:0|max:9999.99',
                'priceMax' => 'gte:priceMin|min:0|max:9999.99',
            ]
        );
        if (!$validator->fails()) {
            $priceMin = ($request->input("priceMin") !== null) ? $request->input("priceMin") : 0;
            $priceMax = ($request->input("priceMax") !== null) ? $request->input("priceMax") : 9999.99;
            $brands = InventoryController::arrayToMySQLFriendly($request->input("brand", ['']));
            $categories = InventoryController::arrayToMySQLFriendly($request->input("category", ['']));
            $items = DB::select("SELECT * FROM Item JOIN Category ON Item.modelNumber = Category.modelNumber 
            WHERE (category IN ($categories)) AND (itemPrice BETWEEN $priceMin AND $priceMax) AND (brandName IN ($brands)) LIMIT $index,10");
            $result = "success";
            $responseData = view('item', compact('items'))->render();
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response()->json(['result' => $result, 'data' => $responseData ]);
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
            $modelNumber = $request->input("modelNumber");
            $requestedQuantity = $request->input("requestedQuantity");

            for ($i = 0; $i < $requestedQuantity; $i++) {
                $items = DB::insert("INSERT INTO cartTable (email, modelNumber0) VALUES ('davindeol@gmail.com', '$modelNumber')");
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

    public function cart()
    {
        $data = array();
        $data["title"] = "Cart";
        return view('cart', compact('data'));
    }

    public function checkout(){
      // Gather items from the cart.
      $cart = DB::select("SELECT * FROM cartTable WHERE email = 'davindeol@gmail.com'")[0];
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
