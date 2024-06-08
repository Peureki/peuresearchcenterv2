<?php

namespace App\Http\Controllers;

use App\Models\SalvageableDropRate;
use Illuminate\Http\Request;

class SalvageableController extends Controller
{
    private function salvageableBuyOrSellPrice($sellOrderSetting){
        if ($sellOrderSetting == 'buy_price'){
            return 'salvageable_buy_price';
        } else {
            return 'salvageable_sell_price';
        }
    }
    public function salvageables($sellOrderSetting, $tax){

        $salvageableDropRates = SalvageableDropRate::join('salvageables', 'salvageable_drop_rates.salvageable_id', '=', 'salvageables.id')
        ->join('items as item', 'salvageable_drop_rates.item_id', '=', 'item.id')
        ->join('items as salvageable_item', 'salvageables.item_id', '=', 'salvageable_item.id')
        ->select(
            'salvageable_drop_rates.*',
            'salvageables.*',
            'item.*',
            'item.icon as item_icon',
            'item.name as item_name',
            'salvageable_item.name as salvageable_name',
            'salvageable_item.icon as salvageable_icon',
            'salvageable_item.buy_price as salvageable_buy_price',
            'salvageable_item.sell_price as salvageable_sell_price'
        )
        ->get()
        ->groupBy('salvageable_id');

        $salvageableDropRates = $salvageableDropRates->chunk(3); 
        //dd($salvageableDropRates);

        $salvageables = [];

        $copperFedValue = 0; 
        $runecraftersValue = 0;
        $silverFedValue = 0; 

        $salvageablePrice = $this->salvageableBuyOrSellPrice($sellOrderSetting); 

        // Chunk = same salvageable item list that includes 
        // => copperfed
        // => runecrafter's
        // => silver-fed
        // ie Glob of Ecto
        foreach ($salvageableDropRates as $salvageable){

            
            // Get drop info from each salvageable from each salvager
            // ie Glob of Ecto drops -> using Copper-Fed
            foreach ($salvageable as $drops){
                $value = 0;
                $subTotal = 0; 
                $fee = 0; 
                $name = '';
                $icon = '';

                // Get drop rates and details of those drops 
                // ie Pile of Crystalline Dust, Essence of Luck, etc
                foreach ($drops as $item){
                    
                    $value = ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
    
                    $subTotal += $value; 
    
                    $salvageKit = $item->category; 
                    $name = $item->salvageable_name;
                    $icon = $item->salvageable_icon; 
                }
                // Check what salvage kit is being used and apply appropiate fees
                switch ($salvageKit){
                    case "Copper-Fed":
                        $fee = 3; 
                        $copperFedValue = ($subTotal - $fee) - $drops[0][$salvageablePrice]; 
                        break;
                    case "Runecrafter's":
                        $fee = 30; 
                        $runecraftersValue = ($subTotal - $fee) - $drops[0][$salvageablePrice];
                        break; 
                    case "Silver-Fed":
                        $fee = 60; 
                        $silverFedValue = $subTotal - $fee - $drops[0][$salvageablePrice]; 
                        break;
                }
            }

            array_push($salvageables, [
                'name' => $name,
                'copperFedValue' => $copperFedValue,
                'runecraftersValue' => $runecraftersValue,
                'silverFedValue' => $silverFedValue, 
                'icon' => $icon, 
            ]);
        }

        

        $salvageableDropRates = $salvageableDropRates->values();

        $response = [
            'dropRates' => $salvageableDropRates, 
            'salvageables' => $salvageables, 
        ];

        return response()->json($response); 
    }
}
