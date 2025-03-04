<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Bag;
use App\Models\BagDropRate;
use App\Models\Bags;
use App\Models\ChoiceChest;
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
    // * GET ALL DRIZZLEWOOD COMMENDATION VALUES
    // * 
    // * Calculate each individual currencies then 
    // * RETURN array of the commendations
    // *
    public function getAllCommendationValues($includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        // New accounts that haven't set any settings may still have "null"
        if ($includes == "null"){
            $includes = [];
        } else {
            $includes = json_decode($includes);
        }

        

        $commendationIDs = [
            [
                'id' => 93525, // Ash Legion 
                'achievementID' => 5327,
                'repeatableAchievementID' => 5338,
            ],
            [
                'id' => 93625, // Blood Legion
                'achievementID' => 5312,
                'repeatableAchievementID' => 5278,
            ],
            [
                'id' => 93496, // Flame Legion
                'achievementID' => 5319,
                'repeatableAchievementID' => 5334,
            ],
            [
                'id' => 93624, // Iron Legion
                'achievementID' => 5298,
                'repeatableAchievementID' => 5286,
            ],
            [
                'id' => 93868, // Dominion
                'achievementID' => 5403,
                'repeatableAchievementID' => 5391,
            ],
            [
                'id' => 93899, // Frost Legion
                'achievementID' => 5364,
                'repeatableAchievementID' => 5356,
            ],
        ];

        $onlyCommendationIDList = array_column($commendationIDs, 'id');
        $commendationDB = Items::whereIn('id', $onlyCommendationIDList)->get();

        $response = []; 

        // Set maps for achievement IDs to input them into the $commendationDB collection
        $idToAchievementMap = array_column($commendationIDs, 'achievementID', 'id');
        $idToRepeatableAchievementMap = array_column($commendationIDs, 'repeatableAchievementID', 'id'); 
        
        // Treat commendations as if it was a bag since it has a collection of items in the reward track
        $bagController = new BagController(); 

        foreach ($commendationDB as $index => $commendation){
            // Input achievement_id & repeatable_achievement_id as property
            if (isset($idToAchievementMap[$commendation->id])){
                $commendation->achievement_id = $idToAchievementMap[$commendation->id];
                $commendation->repeatable_achievement_id = $idToAchievementMap[$commendation->id];
            }
            if (isset($idToRepeatableAchievementMap[$commendation->id])){
                $commendation->repeatable_achievement_id = $idToRepeatableAchievementMap[$commendation->id];
            }

            $requestedBags = []; 
            $commendationName = $commendation->name; 
            // $response[] = $bagController->exchangeables($commendation, $includes, $sellOrderSetting, $tax)->original; 
            // Check if $request matches with one of the $map
            // Populate arrays
            if (isset($this->exchangeableMap[$commendationName])){
                $data = $this->exchangeableMap[$commendationName]; 
                $requestedBags = array_merge($requestedBags, $data['id']);
                $outputQty = $data['outputQty'];
            }


            $bagsDB = Bag::whereIn('id', $requestedBags)->get(); 
            //$bagsDB = $bagController->getBagValues($requestedBags, $includes, $sellOrderSetting, $tax); 

            //dd('bagDB: ', $bagsDB);

            $choiceDB = ChoiceChest::whereIn('id', $requestedBags)->get(); 
            //$choiceDB = $bagController->getChoiceChestValues($requestedBags, $includes, $sellOrderSetting, $tax); 


            // Map the retrieved bags and choice chests back to the original $requestedBags array
            $responseCollection = collect($requestedBags)->map(function ($id) use ($bagsDB, $choiceDB) {
                return $bagsDB->firstWhere('id', $id) ?: $choiceDB->firstWhere('id', $id);
            });

            //dd($responseCollection, $outputQty);

            // For any empty or 'null' indexes in $responseCollection means they were not found in Bags:: or ChoiceChest:: so they must be an individual Item::
            // Fill those indexes 

            // Initialize commendation value
            $totalRewardTrackValue = 0;

            foreach ($responseCollection as $index => &$item){

                if (!$item){
                    $responseCollection[$index] = Items::where('id', $requestedBags[$index])->get()->first(); 
                    $responseCollection[$index]['value'] = $responseCollection[$index][$sellOrderSetting] * $outputQty[$index] ?? 0; 
                } 
                else {
                    switch ($item->getTable()){
                        case 'bags':    
                            //dd($item);                 
                            $responseCollection[$index] = $bagController->getBagCollection($item->id, $outputQty[$index], $includes, $sellOrderSetting, $tax); 

                            //dd($responseCollection[$index], $item);
                            break;

                        case 'choice_chests':
                            $responseCollection[$index] = $bagController->getChoiceChestCollection($item->id, $outputQty[$index], $includes, $sellOrderSetting, $tax); 
                            break;
                    }
                }

                $responseCollection[$index]['quantity'] = $outputQty[$index]; 
                $totalRewardTrackValue += $responseCollection[$index]['value']; 
            }

            $responseCollection['id'] = $commendation->id;
            $responseCollection['achievementID'] = $commendation->achievement_id; 
            $responseCollection['repeatableAchievementID'] = $commendation->repeatable_achievement_id; 
            $responseCollection['name'] = $commendationName; 
            $responseCollection['icon'] = $commendation->icon; 
            $responseCollection['trackValue'] = $totalRewardTrackValue; 
            $responseCollection['value'] = $totalRewardTrackValue/5000;

            $response[] = $responseCollection; 
            //dd('requested bags: ', $requestedBags, 'bagsDB: ', $bagsDB, 'choiceDB: ', $choiceDB, 'commendationDB: ', $responseCollection);
            
        }

        //dd($response); 

        return response()->json($response);
    }

    public function favoriteResearchNote($buyOrderSetting, $favorites){
        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting);

        $favoritesArray = []; 

        if ($favorites != 'null'){
            $favoritesArray = json_decode($favorites); 
        }

        $researchNotes = []; 

        //dd($favoritesArray);
        if ($favoritesArray){
            $favoritesQuery = ResearchNotes::select('*')
                ->join('recipes', 'research_note.recipe_id', '=', 'recipes.id')
                ->join('items', 'research_note.item_id', '=', 'items.id')
                ->whereIn('output_item_id', $favoritesArray);

            $researchNotes = $favoritesQuery
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
                ")->get(); 

            // Add 'favorite' property so that the heart symbol in the frontend can be filled to indicate the user has favorited this item
            $researchNotes->each(function ($researchNote){
                $researchNote->favorite = true;
            });
        }
        

        

        //dd($researchNotes);
        return response()->json($researchNotes);
    }
    // *
    // * RESEARCH NOTES
    // *
    // * RETURN recipe value and research note value
    public function researchNote($buyOrderSetting, $filter, $material){
        // $filter might be "null" for users
        // By default, start with an empty array
        $filteredArray = []; 
        // Unless it's not "null", then use the settings the user has chosen
        if ($filter != "null"){
            $filteredArray = json_decode($filter);
        } 


        //dd($filteredArray, $filter);
        

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

        if ($material !== "null" && $material !== null){
            $filteredQuery->whereRaw('JSON_CONTAINS(research_note.recipe_materials, ?)', ['[' . $material . ']']);
        }

        //$merp = ResearchNotes::get(); 

        // foreach($merp as $derp){
        //     dd($derp);
        // }
        // //dd($merp);
        // dd($material);
    
        // Return Research Notes db 
        // Calculate crafting_value / avg_output and sort by that (cost/note column)
        $researchNotes = $filteredQuery
            ->orderByRaw("
                CASE 
                    -- First, check if the crafting value is less than both buy and sell prices
                    WHEN crafting_value < items.buy_price AND crafting_value < items.sell_price 
                        THEN crafting_value / avg_output

                    -- If buy order is 'buy_price', return buy price
                    WHEN '$buyOrderSetting' = 'buy_price' 
                        THEN CASE 
                            WHEN items.buy_price != 0 
                            THEN items.buy_price / avg_output
                            ELSE crafting_value / avg_output
                        END

                    -- If buy order is 'sell_price', return sell price
                    WHEN '$buyOrderSetting' = 'sell_price' 
                        THEN CASE 
                            WHEN items.sell_price != 0 
                            THEN items.sell_price / avg_output
                            ELSE crafting_value / avg_output
                        END

                    -- Catch cases where buy or sell prices are zero or null, default to crafting value
                    WHEN (items.buy_price = 0 AND items.sell_price = 0) OR (items.buy_price IS NULL OR items.sell_price IS NULL)
                        THEN crafting_value / avg_output
                END
            ")
            ->paginate(50);

            //dd($researchNotes);

        return response()->json($researchNotes);

    }

    public function getSpiritShards($buyOrderSetting, $sellOrderSetting, $tax){
        $jsonFilePath = base_path("resources/js/vue/components/json/spiritShard.json");
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
                    $ingredient['value'] = $ingredientInfo->$buyOrderSetting * $ingredient['count'];
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
