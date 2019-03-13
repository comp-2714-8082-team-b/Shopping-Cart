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
}
