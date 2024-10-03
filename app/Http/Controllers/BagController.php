<?php

namespace App\Http\Controllers;

use App\Models\BagDropRate;
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
        

        $response = []; 
        $bag = [];
        $conversionToggle = false; 

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
