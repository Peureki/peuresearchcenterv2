<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Bag;
use App\Models\Bags;
use App\Models\CurrencyBagDropRates;
use App\Models\Recipes;
use App\Models\ResearchNotes;
use App\Models\SampleSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDO;

class CurrencyController extends Controller
{
    // *
    // * RESEARCH NOTES
    // *
    // * RETURN recipe value and research note value
    public function researchNote($buyOrderSetting, $filter){
        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting);
        $filteredArray = explode(',', $filter);
        // $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        // $tax = $this->getTax($tax);

        $filteredQuery = ResearchNotes::select('*')
            ->join('recipes', 'research_note.recipe_id', '=', 'recipes.id')
            ->join('items', 'research_note.item_id', '=', 'items.id')
            ->where('items.name', 'not like', '%Plaguedoctor%')
            ->whereIn('preference', $filteredArray)
            ->whereIn('items.type', $filteredArray)
            ->where(function ($query) use ($filteredArray) {
                foreach ($filteredArray as $item) {
                    $query->orWhereJsonContains('disciplines', $item);
                }
            });
 
        // Return Research Notes db 
        // Calculate crafting_value / avg_output and sort by that (cost/note column)
        $researchNotes = $filteredQuery
            ->orderByRaw("
                CASE 
                WHEN (items.buy_price = 0 AND items.sell_price = 0) OR (items.buy_price IS NULL OR items.sell_price IS NULL)
                    THEN crafting_value / avg_output
                WHEN '$buyOrderSetting' = 'buy_price' AND items.buy_price = 0
                    THEN crafting_value / avg_output
                WHEN '$buyOrderSetting' = 'buy_price' THEN
                    CASE 
                    WHEN items.buy_price < crafting_value 
                        THEN items.buy_price / avg_output
                        ELSE crafting_value / avg_output
                    END
                WHEN '$buyOrderSetting' = 'sell_price' THEN
                    CASE 
                    WHEN items.sell_price < crafting_value
                        THEN items.sell_price / avg_output
                        ELSE crafting_value / avg_output
                    END
                END
            ")
            ->paginate(50);

        return response()->json($researchNotes);

    }



    public function currencies($filter, $includes, $sellOrderSetting, $tax){
        // Goal
        // Get value of currencies
        // 
        // Calculate from currency_bag_drop_rates table of each Bag 
        // Get value of each Bag into bags table
        // ie Trophy Shipments 

        // GET CURRENCY DROP RATES
        // Join tables: currency_drop_rates + bags + items
        // Group by bag_id to separate 
        $filter = json_decode(urldecode($filter), true);
    
        $currencyDropRatesTable = CurrencyBagDropRates::join('bags', 'currency_bag_drop_rates.bag_id', '=', 'bags.id')
        ->join('items as item', 'currency_bag_drop_rates.item_id', '=', 'item.id')
        ->join('items as bag_item', 'bags.id', '=', 'bag_item.id')
        ->select(
            'currency_bag_drop_rates.*', 
            'bags.*', 
            'item.icon as item_icon',
            'item.name as item_name', 
            'item.*', 
            'bag_item.icon as bag_icon',
            'bag_item.name as bag_name'
        )
        ->whereIn('bags.category', $filter)
        ->get()
        ->groupBy('bag_id');

        // Turn Includes into an array
        $includes = json_decode($includes, true);

        // FOR BAGS THAT HAVE MULTIPLE CONVERSIONS OF THE SAME BAG
        // Check specific bag that has the multiple conversions
        // Get the ID of the bag 
        // Add bag_name to the collection of the original bag
        // Clone bag
        // Add bag_name to the new one to differentiate 
        if (in_array("Unbound Magic", $filter)){
            foreach ($currencyDropRatesTable as $key => $bag){
                if ($key == 79186){
                    $bag->bag_name = "Magic-Warped Bundle (Ember Bay)";
                    // Duplicate entry in collection
                    $duplicatedBag = clone $bag; 
                    $duplicatedBag->bag_name = "Magic-Warped Bundle (Rest)";
                    $currencyDropRatesTable->push($duplicatedBag);
                }
            }
        }
        if (in_array("Imperial Favor", $filter)){

        }

        $bag = []; 

        // Check if $filter has two or more currencies attached
        // If yes => create a new $filter array separating the two 
        // If no => continue
        if (strpos($filter[0], ',') == true){
            $filter = explode(",", $filter[0]); 
        }

        foreach ($currencyDropRatesTable as $key => $group){
            // Check if group contains the attribute "bag_name" for bags with multiple conversions 
            if (isset($group->bag_name)){
                $bagName = $group->bag_name; 
            } else {
                $bagName = '';
            }
            // Variables pushed into $bag array to display additional info for the frontend
            $value = 0;
            $total = 0;
            $icon = '';
            $fee = 0;
            $profitPerBag = 0; 
            $currency = '';

            // Initialize as an array to potentially store more than 1 currency for a bag
            // ie Trade Crates use Trade Contracts && Karma
            $currencyPerBag = [0];
            $costOfCurrencyPerBag = [-1]; 

            foreach ($group as $item){
                if ($item->type == "Container" && strpos($item->description, 'Salvage') === false){
                    $value = $this->getContainerValue($item->item_id, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                } 
                else if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                    $value = $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax); 
                }
                // ASCENDED JUNK
                else if ($item->rarity == 'Ascended' && $item->type == 'CraftingMaterial' && in_array('AscendedJunk', $includes)) {
                    // There's a lot of ascended and crafteringMaterials so switch the $item->name to check for specifically the ascended junk
                    switch ($item->name){
                        case 'Dragonite Ore':
                            $value = $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                            break;
                    }
                }
                else {
                    $value = ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
                }
                
                
                $item->value = $value; 
                $total += $value; 
                // If it's not a specific bag, then declare the current bag name
                if ($bagName == ''){
                    $bagName = $item->bag_name; 
                }
                $icon = $item->bag_icon; 
                $currency = $filter;
                
            }  

            // * IMPORTANT
            // THIS IS WHERE YOU ADD/UPDATE CURRENCY FEES OR COSTS FOR EACH BAG
            switch (true){
                case in_array('Imperial Favor', $filter):
                    $fee = 0;
                    $costOfCurrencyPerBag[0] = 200;
                    break;

                case in_array('Laurel', $filter):
                    $fee = 0;
                    $costOfCurrencyPerBag[0] = 1;
                    break;
            
                case in_array('Volatile Magic', $filter):
                    $fee = 10000; 
                    $costOfCurrencyPerBag[0] = 250;
                    
                    break;
                
                case in_array('Unbound Magic', $filter): 
                    if ($bagName == 'Magic-Warped Packet'){
                        $fee = 5000;
                        $costOfCurrencyPerBag[0] = 250; 
                    }
                    if ($bagName == 'Magic-Warped Bundle (Ember Bay)'){
                        $fee = 4000;
                        $costOfCurrencyPerBag[0] = 1250; 
                    }
                    if ($bagName == 'Magic-Warped Bundle (Rest)'){
                        $fee = 10000;
                        $costOfCurrencyPerBag[0] = 500;
                    }
                    break;

                case in_array('Trade Contract', $filter):
                    $costOfCurrencyPerBag[0] = 50;

                    if (in_array('Karma', $filter)){
                        $costOfCurrencyPerBag[1] = 630; 
                    }
                    break;
            }
            // Final calculations per bag
            $profitPerBag = $total - $fee; 

            foreach ($costOfCurrencyPerBag as $index => $currencyCost){
                $currencyPerBag[$index] = $profitPerBag / $currencyCost; 
            }
            

            array_push($bag, [
                'total' => $total,
                'name' => $bagName,
                'icon' => $icon,
                'fee' => $fee,
                'profitPerBag' => $profitPerBag,
                'currency' => $currency,
                'currencyPerBag' => $currencyPerBag,
                'costOfCurrencyPerBag' => $costOfCurrencyPerBag,  
            ]);
        }

        // Reindex array otherwise it would start at bag_id 
        // ie Unbound Magic's bag id's are 6, 7
        // dropRates's indexes would be 6, 7 instead of 0, 1
        $currencyDropRatesTable = $currencyDropRatesTable->values();
        

        $response = [
            'dropRates' => $currencyDropRatesTable,
            'bag' => $bag,
        ];
        
        return response()->json($response);
    }

    public function getSpiritShards($buyOrderSetting, $sellOrderSetting, $tax){
        $jsonFilePath = base_path("resources/js/vue/components/json/recipes.json");
        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting); 
        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        // >> OUTPUT MATERIAL LIST
        foreach ($data as &$outputList){

            // >> OUTPUT MATERIAL
            foreach ($outputList as &$outputMat){
                // Initialize final values
                $profitPerConversion = 0;
                $profitPerSpiritShard = 0;
                $philosopherStone = 0;
                $mysticCrystal = 0;
                // Get more info out of the output items via Items table
                $outputInfo = Items::where('id', $outputMat['id'])->get()[0];

                // Set up a new property 'value' with the sellOrderSetting * output amount
                $outputMat['value'] = $outputInfo->$sellOrderSetting * $outputMat['count'] * $tax; 

                // >> INDIVIDUAL INGREDIENTS
                foreach ($outputMat['ingredients'] as $key => &$ingredient){
                    // Get more info out of the individual ingredient items via Items table
                    $ingredientInfo = Items::where('id', $ingredient['id'])->get()[0]; 
                    
                    // Get the icon and set a new value property with the buyOrderSetting
                    $ingredient['name'] = $ingredientInfo->name;
                    $ingredient['icon'] = $ingredientInfo->icon; 
                    $ingredient['value'] = $ingredientInfo->$buyOrderSetting * $ingredient['count'] * $tax;
                    // For each ingredient, add each of their values for the profit/conversion
                    $profitPerConversion += $ingredient['value']; 
                    // Check if the ingredient is a spirit shard item
                    if ($ingredient['name'] == "Philosopher's Stone"){
                        $philosopherStone = $ingredient['count'] / 10; 
                    }
                    if ($ingredient['name'] == "Mystic Crystal"){
                        $mysticCrystal = $ingredient['count'] * 0.6;
                    }
                }
                $profitPerConversion = $outputMat['value'] - $profitPerConversion; 
                $profitPerSpiritShard = $profitPerConversion / ($philosopherStone + $mysticCrystal);

                $outputMat['profitPerConversion'] = $profitPerConversion; 
                $outputMat['profitPerSpiritShard'] = $profitPerSpiritShard;
            }
        }
        return response()->json($data);
    }

    
}
