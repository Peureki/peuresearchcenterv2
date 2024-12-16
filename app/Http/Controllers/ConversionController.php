<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Items;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    // *
    // * CONVERSIONS
    // * Specifically conversions that are from vendors or 1 to 1 exchanges
    // * 

    // * 
    // * FISHMONGER
    // * Fish fillet conversions 
    // * 
    public function fishmonger($sellOrderSetting, $tax){

        $exchangeableFillets = [
            // 1 Fine Fish Fillet <- 1 Piece of Crustacean Meat
            ['result' => 96762, 'resultQty' => 1, 'exchangeable' => 97075, 'exchangeableQty' => 1],
            // 1 Fabulous Fish Fillet <- 5 Fine Fish Fillet
            ['result' => 97690, 'resultQty' => 1, 'exchangeable' => 96762, 'exchangeableQty' => 5],
            // 1 Flavorful Fish Fillet <- 5 Fabulous Fish Fillet
            ['result' => 96943, 'resultQty' => 1, 'exchangeable' => 97690, 'exchangeableQty' => 5],
            // 1 Fantastic Fish Fillet <- 5 Flavorful Fish Fillet
            ['result' => 95663, 'resultQty' => 1, 'exchangeable' => 96943, 'exchangeableQty' => 5],
            // 1 Flawless Fish Fillet <- 5 Fantastic Fish Fillet
            ['result' => 95673, 'resultQty' => 1, 'exchangeable' => 95663, 'exchangeableQty' => 5],
            // 1 Mackerel <- 5 Fine Fish Fillet
            ['result' => 95943, 'resultQty' => 1, 'exchangeable' => 96762, 'exchangeableQty' => 5],
            // 1 Chunk of Ambergris <- 10 Flawless Fillet
            ['result' => 96347, 'resultQty' => 1, 'exchangeable' => 95673, 'exchangeableQty' => 10]
        ];



        foreach ($exchangeableFillets as $fillet){
            $item = Items::where('id', $fillet['result'])->first(); 

            dd($item); 
            
            $fillet['sell_price'] = Items::where('id', $fillet['result'])->first()->sell_price; 
        };

        dd($exchangeableFillets);

        $results = [];
        $exchangeables = [];

        foreach ($this->exchangeableFillets as $key => $fillet) {
            $results[$key] = $fillet['result'];
            $exchangeables[$key] = $fillet['exchangeable'];
        }

        //dd($results);
        
        $resultsDB = Items::whereIn('id', $results)->get(); 
        $exchangeablesDB = Items::whereIn('id', $exchangeables)->get();

        //dd($results, $resultsDB, $exchangeablesDB);

        $response = [
            'results' => $resultsDB,
            'exchangeables' => $exchangeablesDB
        ];

        return response()->json($response);
    }
}
