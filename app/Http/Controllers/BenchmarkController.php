<?php

namespace App\Http\Controllers;

use App\Events\LoadingProgress;
use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use App\Models\GlyphDropRate;
use App\Models\Items;
use App\Models\MapBenchmarkCache;
use App\Models\MapBenchmarkDropRate;
use App\Models\NodeBenchmarkCombination;
use App\Models\NodeBenchmarkDropRate;
use App\Models\NodeDropRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BenchmarkController extends Controller
{
    public function nodes($includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }

        $response = [];
        $nodes = [];

        $nodeDropRates = NodeDropRate::leftjoin('nodes', 'node_id', 'nodes.id')
        ->leftjoin('items', 'node_drop_rates.item_id', 'items.id')
        ->leftjoin('currencies', 'node_drop_rates.currency_id', 'currencies.id')
        ->select(
            'node_drop_rates.*',
            'nodes.*',
            'items.*',
            'currencies.*',
            'nodes.name as node_name',
            'nodes.type as node_type',
            'items.name as name',
            'items.name as item_name',
            'items.icon as item_icon',
            'currencies.name as currencies_name',
            'currencies.icon as currencies_icon',
        )
        ->get()
        ->groupBy('node_id');

        foreach ($nodeDropRates as $group){
            $nodeValue = 0; 

            $nodeIcon = null; 
            $mostValuedItem = 0; 

            // Calculate items that can drop from a node
            foreach ($group as $item){
                $subNodeValue = 0;

                $subNodeValue += $this->getItemValue($item, $includes, $sellOrderSetting, $tax);

                // if ($subNodeValue == 0){
                //     dd($item, $subNodeValue);
                // }

                $nodeValue += $subNodeValue;
                $item->value = $subNodeValue; 

                if ($subNodeValue > $mostValuedItem){
                    $mostValuedItem = $subNodeValue;
                    $nodeIcon = $item->item_icon; 
                }
            }

            array_push($nodes, [
                'value' => $nodeValue, 
                'name' => $group[0]->node_name, 
                'icon' => $nodeIcon,
                'type' => $group[0]->node_type,
            ]);
        }

        $nodeDropRates = $nodeDropRates->values();

        //dd($nodeDropRates);
        $response = [
            'benchmarks' => $nodes,
            'dropRates' => $nodeDropRates,
        ];

        return response()->json($response);
    }

    public function nodeFarms($includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }

        $response = [];
        $map = [];
        $dropRates = [];

        $combinations = NodeBenchmarkCombination::join('node_benchmarks', 'node_benchmark_id', 'node_benchmarks.id')
        ->leftjoin('items as most_valued_item', 'most_valued_item_id', 'most_valued_item.id')
        ->leftjoin('items as pick_items', 'pick_id', 'pick_items.id')
        ->leftjoin('items as axe_items', 'axe_id', 'axe_items.id')
        ->leftjoin('items as sickle_items', 'sickle_id', 'sickle_items.id')
        ->select(
            'node_benchmark_combinations.*',
            'node_benchmarks.*',
            'node_benchmarks.name as benchmark_name',
            'most_valued_item.name as most_valued_item_name',
            'most_valued_item.icon as most_valued_item_icon',
            'pick_items.icon as pick_icon',
            'axe_items.icon as axe_icon',
            'sickle_items.icon as sickle_icon',
        )
        ->orderBy('value', 'desc')
        ->paginate(50); 

        $benchmarkDropRates = NodeBenchmarkDropRate::join('nodes', 'node_id', 'nodes.id')
        //->join('items', 'nodes.item_id', 'items.id')
        ->get()
        ->groupBy('node_benchmark_id');

        $nodeDropRates = NodeDropRate::join('items', 'item_id', 'items.id')
        ->get()
        ->groupBy('node_id');

        //dd($combinations, $benchmarkDropRates, $nodeDropRates);

        foreach ($combinations as $benchmark){
            $currentNode = $benchmarkDropRates->get($benchmark['id']);
            //dd($currentDrop);

            // Calculate node value by += each item's value from that node
            foreach ($currentNode as $node){
                $nodeItems = $nodeDropRates->get($node['node_id']); 
                $nodeValue = 0;

                $nodeIcon = null; 
                $mostValuedItem = 0; 

                // Calculate items that can drop from a node
                foreach ($nodeItems as $item){
                    $subNodeValue = 0;

                    $subNodeValue += $this->getItemValue($item, $includes, $sellOrderSetting, $tax);

                    $nodeValue += $subNodeValue;

                    if ($subNodeValue > $mostValuedItem){
                        $mostValuedItem = $subNodeValue;
                        $nodeIcon = $item->icon; 
                    }
                }
                // Insert 'value', 'icon' property to display in the FE
                $node->value = $nodeValue * $node->drop_rate; 
                $node->icon = $nodeIcon;
                //dd($node);
            }



            // If NULL, then apply 'N/A' 
            // Otherwise get the last word of a glyph name IE Bounty
            $pick = $benchmark['pick'] ? $this->getLastWord($benchmark['pick']) : 'N/A';
            $axe = $benchmark['axe'] ? $this->getLastWord($benchmark['axe']) : 'N/A';
            $sickle = $benchmark['sickle'] ? $this->getLastWord($benchmark['sickle']) : 'N/A';

            // Combine glyph names and icons to easily display in frontend
            $glyphs = [
                ['name' => $pick, 'icon' => $benchmark['pick_icon']],
                ['name' => $axe, 'icon' => $benchmark['axe_icon']],
                ['name' => $sickle, 'icon' => $benchmark['sickle_icon']],
            ];

            //dd($benchmark);
            array_push($map, [
                'map' => $benchmark['benchmark_name'],
                'gph' => $benchmark['value'],
                'mostValuedItemName' => $benchmark['most_valued_item_name'],
                'mostValuedItemIcon' => $benchmark['most_valued_item_icon'],
                'nodes' => $currentNode,
                'glyphs' => $glyphs,
                'time' => $benchmark['time'],
            ]);
        }

        $response = [
            'benchmarks' => $map,
            'combinations' => $combinations
        ];

        return response()->json($response); 
    }

    public function glyphs($includes, $sellOrderSetting, $tax){
        // In case $includes is null
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }

        $response = []; 
        $benchmarks = [];

        // Get all drop rates of each glyph and group by their glyph id
        $glyphDropRates = GlyphDropRate::leftjoin('glyphs', 'glyph_drop_rates.glyph_id', 'glyphs.id')
        ->leftjoin('items', 'glyph_drop_rates.item_id', 'items.id')
        ->leftjoin('items as glyph_items', 'glyphs.item_id', 'glyph_items.id')
        ->leftjoin('currencies', 'currency_id', 'currencies.id')
        ->select(
            'glyph_drop_rates.*',
            'items.*',
            'currencies.*',
            'glyph_items.icon as icon',
            'glyphs.name as name',
            'glyphs.level as level',
            'glyphs.type as glyph_type',
            'glyphs.sample_size as sample_size',
            'items.name as item_name',
            'items.icon as item_icon',
            'currencies.name as currency_name',
            'currencies.icon as currency_icon'
        )
        ->get()
        ->groupBy('glyph_id');

        //dd($glyphDropRates);
        // Go through each group of glyphs (id = glyph_id)
        foreach ($glyphDropRates as $group){

            $glyphValue = 0;
            // Get value of current glyph
            foreach ($group as $item){
                //dd($group, $item);
                $subValue = 0;
                $subValue += $this->getItemValue($item, $includes, $sellOrderSetting, $tax);
                
                $glyphValue += $subValue;
                $item->value = $subValue;
            }

            array_push($benchmarks, [
                'name' => $group[0]->name, 
                'icon' => $group[0]->icon,
                'level' => $group[0]->level,
                'type' => $group[0]->glyph_type,
                'value' => $glyphValue, 
            ]);
        }

        //dd($benchmarks, $glyphDropRates);

        $glyphDropRates = $glyphDropRates->values();

        $response = [
            'benchmarks' => $benchmarks,
            'dropRates' => $glyphDropRates
        ];

        return response()->json($response);
    }

    // public function nodes($pick, $axe, $sickle, $includes, $sellOrderSetting, $tax){
    //     // Make it a workable arrays
    //     // New accounts that haven't set any settings may still have "null"
    //     // if ($includes == "null"){
    //     //     $includes = [];
    //     // } else {
    //     //     $includes = json_decode($includes);
    //     // }

    //     //dd($pick, $axe, $sickle);

    //     $response = [];
    //     $map = []; 

    //     $nodeBenchmarkDropRates = NodeBenchmarkDropRate::join('node_benchmarks', 'node_benchmark_id', '=', 'node_benchmarks.id')
    //     ->join('nodes', 'node_id', '=', 'nodes.id')
    //     ->select(
    //         'node_benchmark_drop_rates.*',
    //         'node_benchmarks.*',
    //         'nodes.*',
    //         'node_benchmarks.name as map_name',
    //         'node_benchmarks.sample_size as sample_size'
    //     )
    //     ->get()
    //     ->groupBy('node_benchmark_id'); 

    //     //dd($nodeBenchmarkDropRates);

    //     foreach ($nodeBenchmarkDropRates as $group){

    //         $value = 0;
    //         $gph = 0;

    //         foreach($group as $node){
    //             //dd($node);
    //             // The value for this particular item in this loop
    //             // Reset for the next
    //             $subValue = 0;
    //             $subValue += $this->getNodeValue($pick, $axe, $sickle, $node->level, $node->node_id, $node->drop_rate, $includes, $sellOrderSetting, $tax);

    //             $node->value = $subValue; 
    //             $value += $subValue; 
    //         }

    //         $gph = (3600 / $group[0]->time) * $value;
    //         //dd('gold per hour: '.$gph);
    //         $map[] = [
    //             'map' => $group[0]->map_name,
    //             'type' => $pick .', '. $axe .', '. $sickle,
    //             'time' => $group[0]->time,
    //             'sample_size' => $group[0]->sample_size, 
    //             'total' => $value,
    //             'gph' => $gph,
    //         ];
            
    //     }
    //     $nodeBenchmarkDropRates = $nodeBenchmarkDropRates->values();

    //     $response = [
    //         'benchmarks' => $map,
    //         'dropRates' => $nodeBenchmarkDropRates
    //     ];
    //     //dd($map);
    //     //dd($map, $nodeBenchmarkDropRates);

    //     return response()->json($response);

    // }


    public function maps($includes, $filter, $sellOrderSetting, $tax){
        //dd($filter);

        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }
        // Make $filter a workable array
        if ($filter){
            $filter = json_decode($filter); 
        }

        // Create unique cache key with the unique paramters a user may have
        $cacheKey = 'map_benchmarks_' . md5(json_encode($includes) . json_encode($filter) . $sellOrderSetting . $tax); 

        //dd($cacheResults);

        // If data has been cached, then return that instead
        $cachedResponse = Cache::get($cacheKey); 
        if ($cachedResponse && isset($cachedResponse['benchmarks']) && !empty($cachedResponse['benchmarks'])){
            //Log::info('this is the cached benchmarks: ', $cachedResponse);
            return response()->json($cachedResponse); 
        }
        

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
        ->whereIn('map.type', $filter)
        //->where('map_benchmark_id', 51)
        // ->paginate(10);
        ->get()
        ->groupBy('map_benchmark_id'); 

        //dd($mapDropRates);

        $mapBenchmark = []; 
        $benchmarkTotalCount = $mapDropRates->count(); 
        $response = []; 

        foreach ($mapDropRates as $group){
            //dd($group);
            $gph = 0;
            $time = $group[0]->time;

            $itemValue = 0;
            $currentHighestValue = 0; 
            $mostValuedItem = '';
            $mostValuedIcon = '';
            $total = 0;

            foreach ($group as $item){
                //dd($item);

                $itemValue = $this->getItemValue($item, $includes, $sellOrderSetting, $tax); 

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

                $item->value = $itemValue;
                
                $total += $itemValue; 
                

            } // End of foreach $items
            $gph = $total / $time; 
            //dd($total, $time);
            
            //dd($total);

            $mapBenchmark[] = [
                'gph' => $gph,
                'total' => $total,
                'type' => $group[0]->map_type,
                'time' => $group[0]->time,
                'map' => $group[0]->map_name,
                'sampleSize' => $group[0]->sample_size,
                'latestRun' => $group[0]->latest_run,
                'mostValuedItem' => $mostValuedItem,
                'mostValuedIcon' => $mostValuedIcon,
            ];
            // Constantly return progress of loading benchmarks
            $progress = count($mapBenchmark) / $benchmarkTotalCount;
            broadcast(new LoadingProgress($progress));
        }

        $mapDropRates = $mapDropRates->values();

        //dd($mapDropRates);

        $response = [
            'dropRates' => $mapDropRates,
            'benchmarks' => $mapBenchmark
        ];

        // Store unique cache key for the next [time] minutes
        Cache::put($cacheKey, $response, now()->addHours(24)); 

        return response()->json($response); 
    }

    public function fishing($includes, $buyOrderSetting, $sellOrderSetting, $tax){

        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }

        // Create unique cache key with the unique paramters a user may have
        $cacheKey = 'fishing_benchmarks_' . md5(json_encode($includes) . $sellOrderSetting . $tax); 

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
            'items.name as item_name',
            'items.icon as item_icon',
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
        
        // Total amount of fetched benchmarks
        $benchmarkTotalCount = $fishingHoleDropRates->count(); 
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
                            switch ($item->item_name){
                                // WORMS
                                case "Can of Worms": break; 
                                case "Can of Glow Worms": break; 
        
                                // CHAMPION BAGS
                                case "Watertight Bag":
                                case "Partially Chewed Box": 
                                    $currentItemValue = $this->getContainerValue($item->item_id, $item->drop_rate, $includes, $sellOrderSetting, $tax);
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

            // Constantly return progress of loading benchmarks
            $progress = count($fishingHoles) / $benchmarkTotalCount;
            broadcast(new LoadingProgress($progress));
        }

        // Reset indexes to start from 0 instead of db 1
        $fishingHoleDropRates = $fishingHoleDropRates->values();

        $response = [
            'dropRates' => $dropRates,
            'fishingHoles' => $fishingHoles,
        ];

        // Store unique cache key for the next [time] minutes
        Cache::put($cacheKey, $response, now()->addHours(12)); 
        

        //dd($response);

        return response()->json($response);
    }
}
