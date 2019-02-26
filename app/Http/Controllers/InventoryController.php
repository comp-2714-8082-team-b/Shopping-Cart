<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Description of Inventory
 *
 * @author DavinDeol
 */
class InventoryController {
    //put your code here
    public function inventoryPage()
    {
        return view('inventory');
    }
    
    public function getItems($index = '0')
    {
        $items = DB::select('');
        return view('item', compact('items'));
    }
}
