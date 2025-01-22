<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\BagDropRate;
use App\Models\ChoiceChest;
use App\Models\ChoiceChestOption;
use App\Models\ContainerDropRate;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PgSql\Lob;

use function PHPUnit\Framework\isEmpty;

class BagController extends Controller
{
    public function getTable($table, $sellOrderSetting, $tax){
        $returnArray = []; 

        $data = DB::table($table)
            ->join('items', "items.id", '=', "{$table}.item_id")
            ->select("{$table}.*", 'items.*')
            ->get();

        foreach ($data as $item){
            $entry = [
                'name' => $item->name,
                'icon' => $item->icon,
                'sellOrderSetting' => $item->$sellOrderSetting,
                'dropRate' => $item->drop_rate,
                'value' => ($item->$sellOrderSetting * $item->drop_rate) * $tax,
            ];
            $returnArray[] = $entry;

        }
        return response()->json($returnArray);
    }

    // // * 
    // // * GET BAG VALUE OF REQUESTED BAG IDs
    // // * 
    // // * @param $requestIDs <array>: IDs to be queued and get the values of each bag
    // // * 
    // public function getBagValues($requestIDs, $includes, $sellOrderSetting, $tax){
    //     $bagDB = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
    //         ->leftjoin('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
    //         ->leftjoin('items as bag_item', 'bags.id', '=', 'bag_item.id')
    //         ->leftjoin('currencies as currency', 'bag_drop_rates.currency_id', '=', 'currency.id')
    //         ->select(
    //             'bag_drop_rates.*', 
    //             'bags.*', 
    //             'currency.*',
    //             'currency.name as currency_name',
    //             'currency.icon as currency_icon',
    //             'currency.icon as item_icon',
    //             'item.icon as item_icon',
    //             'item.name as item_name', 
    //             'item.*', 
    //             'bag_item.icon as bag_icon',
    //             'bag_item.name as bag_name',
    //             'bag_item.rarity as bag_rarity',
    //         )
    //         ->whereIn('bag_id', $requestIDs)
    //         ->get()
    //         ->groupBy('bag_id');

    //     foreach ($bagDB as $bag){
    //         $value = 0; 
    //         foreach ($bag as $item){
    //             //dd('item: ', $item);
    //             $value += $this->getItemValue($item, $includes, $sellOrderSetting, $tax); 
    //         }
    //         $bag->value = $value; 
    //         //dd($bag); 
    //     }

    //     //dd('bagDB: ', $bagDB); 

    //     return $bagDB; 
    // }

    // * 
    // * GET BAG VALUE OF REQUESTED BAG IDs
    // * 
    // * @param $requestIDs <array>: IDs to be queued and get the values of each bag
    // * 
    public function getBagCollection($requestID, $quantity, $includes, $sellOrderSetting, $tax){
        $bagDB = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
            ->leftjoin('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
            ->leftjoin('items as bag_item', 'bags.id', '=', 'bag_item.id')
            ->leftjoin('currencies as currency', 'bag_drop_rates.currency_id', '=', 'currency.id')
            ->select(
                'bag_drop_rates.*', 
                'bags.*', 
                'currency.*',
                'currency.name as currency_name',
                'currency.icon as currency_icon',
                'currency.icon as item_icon',
                'item.icon as item_icon',
                'item.name as item_name', 
                'item.*', 
                'bag_item.icon as bag_icon',
                'bag_item.name as bag_name',
                'bag_item.rarity as bag_rarity',
            )
            ->where('bag_id', $requestID)
            ->get();

        $value = 0;

        foreach ($bagDB as $item){
            $itemValue = $this->getItemValue($item, $includes, $sellOrderSetting, $tax); 
            $item->value = $itemValue; 
            $value += $itemValue; 
        }
        // Append as array property so that it will show up in the json response in the frontend
        $bagDB['value'] = $value * $quantity; 

        //dd('bagDB: ', $bagDB); 

        return $bagDB; 
    }

    // * 
    // * GET CHOICE CHEST VALUE OF REQUESTED BAG IDs
    // * 
    // * @param $requestIDs <array>: IDs to be queued and get the values of each bag
    // * 
    public function getChoiceChestCollection($requestID, $quantity, $includes, $sellOrderSetting, $tax){
        $choiceChestDB = ChoiceChestOption::join('choice_chests', 'choice_chest_options.choice_chest_id', '=', 'choice_chests.id')
        ->leftjoin('items as item', 'choice_chests.id', '=', 'item.id')
        ->where('choice_chests.id', $requestID)
        ->leftjoin('items as bag_item', 'choice_chest_options.item_id', '=', 'bag_item.id')
        ->select(
            'choice_chest_options.*',
            'bag_item.*',
            'item.name as bag_name',
            'item.icon as bag_icon',
            'item.rarity as bag_rarity',
            'choice_chest_options.quantity as drop_rate',
            'bag_item.name as item_name'
        )
        ->get();

        $bestValue = 0;

        //dd('choice chest db: ', $choiceChestDB);

        foreach ($choiceChestDB as &$item){
            //dd($item);
            $itemValue = $this->getItemValue($item, $includes, $sellOrderSetting, $tax); 
            $item->value = $itemValue; 

            // if ($item->name == 'Dragonite Ore'){
            //     dd($item, $itemValue, $includes);
            // }

            if ($bestValue < $itemValue){
                $bestValue = $itemValue;
            }
        }
        // Append as array property so that it will show up in the json response in the frontend
        $choiceChestDB['value'] = $bestValue * $quantity; 

        return $choiceChestDB; 
    }

    // * 
    // * GET CHOICE CHEST VALUE OF REQUESTED BAG IDs
    // * 
    // * @param $requestIDs <array>: IDs to be queued and get the values of each bag
    // * 
    // public function getChoiceChestValues($requestIDs, $includes, $sellOrderSetting, $tax){
    //     $choiceChestDB = ChoiceChestOption::join('choice_chests', 'choice_chest_options.choice_chest_id', '=', 'choice_chests.id')
    //     ->leftjoin('items as item', 'choice_chests.id', '=', 'item.id')
    //     ->where('choice_chests.id', $requestIDs)
    //     ->leftjoin('items as bag_item', 'choice_chest_options.item_id', '=', 'bag_item.id')
    //     ->select(
    //         'choice_chest_options.*',
    //         'bag_item.*',
    //         'item.name as bag_name',
    //         'item.icon as bag_icon',
    //         'item.rarity as bag_rarity',
    //         'choice_chest_options.quantity as drop_rate'
    //     )
    //     ->get()
    //     ->groupBy('choice_chest_id');

    //     dd('choice chest db: ', $choiceChestDB, $requestIDs); 

    //     return $choiceChestDB; 
    // }

    // Get array of item ids for $requestedBags
    // => Check if id belongs in Bags or ChoiceChest
    // => Rest, check if it's in Items
    public function exchangeables($request, $includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }
        //dd($includes);
        // This is where bag_ids will be pushed depending on what exchangable item is being exchanged
        $requestedBags = []; 
        $requestedChoiceChests = []; 
        // Check if $request matches with one of the $map
        // Populate arrays
        if (isset($this->exchangeableMap[$request])){
            $data = $this->exchangeableMap[$request]; 
            $requestedBags = array_merge($requestedBags, $data['id']);
            $conversionRate = $data['conversionRate'];
            $fee = $data['fee'];
            $outputQty = $data['outputQty'];
        }
        
        //dd($requestedBags);

        $response = []; 
        $bag = [];

        // PUSH IDs onto where ever target IDs match their respective databases
        $arrayToSearchBags = []; 
        $arrayToSearchChoiceChests = [];
        $arrayToSearchItems = [];

        foreach ($requestedBags as $id){
            $existsInBag = Bag::where('id', $id)->exists(); 
            $existsInChoiceChest = ChoiceChest::where('id', $id)->exists();
            
            if ($existsInBag){
                array_push($arrayToSearchBags, $id);
            }

            if ($existsInChoiceChest){
                array_push($arrayToSearchChoiceChests, $id);
            }

            if (!$existsInBag && !$existsInChoiceChest){
                array_push($arrayToSearchItems, $id);
            }
        }

        // IF BAG CONVERSIONS EXIST
        if ($arrayToSearchBags){
            $bagDropRates = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
                ->leftjoin('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
                ->leftjoin('items as bag_item', 'bags.id', '=', 'bag_item.id')
                ->leftjoin('currencies as currency', 'bag_drop_rates.currency_id', '=', 'currency.id')
                ->select(
                    'bag_drop_rates.*', 
                    'bags.*', 
                    'currency.*',
                    'currency.name as currency_name',
                    'currency.icon as currency_icon',
                    'currency.icon as item_icon',
                    'item.icon as item_icon',
                    'item.name as item_name', 
                    'item.*', 
                    'bag_item.icon as bag_icon',
                    'bag_item.name as bag_name',
                    'bag_item.rarity as bag_rarity',
                )
                ->whereIn('bag_id', $arrayToSearchBags)
                ->get()
                ->groupBy('bag_id');

            //dd($bagDropRates);

            // FOR DUPLICATED OUTPUTS WITH DIFFERENT CONVERSIONS OR CONDITIONS
            switch ($request){
                case 'Dragonite Ore': 
                case 'Empyreal Fragment':
                case 'Paile of Bloodstone Dust':
                    // Astral Fluc Mass
                    foreach ($bagDropRates as $index => $item){
                        if ($index == 101727){
                            $duplicateItem = clone $item; 
                            $bagDropRates->splice($index + 1, 0, [$duplicateItem]);
                        }
                    }
                    break;

                case 'Unbound Magic': 
                    foreach ($bagDropRates as $index => $item){
                        if ($index == 79186){
                            $duplicateItem = clone $item; 
                            $bagDropRates->splice($index + 1, 0, [$duplicateItem]);
                        }
                    }
                    break;
            }

            //dd($bagDropRates);
        }

        // IF CHOICE CHESTS CONVERSIONS EXIST
        if ($arrayToSearchChoiceChests){
            $choiceChestDropRates = ChoiceChestOption::join('choice_chests', 'choice_chest_options.choice_chest_id', '=', 'choice_chests.id')
                ->leftjoin('items as item', 'choice_chests.id', '=', 'item.id')
                ->where('choice_chests.id', $arrayToSearchChoiceChests)
                ->leftjoin('items as bag_item', 'choice_chest_options.item_id', '=', 'bag_item.id')
                ->select(
                    'choice_chest_options.*',
                    'bag_item.*',
                    'item.name as bag_name',
                    'item.icon as bag_icon',
                    'item.rarity as bag_rarity',
                    'choice_chest_options.quantity as drop_rate'
                )
                ->get()
                ->groupBy('choice_chest_id');

            //dd($choiceChestDropRates, $arrayToSearchChoiceChests);
        }
        // IF DIRECT ITEM CONVERSIONS EXIST
        if ($arrayToSearchItems){
            $itemDropRates = Items::whereIn('id', $arrayToSearchItems)
            ->get();

            // Duplicate specific item if it's in $itemDropRates
            // Then add to the collection
            switch ($request){
                case "Curious Lowland Honeycomb":
                case "Curious Mursaat Currency":
                    foreach ($itemDropRates as $index => $item){
                        if ($item->id == 103530){
                            $duplicateItem = clone $item; 
                            $itemDropRates->splice($index + 1, 0, [$duplicateItem]);
                        }
                    }
                    break;
            }

            // Turn item results from collection to array
            // Specifically make [$item] because the format should be
            // 0 => [array: 1] represents this entry has one drop in it's drop table
            $tempArray = []; 
            foreach ($itemDropRates as $item){
                $item->drop_rate = 1;
                $tempArray[] = [$item]; 
            }
            $itemDropRates = collect($tempArray);            
            //dd($itemDropRates);
        }

        $mergedDropTables = collect();

        // CONCAT TABLES if they exist
        if (isset($bagDropRates)){
            $mergedDropTables = $mergedDropTables->concat($bagDropRates);
        }
        if (isset($choiceChestDropRates)){
            $mergedDropTables = $mergedDropTables->concat($choiceChestDropRates);
        }
        if (isset($itemDropRates)){
            $mergedDropTables = $mergedDropTables->concat($itemDropRates);
        }
        //dd($choiceChestDropRates, $itemDropRates);

        
        // MERGE results
        //$mergedDropTables = array_values($choiceChestDropRates + $itemDropRates);
        //dd($mergedDropTables, $requestedBags);

        // Match ID indexes of $requestedBags with the newly merged drop table results
        $mergedDropTables = $mergedDropTables->sortBy(function($item) use ($requestedBags) {
            // Prioritize if the $key contains the property 'choice_chest_id' 
            // Otherwise match the id
            if (isset($item[0]['bag_id']) && !isset($item[0]['choice_chest_id'])) {
                $key = $item[0]['bag_id']; // First priority: bag_id
            } elseif (isset($item[0]['choice_chest_id'])) {
                $key = $item[0]['choice_chest_id']; // Second priority: choice_chest_id
            } else {
                $key = $item[0]['id']; // Default: id
            }
            return array_search($key, $requestedBags);
        })->values();

        //dd($mergedDropTables, $requestedBags);

        foreach ($mergedDropTables as $index => $group){
            //dd('group', $group);
            $total = 0;
            $choiceChestTotal = 0;
            $bagName = '';
            $icon = '';
            $rarity = '';
            $profitPerBag = 0;
            $currency = $request;
            // Initialize as an array to potentially store more than 1 currency for a bag
            // ie Trade Crates use Trade Contracts && Karma
            $currencyPerBag = 0;

            if (isset($group[0]->choice_chest_id)){
                $choiceChestTotal = $this->getChoiceChestValue($group[0]->choice_chest_id, 1, $includes, $sellOrderSetting, $tax);
                //break; 
            }
            // Go through each drop rate as $item
            foreach ($group as $item){
                // if ($item->id == 103530){
                //     dd($item);
                // }
                $value = $this->getItemValue($item, $includes, $sellOrderSetting,$tax); 
                $total += $value; 

                //dd($item);
                // ?? for properties of items that are directly converted instead of a bag
                $bagName = $item->bag_name ?? $item->name;
                $icon = $item->bag_icon ?? $item->icon;
                $rarity = $item->bag_rarity ?? $item->rarity;
                // Set item 'value' property to showcase in the frontend
                $item->value = $value; 
            }
            //dd($total, $group);

            if ($choiceChestTotal){
                $total = $choiceChestTotal;
            }

            $profitPerBag = ($total - $fee[$index]) * $outputQty[$index]; 
            $currencyPerBag = $profitPerBag / $conversionRate[$index]; 
            //dd($profitPerBag);

            array_push($bag, [
                'total' => $total,
                'name' => $bagName,
                'icon' => $icon,
                'fee' => $fee[$index],
                'rarity' => $rarity,
                'profitPerBag' => $profitPerBag,
                'currency' => $currency,
                'currencyPerBag' => $currencyPerBag,
                'costOfCurrencyPerBag' => $conversionRate[$index],  
                'outputQty' => $outputQty[$index],
            ]);
        }

        //dd($mergedDropTables);
        $response = [
            'dropRates' => $mergedDropTables,
            'bag' => $bag,
        ];

        return response()->json($response);






        //dd($arrayToSearchBags, $arrayToSearchChoiceChests, $arrayToSearchItems);

        $bagDropRates = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
        ->leftjoin('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
        ->leftjoin('items as bag_item', 'bags.id', '=', 'bag_item.id')
        ->leftjoin('currencies as currency', 'bag_drop_rates.currency_id', '=', 'currency.id')
        ->select(
            'bag_drop_rates.*', 
            'bags.*', 
            'currency.*',
            'currency.name as currency_name',
            'currency.icon as currency_icon',
            'currency.icon as item_icon',
            'item.icon as item_icon',
            'item.name as item_name', 
            'item.*', 
            'bag_item.icon as bag_icon',
            'bag_item.name as bag_name',
            'bag_item.rarity as bag_rarity',
        )
        ->whereIn('bag_id', $requestedBags)
        ->get()
        ->groupBy('bag_id');

        // Check if the amount of $bagDropRates matches $requestedBags
        // If not, usually means there's something that's not a bag such as
        // i.e Choice Chest
        if ($bagDropRates->count() != count($requestedBags)){
            foreach ($requestedBags as $bagID){
                if (in_array($bagID, $this->choiceChests)){
                    $choiceChestDropRates = ChoiceChestOption::join('choice_chests', 'choice_chest_options.choice_chest_id', '=', 'choice_chests.id')
                    ->leftjoin('items as item', 'choice_chests.id', '=', 'item.id')
                    ->where('choice_chests.id', $bagID)
                    ->leftjoin('items as bag_item', 'choice_chest_options.item_id', '=', 'bag_item.id')
                    ->select(
                        'choice_chest_options.*',
                        'item.*',
                        'item.name as bag_name',
                        'item.icon as bag_icon',
                        'item.rarity as bag_rarity',
                        'bag_item.name as item_name',
                        'bag_item.icon as item_icon',
                        'bag_item.rarity as item_rarity',
                        'bag_item.description as item_description',
                        'choice_chest_options.quantity as drop_rate'
                    )
                    ->get();

                    $bagDropRates[$bagID] = $choiceChestDropRates; 
                }
            }
        }

        //dd('bag drop rates: ', $bagDropRates, $requestedBags);
        //dd('choice chest: ', $choiceChestDropRates);
        //dd($request);

        $orderedResults = [];

        // If $bagDropRates != empty
        if (!$bagDropRates->isEmpty()){
            // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
            // This is to match the conversionRates and fees
            foreach ($requestedBags as $id){
                if (isset($bagDropRates[$id])){
                    $orderedResults[$id] = $bagDropRates[$id];
                }
            }

            //dd($orderedResults); 
            // Make the indexes reset to 0, 1, 2, etc instead of the item IDs
            $bagDropRates = array_values($orderedResults);

            // FOR DUPLICATED OUTPUTS WITH DIFFERENT CONVERSIONS OR CONDITIONS
            switch ($request){
                case "Curious Lowland Honeycomb":
                    $this->duplicate_and_splice_bag(103530, $bagDropRates, 'Kodan Cache Key');
                    break;

                case 'Dragonite Ore': 
                case 'Empyreal Fragment':
                case 'Paile of Bloodstone Dust':
                    // Astral Fluc Mass
                    $this->duplicate_and_splice_bag(101727, $bagDropRates, 'Astral Fluctuating Mass');
                    break;

                case 'Unbound Magic': 
                    $this->duplicate_and_splice_bag(79186, $bagDropRates, 'Magic-Warped Bundle (Ember Bay)');
                    break;

                
            }

            //dd($bagDropRates, $requestedBags);

            foreach ($bagDropRates as $index => $group){
                

                $total = 0;
                $bagName = '';
                $icon = '';
                $profitPerBag = 0;
                $currency = $request;
                // Initialize as an array to potentially store more than 1 currency for a bag
                // ie Trade Crates use Trade Contracts && Karma
                $currencyPerBag = 0;

                // Check if it's a choice chest
                // OTHERWISE
                // Go through all the items in each bag and calculate
                
                foreach ($group as $item){
                    //dd($item);                    
                    $value = $this->getItemValue($item, $includes, $sellOrderSetting, $tax);
                    $total += $value;

                    $item->value = $value;
                }
                if (isset($group[0]->choice_chest_id)){
                    $total = $this->getChoiceChestValue($group[0]->choice_chest_id, 1, $includes, $sellOrderSetting, $tax);
                }
                // Insert 'value' into $items collection
                
                
                // Check if there's a duplicated bag
                if (isset($group->duplicated)){
                    $bagName = $group->duplicated_name; 
                } else {
                    $bagName = $group[0]->bag_name;
                }

                $profitPerBag = ($total - $fee[$index]) * $outputQty[$index]; 
                $currencyPerBag = $profitPerBag / $conversionRate[$index]; 
                //dd($profitPerBag);

                array_push($bag, [
                    'total' => $total,
                    'name' => $bagName,
                    'icon' => $group[0]->bag_icon,
                    'fee' => $fee[$index],
                    'rarity' => $group[0]->bag_rarity,
                    'profitPerBag' => $profitPerBag,
                    'currency' => $currency,
                    'currencyPerBag' => $currencyPerBag,
                    'costOfCurrencyPerBag' => $conversionRate[$index],  
                    'outputQty' => $outputQty[$index],
                ]);
            }
        }
        // If $bagDropRates == EMPTY
        // Indicates that the exchange is not through a bag but a direct item 
        else {
            $bagDropRates = Items::whereIn('id', $requestedBags)->get();
            $tempArray = []; 

            //dd($bagDropRates);

            // FOR DUPLICATED OUTPUTS WITH DIFFERENT CONVERSIONS OR CONDITIONS
            switch ($request){
                case "Curious Lowland Honeycomb":
                    //dd($bagDropRates);
                    foreach ($bagDropRates as $index => $item){
                        if ($item->id == 103530){
                            $duplicateItem = clone $item; 
                            $bagDropRates->splice($index + 1, 0, [$duplicateItem]);
                        }
                    }
                    break;
            }

            //dd($bagDropRates);

            // Make sure the order of $requestedBags is maintained after fetching data
            $bagDropRates = $bagDropRates->sortBy(function($item) use ($requestedBags) {
                return array_search($item->id, $requestedBags);
            })->values();

            //dd($requestedBags, $bagDropRates);

            
            foreach ($bagDropRates as $index => $item){
                $total = 0;

                $total = $this->getItemValue($item, $includes, $sellOrderSetting, $tax); 

                // Missing properties that normally would have from $bagDropTable
                // These properties are used in the front end to display drop rate proofs
                $bagDropRates[$index]->sample_size = 1; 
                $bagDropRates[$index]->drop_rate = 1;
                $bagDropRates[$index]->item_name = $item->name;
                $bagDropRates[$index]->item_icon = $item->icon;
                $item->value = $total; 

                $profitPerBag = ($total - $fee[$index]) * $outputQty[$index]; 
                $currencyPerBag = $profitPerBag / $conversionRate[$index]; 

                array_push($bag, [
                    'total' => $total,
                    'name' => $item->name,
                    'icon' => $item->icon,
                    'fee' => $fee[$index],
                    'rarity' => $item->rarity,
                    'profitPerBag' => $profitPerBag,
                    'currency' => $request,
                    'currencyPerBag' => $currencyPerBag,
                    'costOfCurrencyPerBag' => $conversionRate[$index],  
                    'outputQty' => $outputQty[$index],
                ]);

                $tempArray[$index] = [$bagDropRates[$index]];
            }
            $bagDropRates = $tempArray; 
        }
        

        //dd($bagDropRates);

        

        $response = [
            'dropRates' => $bagDropRates,
            'bag' => $bag, 
        ];

        return response()->json($response);
    }
}
