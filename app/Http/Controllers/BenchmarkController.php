<?php

namespace App\Http\Controllers;

use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{
    public function fishing($sellOrderSetting, $tax){
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
                                    $currentItemValue = ($this->getContainerValue($item->bag_id, $sellOrderSetting, $tax)) * $item->drop_rate;
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
                    
                    
                    $estimateValue = (($catchValue * $avgHoles) * 3) * $estimateVariable;
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
