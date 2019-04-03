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
use Illuminate\Validation\Rule;

/**
 * Description of Inventory
 *
 * @author DavinDeol
 */
class CartController extends Controller {
    private $canadaProvinces = ["Alberta","British Columbia","Manitoba","New Brunswick","Newfoundland and Labrador","Nova Scotia","Northwest Territories","Nunavut","Ontario","Quebec","Prince Edward Island","Saskatchewan", "Yukan"];
    private $usaStates = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];
    
    /**
     * 
     * @return cart page
     */
    public function cartPage()
    {
        $cartId = CartController::getCartId();
        $items = CartController::getItemsInCart($cartId);
        $taxes = DB::select("SELECT location, GROUP_CONCAT(taxName) as taxNames, GROUP_CONCAT(amountPercentage) as amountPercentage FROM `Taxes` GROUP BY location");
        for ($i = 0; $i < count($taxes); $i++) {
            $taxes[$i]->taxNames = explode(',', $taxes[$i]->taxNames);
            $taxes[$i]->amountPercentage = explode(',', $taxes[$i]->amountPercentage);
        }
        $canadaProvinces = $this->canadaProvinces;
        $usaStates = $this->usaStates;
        return view('cart', compact('itemsInCart', 'items', 'canadaProvinces', 'usaStates', 'taxes'));
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
                'modelNumber' => 'required|exists:Item,modelNumber',
                'quantity' => 'required',
            ]
        );
        if (!$validator->fails()) {
            $modelNumber = $request->input("modelNumber");
            $requestedQuantity = $request->input("quantity");
            $cartId = CartController::getCartId();
            $item = DB::select("SELECT * FROM Item WHERE modelNumber = $modelNumber LIMIT 1")[0];
            for ($i = 0; $i < min($requestedQuantity, $item->stockQuantity); $i++) {
                DB::insert("INSERT INTO CartToItem VALUES ('$cartId', '$modelNumber')");
            }
            $result = "success";
            $responseData = "Added $requestedQuantity $item->itemName to cart";
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response() ->json(['result' => $result, 'data' => $responseData]);
    }
    
    /**
     * Completely removes an item from the user's cart
     * @param Request $request - data passed from cart view
     */
    public function removeFromCart(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required|exists:Item,modelNumber'
            ]
        );
        if (!$validator->fails()) {
            $modelNumber = $request->input("modelNumber");
            $cartId = CartController::getCartId();
            $item = DB::select("SELECT itemName FROM Item i WHERE modelNumber='$modelNumber'")[0];
            if ($request->has("quantity")) {
                $quantity = $request->input("quantity");
                DB::delete("DELETE FROM CartToItem WHERE modelNumber = $modelNumber AND cartID = '$cartId' LIMIT $quantity");
                $responseData = "Removed $quantity $item->itemName"."s from your cart";
            } else {
                DB::delete("DELETE FROM CartToItem WHERE modelNumber = $modelNumber AND cartID = '$cartId'");
                $responseData = "Removed all the $item->itemName"."s from your cart";
            }
            $result = "success";
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
        return response() ->json(['result' => $result, 'data' => $responseData]);
    }
    
    public function changeQuantityInCart(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'modelNumber' => 'required|exists:Item,modelNumber',
                'quantity' => 'required',
            ]
        );
        if (!$validator->fails()) {
            $modelNumber = $request->input("modelNumber");
            $quantity = $request->input("quantity");
            $cartId = CartController::getCartId();
            $sql = "SELECT COUNT(*) as amountInCart FROM CartToItem WHERE cartID='$cartId' AND modelNumber='$modelNumber'";
            $response = DB::select($sql)[0];
            if ($response->amountInCart < $quantity) {
                $request->merge(['quantity' => ($quantity - $response->amountInCart)]);
                return CartController::addToCart($request);
            } else {
                $request->merge(['quantity' => ($response->amountInCart - $quantity)]);
                return CartController::removeFromCart($request);
            }
        } else {
            $result = "fail";
            $responseData = $validator->errors()->messages();
        }
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'country' => 'required|alpha',
                'stateOrProvince' => ['required', Rule::in(array_merge($this->canadaProvinces, $this->usaStates))],
                'city' => 'required|alpha',
                'streetAddress' => 'required',
                'postalCode' => 'required|alpha_num',
            ]
        );
        if (!$validator->fails()) {
            $cartId = CartController::getCartId();
            $items = CartController::getItemsInCart($cartId);
            foreach ($items as $item) {
                if ($item->quantity > $item->stockQuantity) {
                    return redirect()->back()->withInput($request->input())->withErrors([0 => "Sorry, we could not process order because the number of $item->itemName" . "s you have request is not available. At this time you can order at most $item->stockQuantity. You can also order again at another time when more stock is available."]);
                }
            }
            foreach ($items as $item) {
                DB::update("UPDATE Item i SET stockQuantity = stockQuantity - $item->quantity WHERE modelNumber='$item->modelNumber'");
            }
            $pdo = DB::connection()->getPdo();
            $address = $pdo->quote($request->input("streetAddress") . ", " . $request->input("city") . ", " . $request->input("stateOrProvince") . ", " . $request->input("country") . ", " . $request->input("postalCode"));
            $subtotal = CartController::getSubtotal($request->input("country") . "," . $request->input("stateOrProvince"));
            DB::update("UPDATE Cart SET purchaseDate=NOW(), deliverAddress=$address, estDeliveryDate=DATE_ADD(NOW(), INTERVAL 7 DAY), subTotal=$subtotal WHERE cartId='$cartId'");
            $estDeliveryDate = DB::select("SELECT DATE_FORMAT(estDeliveryDate, '%M %D, %Y') as estDeliveryDate FROM Cart")[0];
            return view("Cart/orderConfirmation", compact('subtotal', 'address', 'estDeliveryDate', 'items'));
        } else {
            $canadaProvinces = $this->canadaProvinces;
            $usaStates = $this->usaStates;
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
    
    /**
     * This function determines if the current user has a cart and if not,
     * creates it. It then returns the user's cart ID.
     * @return the number representing the current user's cart ID
     */
    public function getCartId()
    {
        $user = Auth::user();
        $cart = DB::select("SELECT * FROM Cart WHERE email='$user->email' AND purchaseDate IS NULL");
        if (!$cart) {
            DB::insert("INSERT INTO Cart (email) VALUES ('$user->email')");
            $cart = DB::select("SELECT * FROM Cart WHERE email='$user->email'");
        }
        
        return $cart[0]->cartId;
    }
    
    /**
     * Calculates the total price of all the items in the user's cart
     * @return total price of items in the user's cart
     */
    public function getTotal()
    {
        $cartId = CartController::getCartId();
        $sql = "SELECT SUM(IFNULL(i.salePrice, i.itemPrice)) as total FROM CartToItem ci JOIN Item i ON ci.modelNumber = i.modelNumber WHERE ci.cartID = '$cartId'";
        $total = DB::select($sql)[0];
        return $total->total;
    }
    
    /**
     * Calculates the total of all the items in the user's cart with taxes
     * @param type $location - used to determine what taxes must be implemented
     *                          into the calculation
     * @return total price of items in the user's cart
     */
    public function getSubtotal($location)
    {
        $total = CartController::getTotal();
        $sql = "SELECT * FROM Taxes WHERE location = '$location'";
        $taxes = DB::select($sql);
        $taxToApply = 1;
        foreach ($taxes as $tax) {
            $taxToApply += ($tax->amountPercentage / 100);
        }
        return round($total * $taxToApply, 2);
    }
    
    public function getItemsInCart($cartId)
    {
        $sql = "SELECT COUNT(*) as quantity FROM CartToItem WHERE cartID='$cartId' GROUP BY modelNumber";
        $quantities = DB::select($sql);
        $sql = "SELECT DISTINCT i.modelNumber, i.itemName, i.itemPrice, i.salePrice, i.brandName, i.stockQuantity, i.description, GROUP_CONCAT(DISTINCT(c.categoryName) SEPARATOR ', ') as categories, GROUP_CONCAT(DISTINCT(p.imgUrl) SEPARATOR ', ') as pictures, COUNT(*) as quantity FROM CartToItem ci "
                . "JOIN Item i ON ci.modelNumber = i.modelNumber "
                . "LEFT JOIN Category c ON i.modelNumber=c.modelNumber "
                . "LEFT JOIN Picture p ON i.modelNumber=p.modelNumber "
                . "WHERE ci.cartID='$cartId' GROUP BY ci.modelNumber";
        $items = DB::select($sql);
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->categories = explode(', ', $items[$i]->categories);
            $items[$i]->pictures = explode(', ', $items[$i]->pictures);
            $items[$i]->quantity = $quantities[$i]->quantity;
        }
        return $items;
    }
}
