<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // *
    // * FETCH ITEMS
    // * 
    // * @param array $requestArray 
    // * 
    // * $requestArray is a list of item IDs to be returned
    // * example from the front-end:
    // * const merp = [
    // *    96347, 99955,
    // * ]
    // * 
    // * RETURNS json $response
    // * 
    public function items($requestArray){
        $requestArray = json_decode($requestArray); 

        $items = Items::whereIn('id', $requestArray)->get();

        //dd($items);

        return response()->json($items);
    }
}
