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
    public function favoriteResearchNote($buyOrderSetting, $favorites){
        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting);

        $favoritesArray = []; 

        if ($favorites != 'null'){
            $favoritesArray = json_decode($favorites); 
        }

        //dd($favoritesArray);
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

        //dd($researchNotes);
        return response()->json($researchNotes);
    }
    // *
    // * RESEARCH NOTES
    // *
    // * RETURN recipe value and research note value
    public function researchNote($buyOrderSetting, $filter){
        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting);
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
