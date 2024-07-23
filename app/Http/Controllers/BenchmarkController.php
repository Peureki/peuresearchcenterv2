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
        ->select(
            'fishing_hole_drop_rates.*',
            'holes.name as fishing_hole_name',
            'holes.*',
            'items.id as item_id',
            'items.*',
            'fishes.id as fish_id',
            'fishing_estimates.*'
        )
        ->get()
        ->groupBy('fishing_hole_id');
        
        // 1) Get drop rates for each fishing hole
        // 2) Get estimate variables
        // 3 Calculate GPH estimates

        $fishingHoles = [];
        $response = [];

        foreach ($fishingHoleDropRates as $group){
            $estimateValue = 0; 
            $catchValue = 0;

            $fishingPower = $group[0]->fishing_power; 
            $bait = $group[0]->bait; 
            $time = $group[0]->time;
            $region = $group[0]->region;
            $map = $group[0]->map;
            $avgHoles = $group[0]->average_fishing_holes;
            $avgTime = $group[0]->average_time;
            $timeVariable = $group[0]->time_variable;
            $estimateVariable = $group[0]->estimate_variable; 
            $sampleSize = $group[0]->sample_size;

            //dd($group);

            foreach ($group as $item){
                // IF drop rate > 0 => calculate values : otherwise skip
                if ($item->drop_rate != 0){
                    // Junk items
                    if ($item->rarity == 'Junk'){
                        $catchValue += $item->vendor_value * $item->drop_rate; 
                    } 
                    // Containers (fish or champion bags)
                    else if ($item->type == 'Container'){
                        switch ($item->name){
                            // WORMS
                            case "Can of Worms": break; 
                            case "Can of Glow Worms": break; 
    
                            // CHAMPION BAGS
                            case "Watertight Bag": 
                                $catchValue += ($this->getContainerValue($item->bag_id, $sellOrderSetting, $tax)) * $item->drop_rate; 
                                break;
    
                            case "Partially Chewed Box":
                                // getChampionBagValue
                                break;
    
                            default: 
                                $catchValue += ($this->getFishValue($item->fish_id, $sellOrderSetting, $tax)) * $item->drop_rate; 
                                break; 
                        }
                    }
                }
                
                $estimateValue = (($catchValue * $avgHoles) * 3) * $estimateVariable;
                dd($item);
            }         

            //dd($catchValue);

            array_push($fishingHoles, [
                'estimateValue' => $estimateValue,  
                'catchValue' => $catchValue,
                'fishingPower' => $fishingPower, 
                'bait' => $bait, 
                'time' => $time,
                'region' => $region,
                'map' => $map,
                'avgHoles' => $avgHoles,
                'avgTime' => $avgTime, 
            ]);
        }

        // Reset indexes to start from 0 instead of db 1
        $fishingHoleDropRates = $fishingHoleDropRates->values();

        $response = [
            'dropRates' => $fishingHoleDropRates,
            'fishingHoles' => $fishingHoles,
        ];

        //dd($response);

        return response()->json($response);


        
    }
}
