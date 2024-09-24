<?php

namespace App\Http\Controllers;

use App\Models\CopperFedSalvageableDropRate;
use App\Models\MixedSalvageableDropRate;
use App\Models\RunecraftersSalvageableDropRate;
use App\Models\SalvageableDropRate;
use App\Models\SilverFedSalvageableDropRate;
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

    public function mixedSalvageables($sellOrderSetting, $tax){
        $mixedSalvageableDropRates = MixedSalvageableDropRate::join('mixed_salvageables', 'mixed_salvageable_drop_rates.mixed_salvageable_id', '=', 'mixed_salvageables.id')
        ->join('items as item', 'mixed_salvageable_drop_rates.item_id', '=', 'item.id')
        ->join('items as salvageable_item', 'mixed_salvageables.id', '=', 'salvageable_item.id')
        ->select(
            'mixed_salvageables.*',
            'mixed_salvageable_drop_rates.*',
            'salvageable_item.*',
            'item.*',
            'item.icon as item_icon',
            'item.name as item_name',
            'item.buy_price as buy_price',
            'item.sell_price as sell_price',
            'salvageable_item.icon as salvageable_icon',
            'salvageable_item.name as salvageable_name',
            'salvageable_item.buy_price as salvageable_buy_price',
            'salvageable_item.sell_price as salvageable_sell_price',
        )
        ->get()
        ->groupBy('mixed_salvageable_id');

        $salvageables = [];
        $salvageablePrice = $this->salvageableBuyOrSellPrice($sellOrderSetting); 

        foreach ($mixedSalvageableDropRates as $salvageable){
            //dd($salvageable);

            $value = 0;
            $subTotal = 0; 
            $profit = 0;
            $fee = 0; 
            $name = '';
            $icon = '';

            foreach ($salvageable as $item){
                //dd($item);
                switch ($item->name){
                    case "Copper-Fed Salvage-o-Matic":
                        $fee = $item->drop_rate;
                        break;

                    case "Runecrafter's Salvage-o-Matic":
                        $fee = $item->drop_rate; 
                        break;

                    case "Silver-Fed Salvage-o-Matic":
                        $fee = $item->drop_rate; 
                        break;

                    default: 
                        $value = ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
                        break; 
                }
                
                $subTotal += $value - $fee; 

                $name = $item->salvageable_name;
                $icon = $item->salvageable_icon;  
            }

            $profit = $subTotal - ($salvageable[0][$salvageablePrice] * $tax);

            array_push($salvageables, [
                'name' => $name,
                'icon' => $icon,
                'profit' => $profit,
            ]);
        }

        $mixedSalvageableDropRates = $mixedSalvageableDropRates->values(); 

        $response = [
            'dropRates' => $mixedSalvageableDropRates, 
            'salvageables' => $salvageables, 
        ];

        return response()->json($response); 
    }

    public function salvageables($sellOrderSetting, $tax){
        $copperFedDropRates = CopperFedSalvageableDropRate::join('copper_fed_salvageables', 'copper_fed_salvageable_drop_rates.copper_fed_salvageable_id', '=', 'copper_fed_salvageables.id')
        ->join('items as item', 'copper_fed_salvageable_drop_rates.item_id', '=', 'item.id')
        ->join('items as salvageable_item', 'copper_fed_salvageables.id', '=', 'salvageable_item.id')
        ->select(
            'copper_fed_salvageables.*',
            'copper_fed_salvageable_drop_rates.*',
            'salvageable_item.*',
            'item.*',
            'item.icon as item_icon',
            'item.name as item_name',
            'item.buy_price as buy_price',
            'item.sell_price as sell_price',
            'salvageable_item.icon as salvageable_icon',
            'salvageable_item.name as salvageable_name',
            'salvageable_item.buy_price as salvageable_buy_price',
            'salvageable_item.sell_price as salvageable_sell_price',
        )
        ->get()
        ->groupBy('copper_fed_salvageable_id');

        $runecraftersDropRates = RunecraftersSalvageableDropRate::join('runecrafters_salvageables', 'runecrafters_salvageable_drop_rates.runecrafters_salvageable_id', '=', 'runecrafters_salvageables.id')
        ->join('items as item', 'runecrafters_salvageable_drop_rates.item_id', '=', 'item.id')
        ->join('items as salvageable_item', 'runecrafters_salvageables.id', '=', 'salvageable_item.id')
        ->select(
            'runecrafters_salvageables.*',
            'runecrafters_salvageable_drop_rates.*',
            'salvageable_item.*',
            'item.*',
            'item.icon as item_icon',
            'item.name as item_name',
            'item.buy_price as buy_price',
            'item.sell_price as sell_price',
            'salvageable_item.icon as salvageable_icon',
            'salvageable_item.name as salvageable_name',
            'salvageable_item.buy_price as salvageable_buy_price',
            'salvageable_item.sell_price as salvageable_sell_price',
        )
        ->get()
        ->groupBy('runecrafters_salvageable_id');

        $silverFedDropRates = SilverFedSalvageableDropRate::join('silver_fed_salvageables', 'silver_fed_salvageable_drop_rates.silver_fed_salvageable_id', '=', 'silver_fed_salvageables.id')
        ->join('items as item', 'silver_fed_salvageable_drop_rates.item_id', '=', 'item.id')
        ->join('items as salvageable_item', 'silver_fed_salvageables.id', '=', 'salvageable_item.id')
        ->select(
            'silver_fed_salvageables.*',
            'silver_fed_salvageable_drop_rates.*',
            'salvageable_item.*',
            'item.*',
            'item.icon as item_icon',
            'item.name as item_name',
            'item.buy_price as buy_price',
            'item.sell_price as sell_price',
            'salvageable_item.icon as salvageable_icon',
            'salvageable_item.name as salvageable_name',
            'salvageable_item.buy_price as salvageable_buy_price',
            'salvageable_item.sell_price as salvageable_sell_price',
        )
        ->get()
        ->groupBy('silver_fed_salvageable_id');

        // Make array to compare 
        $salvageKitData = array($copperFedDropRates, $runecraftersDropRates, $silverFedDropRates);

        //dd($salvageKitData);

        // Since getting the drop rates require making an ailias of 'salvageable_buy_price' or 'salvageable_sell_price', this func returns one of those according to the $sellOrderSetting by the user
        $salvageablePrice = $this->salvageableBuyOrSellPrice($sellOrderSetting); 

        // PUSH final data results in this
        $salvageableData = [];

        // PUSH final respones to both salvageable data and drop rates to be returned to the frontend
        $response = [];
        
        // $currentyKitIndex
        // 0 == Copper 
        // 1 == Runecrafter's
        // 2 == Silver
        foreach ($salvageKitData as $currentyKitIndex => $salvageKit){
            $copperFedValue = 0;
            $runecraftersValue = 0;
            $silverFedValue = 0;

            $index = 0;

            // Each salvageable is separated into groups that list their possible drop rates
            foreach ($salvageKit as $group){
                $itemSubValue = 0;
                $itemTotalValue = 0;
                $fee = 0; 
                $kit = 0;
                $currentSalvageable = $group[0]->salvageable_name; 
                $icon = $group[0]->salvageable_icon;

                $salvageableValue = $group[0]->$salvageablePrice;
                //dd($group);

                // Get total value of salvageable item using drop rates
                foreach ($group as $item){
                    //dd($item);
                    $itemSubValue = ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                    $itemTotalValue += $itemSubValue; 
                }

                // Get fee for each salvage kit
                switch ($currentyKitIndex){
                    case 0: 
                        $fee = 3; 
                        $kit = 'Copper-Fed';
                        $copperFedValue = ($itemTotalValue - $fee) - ($salvageableValue * $tax); 
                        $salvageableData[$index]['copperFedValue'] = $copperFedValue;
                        break;
                    case 1: 
                        $fee = 30; 
                        $kit = "Runecrafter's";
                        $runecraftersValue = ($itemTotalValue - $fee) - ($salvageableValue * $tax); 
                        $salvageableData[$index]['runecraftersValue'] = $runecraftersValue;
                        break;
                    case 2: 
                        $fee = 30;
                        $kit = 'Silver-Fed';
                        $silverFedValue = ($itemTotalValue - $fee) - ($salvageableValue * $tax); 
                        $salvageableData[$index]['silverFedValue'] = $silverFedValue;
                        break; 
                }

                $salvageableData[$index]['name'] = $currentSalvageable; 
                $salvageableData[$index]['icon'] = $icon; 

                $index++;
            }
            
        }
        
        //dd($salvageableData);

        $response = [
            'salvageables' => $salvageableData,
            'dropRates' => $salvageKitData
        ];

        return response()->json($response);

    }

    // public function salvageables($sellOrderSetting, $tax){
    //     $salvageableDropRates = SalvageableDropRate::join('salvageables', 'salvageable_drop_rates.salvageable_id', '=', 'salvageables.id')
    //     ->join('items as item', 'salvageable_drop_rates.item_id', '=', 'item.id')
    //     ->join('items as salvageable_item', 'salvageables.item_id', '=', 'salvageable_item.id')
    //     ->select(
    //         'salvageable_drop_rates.*',
    //         'salvageables.*',
    //         'item.*',
    //         'item.icon as item_icon',
    //         'item.name as item_name',
    //         'salvageable_item.name as salvageable_name',
    //         'salvageable_item.icon as salvageable_icon',
    //         'salvageable_item.buy_price as salvageable_buy_price',
    //         'salvageable_item.sell_price as salvageable_sell_price'
    //     )
    //     ->get()
    //     ->groupBy('salvageable_id');

    //     $salvageableDropRates = $salvageableDropRates->chunk(3); 
    //     //dd($salvageableDropRates);

    //     $salvageables = [];

    //     $copperFedValue = 0; 
    //     $runecraftersValue = 0;
    //     $silverFedValue = 0; 

    //     $salvageablePrice = $this->salvageableBuyOrSellPrice($sellOrderSetting); 

    //     // Chunk = same salvageable item list that includes 
    //     // => copperfed
    //     // => runecrafter's
    //     // => silver-fed
    //     // ie Glob of Ecto
    //     foreach ($salvageableDropRates as $salvageable){

            
    //         // Get drop info from each salvageable from each salvager
    //         // ie Glob of Ecto drops -> using Copper-Fed
    //         foreach ($salvageable as $drops){
    //             $value = 0;
    //             $subTotal = 0; 
    //             $fee = 0; 
    //             $name = '';
    //             $icon = '';

    //             // Get drop rates and details of those drops 
    //             // ie Pile of Crystalline Dust, Essence of Luck, etc
    //             foreach ($drops as $item){
                    
    //                 $value = ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
    
    //                 $subTotal += $value; 
    
    //                 $salvageKit = $item->category; 
    //                 $name = $item->salvageable_name;
    //                 $icon = $item->salvageable_icon; 
    //             }
    //             // Check what salvage kit is being used and apply appropiate fees
    //             switch ($salvageKit){
    //                 case "Copper-Fed":
    //                     $fee = 3; 
    //                     $copperFedValue = ($subTotal - $fee) - ($drops[0][$salvageablePrice] * $tax); 
    //                     break;
    //                 case "Runecrafter's":
    //                     $fee = 30; 
    //                     $runecraftersValue = ($subTotal - $fee) - ($drops[0][$salvageablePrice] * $tax);
    //                     break; 
    //                 case "Silver-Fed":
    //                     $fee = 60; 
    //                     $silverFedValue = ($subTotal - $fee) - ($drops[0][$salvageablePrice] * $tax); 
    //                     break;
    //             }
    //         }

    //         array_push($salvageables, [
    //             'name' => $name,
    //             'copperFedValue' => $copperFedValue,
    //             'runecraftersValue' => $runecraftersValue,
    //             'silverFedValue' => $silverFedValue, 
    //             'icon' => $icon, 
    //         ]);
    //     }

    //     $salvageableDropRates = $salvageableDropRates->values();

    //     $response = [
    //         'dropRates' => $salvageableDropRates, 
    //         'salvageables' => $salvageables, 
    //     ];

    //     return response()->json($response); 
    // }
}
