<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class RefineController extends Controller
{
    // Upon user's request, convert requested items into readable values
    // Ex: Elder wood Log => 1 Homstead Wood Plank
    // Showcase the cost/value it takes 
    //
    // Use $buyOrderSetting instead of sell since would buy materials then refine
    // 
    // @param int $request - Name of the refinementMap 
    // @param int $requestID - ID of the output item
    //
    // @return array $response 
    // 1) exchangeables
    // 2) output
    // 
    public function refine($request, $requestID, $buyOrderSetting, $tax){
        //dd($request);

        // This is where bag_ids will be pushed depending on what exchangable item is being exchanged
        $requestedArray = []; 
        $response = [];
        $output = [];
        // Check if $request matches with one of the $map
        // Populate arrays
        if (isset($this->refinementMap[$request])){
            $data = $this->refinementMap[$request]; 
            $requestedArray = array_merge($requestedArray, $data['id']);
            $conversionRate = $data['conversionRate'];
            $outputQty = $data['outputQty'];
        }

        

        $exchangeables = Items::whereIn('id', $requestedArray)->get()->groupBy('id'); 
        $outputItem = Items::where('id', $requestID)->get();

        $orderedResults = [];

        // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
        // This is to match the conversionRates and fees
        foreach ($requestedArray as $id){
            if (isset($exchangeables[$id])){
                $orderedResults[$id] = $exchangeables[$id];
            }
        }

        //dd($orderedResults); 
        // Make the indexes reset to 0, 1, 2, etc instead of the item IDs
        $exchangeables = array_values($orderedResults);
        
        // Remove the extra layer from groupBy
        foreach ($exchangeables as $index => $exchangeable){
            $exchangeables[$index] = $exchangeable->first();
        }

        foreach ($exchangeables as $index => $exchangeable){
            $value = ($exchangeable->$buyOrderSetting * $conversionRate[$index]) / $outputQty[$index]; 

            $name = $outputItem[0]->name; 
            $icon = $outputItem[0]->icon;
            $rarity = $outputItem[0]->rarity;
            
            $exchangeable->qty = $conversionRate[$index];

            array_push($output, [
                'name' => $name,
                'icon' => $icon, 
                'rarity' => $rarity,
                'qty' => $outputQty[$index], 
                'value' => $value, 
            ]);
        }

        $response = [
            'exchangeables' => $exchangeables, 
            'output' => $output,
        ];
        //dd($response);

        return response()->json($response);
    }

    // *
    // * EXCHANGE ITEMS
    // * For single item converion/refinements/exchanges to another item
    // * 
    // * EXAMPLE: 5 Fine Fish Fillet -> 1 Fabulous Fish Fillet
    // * 
    // * @param json $request 
    // * @param string $sellOrderSetting - buy_price or sell_price
    // * @param int $tax - TP tax 
    // * THE REQUEST JSON NEEDS TO HAVE THE FOLLOWING PROPERTIES: 
    // * {
    // *    resultID: int
    // *    resultQty: int 
    // *    exchangeableID: int
    // *    exchangeableQty: int
    // * }
    // * RETURN WILL PRODUCE NEW PROPERTIES
    // * {
    // *    resultValue: int 
    // *    exchangeableValue: int 
    // *    exchangeValue: int - value of the exchange (+/-)
    // * 
    public function exchange($request, $sellOrderSetting, $tax){
        $request = json_decode($request); 

        $response = []; 

        foreach ($request as $index => $exchange){
            // RESULTS
            $resultDB = Items::where('id', $exchange->resultID)->first(); 
            $resultValue = ($resultDB->$sellOrderSetting * $tax) * $exchange->resultQty; 
            // Insert new properties
            $exchange->resultValue = $resultValue;
            $exchange->resultName = $resultDB->name; 
            $exchange->resultIcon = $resultDB->icon; 

            // EXCHANGEABLE
            $exchangeableDB = Items::where('id', $exchange->exchangeableID)->first();
            $exchangeableValue = ($exchangeableDB->$sellOrderSetting * $tax) * $exchange->exchangeableQty;  
            // Insert new properties
            $exchange->exchangeableValue = $exchangeableValue;
            $exchange->exchangeableName = $exchangeableDB->name; 
            $exchange->exchangeableIcon = $exchangeableDB->icon; 

            // EXCHANGE VALUE
            // Insert new property
            $exchange->exchangeValue = $resultValue - $exchangeableValue;   

            $response[] = $exchange; 
        }

        return response()->json($response); 
    }
}
