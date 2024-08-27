<?php

namespace App\Http\Controllers;

use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use App\Models\Items;
use App\Models\MapBenchmarkDropRate;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{
    public function maps($includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        $includes = json_decode($includes); 

        $mapDropRates = MapBenchmarkDropRate::join('map_benchmarks as map', 'map_benchmark_drop_rates.map_benchmark_id', '=', 'map.id')
        ->leftjoin('items as item', 'map_benchmark_drop_rates.item_id', '=', 'item.id')
        ->leftjoin('currencies as currency', 'map_benchmark_drop_rates.currency_id', '=', 'currency.id')
        ->select(
            'map.*',
            'map.name as map_name',
            'map.type as map_type',
            'item.*',
            'item.description as item_description',
            'item.id as item_id',
            'item.name as item_name',
            'item.icon as item_icon',
            'currency.*',
            'currency.icon as currency_icon',
            'currency.name as currency_name',
            'map_benchmark_drop_rates.*',
        )
        //->where('map_benchmark_id', 51)
        ->get()
        ->groupBy('map_benchmark_id'); 

        //dd($mapDropRates);

        $mapBenchmark = []; 
        $response = []; 

        foreach ($mapDropRates as $group){

            //dd($group);

            $gph = 0;
            $time = $group[0]->time;
            $type = $group[0]->map_type;
            $map = $group[0]->map_name;
            $sampleSize = $group[0]->sample_size;
            $latestRun = $group[0]->latest_run;

            $itemValue = 0;
            $currentHighestValue = 0; 
            $mostValuedItem = '';
            $mostValuedIcon = '';

            $total = 0;

            foreach ($group as $item){
                //dd($item);
                

                // if ($item->item_name == 'Dragonite Ore'){
                //     dd($item);
                // }

                
                // If the drop rate is 0, then skip to the next item
                if ($item->drop_rate == 0){
                    continue;
                } 
                // RAW CURRENCIES
                else if ($item->currency_id) {
                    $itemValue = $this->getCurrencyValue($item->currency_id, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                }
                // COMMENDATIONS (DWC)
                else if ($item->type == 'Trophy' && strpos($item->item_name, 'Commendation')){
                    $itemValue = $this->getCommendationValue($item->item_id, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                }
                // CONSUMABLES
                else if ($item->type === 'Consumable' && strpos($item->item_description, 'volatile magic') 
                || strpos($item->item_description, 'Volatile Magic')
                || strpos($item->item_description, 'unbound magic')){
                    $itemValue = $this->getConsumableValue($item->item_id, $item->drop_rate, $includes, $sellOrderSetting, $tax); 
                }

                else {
                    // JUNK ITEMS
                    if ($item->rarity == 'Junk'){
                        $itemValue = $item->vendor_value * $item->drop_rate;   
                    }
                    // UNIDENTIFIED GEAR
                    else if (strpos($item->item_name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                        $itemValue = $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                    } 
                    // CHAMP BAGS, CONTAINERS
                    else if ($item->type == "Container" && strpos($item->item_description, 'Salvage') === false){
                        $itemValue = ($this->getContainerValue($item->item_id, $includes, $sellOrderSetting, $tax)) * $item->drop_rate; 
                    } 
                    // SALVAGEABLES (exclu uni gear)
                    else if ($item->item_description === "Salvage Item" && in_array('Salvageables', $includes)){
                        $itemValue = $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                    }
                    // ASCENDED JUNK
                    else if ($item->rarity == 'Ascended' && $item->type == 'CraftingMaterial' && in_array('AscendedJunk', $includes)) {
                        // There's a lot of ascended and crafteringMaterials so switch the $item->name to check for specifically the ascended junk
                        switch ($item->item_name){
                            case 'Dragonite Ore':
                                $itemValue = $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                                break;

                            case 'Empyreal Fragment':
                                $itemValue = $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                                break;

                            case 'Pile of Bloodstone Dust':
                                $itemValue = $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                                break;
                        }
                    }
                    // ANYTHING ELSE NOT FROM ABOVE 
                    else {
                        $itemValue = ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                    }                            
                }
                $item->value = $itemValue;

                if ($itemValue > $currentHighestValue){
                    $currentHighestValue = $itemValue;
                    if ($item->currency_id){
                        $mostValuedItem = $item->currency_name;
                        $mostValuedIcon = $item->currency_icon;
                    } else {
                        $mostValuedItem = $item->item_name;
                        $mostValuedIcon = $item->item_icon;
                    }
                    
                }
                
                $total += $itemValue; 
                

            } // End of foreach $items
            $gph = $total / $time; 
            //dd($total, $time);
            
            //dd($total);

            array_push($mapBenchmark, [
                'gph' => $gph,
                'total' => $total,
                'type' => $type,
                'time' => $time,
                'map' => $map,
                'sampleSize' => $sampleSize,
                'latestRun' => $latestRun,
                'mostValuedItem' => $mostValuedItem, 
                'mostValuedIcon' => $mostValuedIcon,
            ]);
        }

        $mapDropRates = $mapDropRates->values();

        $response = [
            'dropRates' => $mapDropRates,
            'benchmarks' => $mapBenchmark
        ];

        return response()->json($response); 


    }

    public function fishing($includes, $buyOrderSetting, $sellOrderSetting, $tax){
        // Make it a workable arrays
        $includes = json_decode($includes); 

        $fishingHoleDropRates = FishingHoleDropRate::join('fishing_holes as holes', 'fishing_hole_drop_rates.fishing_hole_id', '=', 'holes.id')
        ->leftjoin('items', 'fishing_hole_drop_rates.item_id', '=', 'items.id')
        ->leftjoin('fishing_estimates', 'fishing_estimates.fishing_hole_id', '=', 'holes.id')
        ->leftjoin('fishes', 'fishing_hole_drop_rates.fish_id', '=', 'fishes.id')
        ->leftjoin('items as bait_items', 'holes.bait_id', '=', 'bait_items.id')
        ->select(
            'fishing_hole_drop_rates.*',
            'holes.name as fishing_hole_name',
            'holes.*',
            'items.id as item_id',
            'items.*',
            'fishes.id as fish_id',
            'fishing_estimates.*',
            'bait_items.icon as bait_icon',
            'bait_items.name as bait_name'
        )
        ->get()
        ->groupBy('fishing_hole_id');

        // Drop rates that don't include the empty ones
        // Push the actual drop rates onto this array
        $dropRates = [];
        
        // 1) Get drop rates for each fishing hole
        // 2) Get estimate variables
        // 3 Calculate GPH estimates

        $fishingHoles = [];
        $response = [];

        foreach ($fishingHoleDropRates as $group){
            $estimateValue = 0; 
            $catchValue = 0;
            // Get the most valued item while iterating through the drop rates
            
            $currentItemValue = 0;
            $currentHighestValue = 0;
            $mostValuedItem = '';
            $mostValuedIcon = '';
            $fishJerkyFee = 0;

            $name = $group[0]->fishing_hole_name;
            $fishingPower = $group[0]->fishing_power; 
            $time = $group[0]->time;
            $region = $group[0]->region;
            $bait = $group[0]->bait_name; 
            $baitIcon = $group[0]->bait_icon;
            $map = $group[0]->map;
            $avgHoles = $group[0]->average_fishing_holes;
            $avgTime = $group[0]->average_time;
            $timeVariable = $group[0]->time_variable;
            $estimateVariable = $group[0]->estimate_variable; 
            $sampleSize = $group[0]->sample_size;

            //dd($group);
            // Check if there's a benchmark or route made for this in the spreadsheet
            // If no, skip
            if ($group[0]->map == '' || $group[0]->map == null){
                continue; 
            } else {
                array_push($dropRates, $group);

                foreach ($group as $item){
                    // Reset comparison of current item value vs. most valued
                    $currentItemValue = 0;
                    // IF drop rate > 0 => calculate values : otherwise skip
                    if ($item->drop_rate == 0){
                        continue;
                    } else {
                        // Junk items
                        if ($item->rarity == 'Junk'){
                            $currentItemValue = $item->vendor_value * $item->drop_rate; 
                            $catchValue += $currentItemValue; 
                        } 
                        // Containers (fish or champion bags)
                        else if ($item->type == 'Container'){
                            switch ($item->name){
                                // WORMS
                                case "Can of Worms": break; 
                                case "Can of Glow Worms": break; 
        
                                // CHAMPION BAGS
                                case "Watertight Bag":
                                case "Partially Chewed Box": 
                                    $currentItemValue = ($this->getContainerValue($item->bag_id, $includes, $sellOrderSetting, $tax)) * $item->drop_rate;
                                    $catchValue += $currentItemValue; 
                                    break;
        
                                default: 
                                    $currentItemValue = ($this->getFishValue($item->fish_id, $sellOrderSetting, $tax)) * $item->drop_rate; 
                                    $catchValue += $currentItemValue;
                                    break; 
                            }
                        }
                        $item->value = $currentItemValue;
                    }

                    if ($currentItemValue > $currentHighestValue){
                        $currentHighestValue = $currentItemValue;
                        $mostValuedItem = $item->name;
                        $mostValuedIcon = $item->icon;
                    }
                    
                    if ($name == 'Deep World-Class Fish'){
                        // 10 = amount of catches it takes to finish a fishing hole
                        $estimateValue = (($catchValue * $avgHoles) * 10) * $estimateVariable;

                        // Rate of how many times a user has to consume another set of jerky
                        $fishJerkyRate = 60 / $timeVariable; 
                        // Cost of using Jerky per hour'
                        // 4 = amount you need to get 99 stacks
                        $fishJerkyFee = $fishJerkyRate * ((Items::find(99955)->$buyOrderSetting) * 4); 

                        $estimateValue -= $fishJerkyFee; 
                    } else {
                        $estimateValue = (($catchValue * $avgHoles) * 3) * $estimateVariable;
                    }
                    
                    //dd($item);
                }
            }
            //dd($currentHighestValue, $mostValuedItem, $mostValuedIcon);
                     

            //dd($catchValue);

            array_push($fishingHoles, [
                'estimateValue' => $estimateValue,  
                'catchValue' => $catchValue,
                'fishingPower' => $fishingPower, 
                'name' => $name,
                'bait' => $bait,
                'baitIcon' => $baitIcon,
                'time' => $time,
                'region' => $region,
                'map' => $map,
                'sampleSize' => $sampleSize,
                'avgHoles' => $avgHoles,
                'avgTime' => $avgTime, 
                'timeVariable' => $timeVariable,
                'mostValuedItem' => $mostValuedItem,
                'mostValuedIcon' => $mostValuedIcon
            ]);
        }

        // Reset indexes to start from 0 instead of db 1
        $fishingHoleDropRates = $fishingHoleDropRates->values();

        $response = [
            'dropRates' => $dropRates,
            'fishingHoles' => $fishingHoles,
        ];

        //dd($response);

        return response()->json($response);
    }
}
