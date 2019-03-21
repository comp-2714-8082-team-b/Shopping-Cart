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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    public function home()
    {
        $data = array();
        $data["title"] = "Home";
        $brandNames = DB::select("SELECT DISTINCT brandName FROM Item");
        $categories = DB::select("SELECT DISTINCT categoryName FROM Category");
        return view('home', compact('data', 'brandNames', 'categories'));
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
            $brands = InventoryController::arrayToMySQLFriendly(($request->input("brand", [''])));
            $categories = implode(",", $request->input("category", ['']));
            $sortBy = ($request->input("sortBy"));

            $sql = "SELECT DISTINCT i.modelNumber, i.itemName, i.itemPrice,
             i.salePrice, i.brandName, i.stockQuantity, i.description,
              GROUP_CONCAT(DISTINCT(c.categoryName) SEPARATOR ', ') as categories,
               GROUP_CONCAT(DISTINCT(p.imgUrl) SEPARATOR ', ') 
               as pictures FROM Item i JOIN Category c ON i.modelNumber = c.modelNumber 
               LEFT JOIN Picture p ON c.modelNumber = p.modelNumber 
               WHERE FIND_IN_SET(c.categoryName, ('$categories')) 
               AND (itemPrice BETWEEN $priceMin AND $priceMax) 
               AND (brandName IN ($brands)) GROUP BY i.modelNumber ORDER BY $sortBy LIMIT $index,10";

            //return $sql;
            $items = DB::select($sql);
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]->categories = explode(', ', $items[$i]->categories);
                $items[$i]->pictures = explode(', ', $items[$i]->pictures);
            }
            $result = "success";
            $responseData = view('item', compact('items'))->render();
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response()->json(['result' => $result, 'data' => $responseData ]);
    }
    
    public function inventory()
    {
        $data = array();
        $data["title"] = "Inventory";
        $items = DB::select("SELECT i.modelNumber, i.itemName, i.itemPrice, i.salePrice, i.brandName, i.stockQuantity, i.description, GROUP_CONCAT(c.categoryName SEPARATOR ', ') as categories FROM Item i JOIN Category c ON i.modelNumber = c.modelNumber GROUP BY i.modelNumber");
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->categories = explode(', ', $items[$i]->categories);
        }
        return view('inventory', compact('data', 'items', 'categories'));
    }
    
    public function itemForm($modelNumber = null)
    {
        $data = array();
        $data['title'] = "Item Form";
        
        if (!is_null($modelNumber)) {
            $item = DB::select("SELECT DISTINCT i.modelNumber, i.itemName, i.itemPrice, i.salePrice, i.brandName, i.stockQuantity, i.description, GROUP_CONCAT(DISTINCT(c.categoryName) SEPARATOR ', ') as categories, GROUP_CONCAT(DISTINCT(p.imgUrl) SEPARATOR ', ') as pictures FROM Item i LEFT JOIN Category c ON i.modelNumber=c.modelNumber JOIN Picture p ON i.modelNumber=p.modelNumber WHERE i.modelNumber='$modelNumber'")[0];
            $url = route("updateItem");
            $item->pictures = ($item->pictures) ? explode(', ', $item->pictures) : array();
        } else {
            $item = new \stdClass();
            $item->modelNumber = "";
            $item->itemName = "";
            $item->brandName = "";
            $item->itemPrice = "";
            $item->salePrice = "";
            $item->description = "";
            $item->stockQuantity = "";
            $item->categories = "";
            $item->pictures = array();
            $url = route("createItem");
        }
        $brandNames = DB::select("SELECT DISTINCT brandName FROM Item");
        $categories = DB::select("SELECT DISTINCT categoryName FROM Category");
        return view('Inventory/itemForm', compact('data', 'item', 'brandNames', 'categories', 'url'));
    }
    
    /**
     * 
     * @param Request $request - inputs passed from user
     * @return route back to item form if the submission was invalid or back to
     *          home page
     */
    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required|max:63|unique:Item,modelNumber',
                'itemName' => 'required|max:63',
                'brandName' => 'required|max:63',
                'categories' => 'required',
                'itemPrice' => 'required',
                'salePrice' => 'nullable|lt:itemPrice',
                'stockQuantity' => 'required',
                'description' => 'required',
                'files.*.*' => 'required|file|max:2000',
            ]
        );
        if (!$validator->fails()) {
            $pdo = DB::connection()->getPdo();
            $modelNumber = $pdo->quote($request->input("modelNumber"));
            $itemName = $pdo->quote($request->input("itemName"));
            $brandName = $pdo->quote($request->input("brandName"));
            $itemPrice = $pdo->quote($request->input("itemPrice"));
            $salePrice = (empty($request->input("salePrice"))) ? "NULL" : "'" . $request->input("salePrice") . "'";
            $stockQuantity = $pdo->quote($request->input("stockQuantity"));
            $description = $pdo->quote($request->input("description"));
            $categories = explode(",", $request->input("categories"));
            $sql = "INSERT INTO Item (modelNumber, itemName, brandName, itemPrice, salePrice, stockQuantity, description) VALUES ($modelNumber, $itemName, $brandName, $itemPrice, $salePrice, $stockQuantity, $description)";
            DB::insert($sql);
            
            if ($request->file('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = $file->store(null, 'public');
                    DB::insert("INSERT INTO Picture (imgUrl, modelNumber) VALUES ('$filename', $modelNumber)");
                }
            }
            foreach ($categories as $category) {
                if (!empty($category)) {
                    DB::insert("INSERT INTO Category (categoryName, modelNumber) VALUES ('$category', $modelNumber)");
                }
            }
            return redirect()->route('home');
        } else {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
    
    /**
     * 
     * @param Request $request - inputs passed from user
     */
    public function updateItem(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required|max:63',
                'formerModelNumber' => 'required|max:63|exists:Item,modelNumber',
                'itemName' => 'required|max:63',
                'brandName' => 'required|max:63',
                'categories' => 'required',
                'itemPrice' => 'required',
                'salePrice' => 'nullable|lt:itemPrice',
                'stockQuantity' => 'required',
                'description' => 'required',
                'files.*.*' => 'required|file|max:2000',
            ]
        );
        if (!$validator->fails()) {
            $pdo = DB::connection()->getPdo();
            $modelNumber = $pdo->quote($request->input("modelNumber"));
            $formerModelNumber = $pdo->quote($request->input("formerModelNumber"));
            $itemName = $pdo->quote($request->input("itemName"));
            $brandName = $pdo->quote($request->input("brandName"));
            $itemPrice = $pdo->quote($request->input("itemPrice"));
            $salePrice = (empty($request->input("salePrice"))) ? "NULL" : "'" . $request->input("salePrice") . "'";
            $stockQuantity = $pdo->quote($request->input("stockQuantity"));
            $description = $pdo->quote($request->input("description"));
            $categories = explode(",", $request->input("categories"));
            DB::update("UPDATE Item SET modelNumber=$modelNumber, itemName=$itemName, brandName=$brandName, itemPrice=$itemPrice, salePrice=$salePrice, stockQuantity=$stockQuantity, description=$description WHERE modelNumber=$formerModelNumber");
            $modelNumber = ($modelNumber == $formerModelNumber) ? $formerModelNumber : $modelNumber;
            if ($request->file('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = $file->store(null, 'public');
                    DB::insert("INSERT INTO Picture (imgUrl, modelNumber) VALUES ('$filename', $modelNumber)");
                }
            }
            DB::delete("DELETE FROM Category WHERE modelNumber=$modelNumber");
            foreach ($categories as $category) {
                if (!empty($category)) {
                    DB::insert("INSERT INTO Category (categoryName, modelNumber) VALUES ('$category', $modelNumber)");
                }
            }
            return redirect()->route('home');
        } else {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
    
    /**
     * @param Request $request - filePath
     */
    public function deleteFile(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'filePath' => 'required|exists:Picture,imgUrl',
            ]
        );
        if (!$validator->fails()) {
            $filePath = $request->input("filePath");
            if (Storage::disk('public')->delete($filePath)) {
                DB::delete("DELETE FROM Picture WHERE imgUrl='$filePath'");
            }
        }
    }
    
    public function deleteItem(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required|exists:Item,modelNumber',
            ]
        );
        if (!$validator->fails()) {
            $pdo = DB::connection()->getPdo();
            $modelNumber = $pdo->quote($request->input("modelNumber"));
            $pictures = DB::select("SELECT imgUrl FROM Picture WHERE modelNumber=$modelNumber");
            foreach ($pictures as $picture) {
                Storage::disk('public')->delete($picture->imgUrl);
            }
            DB::delete("DELETE FROM Item WHERE modelNumber=$modelNumber");
        } else {
            return $validator->errors()->messages();
        }
    }
}
