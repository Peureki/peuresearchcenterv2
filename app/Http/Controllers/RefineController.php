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
    public function refine($request, $requestID, $includes, $buyOrderSetting, $tax){
        //dd($request);

        // Make it a workable arrays
        $includes = json_decode($includes);
        // This is where bag_ids will be pushed depending on what exchangable item is being exchanged
        $requestedArray = []; 
        $response = [];
        $output = [];
        // Check if $request matches with one of the $map
        // Populate arrays
        if (isset($this->homesteadMap[$request])){
            $data = $this->homesteadMap[$request]; 
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
}
