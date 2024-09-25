<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // *
    // * GET SEARCH REQUESTS
    // *
    // * When users type in a search bar, it sends a request to find recipes that contain the name/keywords 
    // * Returns => array of search results
    public function searchRecipes(Request $request){
        $query = $request->input('request');
        // Combine the Recipes db and the Items db to get more info
        $recipes = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('name', 'like', '%'.$query.'%')
            ->select('name', 'icon', 'items.id', 'rarity')
            ->get()
            ->map(function ($recipe){
                return [
                    'name' => $recipe->name,
                    'icon' => $recipe->icon,
                    'id' => $recipe->id,
                    'rarity' => $recipe->rarity,
                ];
            })
            ->toArray();

        return response()->json($recipes);
    }

    // * GET RECIPE TREE
    //
    // 
    public function getRecipeTree($id, $quantity){
        $recipe = Recipes::where('output_item_id', $id)
        ->join('items', 'recipes.output_item_id', '=', 'items.id')
        ->get(); 

        //dd($recipe);

        return response()->json($recipe);
    }


    // * CALLED AS A REQUEST FROM THE USER VIA RECIPE FORMS
    // *
    // * Request = Name of the recipe => return recipe tree array
    public function getRecipeValues($request, $id, $quantity){
        // Decode the $request 
        // When users type in a request, it comes out as Sigil20%of20%Blood or something 
        $requestName = urldecode($request);
        
        // Combine the Recipes db and the Items db to get more info
        $recipe = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('items.name', $requestName)
            ->where('items.id', $id)
            ->first(); 

        //dd($recipe->name, $recipe['ingredients']);
        //dd($recipe['ingredients']);

        //dd($recipe['ingredients']);

        // To be returned
        // Start with index of 0 so that the output item is the first of the recipe tree displayed
        $returnArray = [
            "name" => $recipe['name'],
            "buy_price" => $recipe['buy_price'] * $recipe['output_item_count'] * $quantity,
            "sell_price" => $recipe['sell_price'] * $recipe['output_item_count'] * $quantity,
            "count" => $recipe['output_item_count'] * $quantity,
            "icon" => $recipe['icon'],
            "type" => $recipe['type'],
            "rarity" => $recipe['rarity'],
            "craftingValue" => 0,
            "preference" => 'TP',
        ];

        //dd($returnArray);

        $returnArray['ingredients'] = $this->addRecipeTreePrices($recipe, $quantity);
        //dd($returnArray);
        $returnArray['craftingValue'] = $this->calculateCraftingValue($returnArray); 
        //$returnArray['preference'] = $this->preferences($returnArray);
        
        if ($returnArray['craftingValue'] < $returnArray['buy_price'] && $returnArray['craftingValue'] < $returnArray['sell_price']){
            $returnArray['preference'] = 'Crafting';
        }
        if ($returnArray['buy_price'] == null && $returnArray['sell_price'] == null){
            $returnArray['preference'] = 'Crafting';
        }
        
        return response()->json($returnArray);
    }
    // First ingredients of recipe
    private function addRecipeTreePrices($recipe, $quantity){
        $newRecipeTree = []; 

        foreach ($recipe['ingredients'] as $ingredient){
            //dd($ingredient, $returnArray, $quantity);
            // Get ingredient info from the Items db
            $itemInfo = Items::where('id', $ingredient['id'])->first();
            //dd($itemInfo);
            //$returnArray = $ingredient;
            $ingredient['count'] *= $quantity; 
            $ingredient['buy_price'] = $itemInfo['buy_price'] * $ingredient['count'] * $quantity;
            $ingredient['sell_price'] = $itemInfo['sell_price'] * $ingredient['count'] * $quantity;
            //dd($ingredient);

            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['ingredients'] = $this->addRecipeTreePrices($ingredient, $quantity); 
            }
            $newRecipeTree[] = $ingredient; 
        }
        
        return $newRecipeTree; 

        //$this->exploreRecipeTreePrices($ingredient, $returnArray, $quantity); 
    }

    private function calculateCraftingValue(&$recipe){
        //dd($recipe);

        $value = 0;

        foreach ($recipe['ingredients'] as &$ingredient){
            $prevoiusCraftingValue = 0;
            //dd($ingredient);
            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['craftingValue'] = $this->calculateCraftingValue($ingredient); 
            } 
            if (array_key_exists('craftingValue', $ingredient)){
                $prevoiusCraftingValue = $ingredient['craftingValue'];
            } else {
                $prevoiusCraftingValue = min(
                    $ingredient['buy_price'],
                    $ingredient['sell_price']
                );
            }
            $value += $prevoiusCraftingValue;
            
        }
        //dd($value);
        return $value;
    }

    private function preferences(&$recipe){
        //dd($recipe);

        $preference = 'TP';

        foreach ($recipe['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['preference'] = $this->preferences($ingredient);
            }

            if (array_key_exists('craftingValue', $ingredient)){
                if ($ingredient['craftingValue'] < $ingredient['buy_price'] && $ingredient['craftingValue'] < $ingredient['sell_price']) {
                    $preference = 'Crafting';
                } else {
                    $preference = 'TP';
                }
            } else {
                $preference = 'TP';
            }
        }

        return $preference; 
    }


    public function calculateCraftingValueMERP(&$returnArray){
        $tempValue = 0; 

        foreach ($returnArray['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                $tempValue += $this->calculateCraftingValue($ingredient);
                $this->preferences($ingredient);
            } 
            else {
                if ($ingredient['buy_price'] < $ingredient['sell_price'] && $ingredient['buy_price'] != 0){
                    $tempValue += $ingredient['buy_price'];
                } 
                else if ($ingredient['buy_price'] > $ingredient['sell_price'] || ($ingredient['buy_price'] == 0 && $ingredient['sell_price'] != 0)) {
                    $tempValue += $ingredient['sell_price'];
                } 
                else {
                    $tempValue += 0;
                }
            }
        }
        return $returnArray['craftingValue'] = $tempValue;
    }

    public function bestTreePath(&$returnArray){
        $tempValue = 0; 

        foreach ($returnArray['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                switch ($ingredient['preference']){
                    case "TP":
                        if ($ingredient['buy_price'] < $ingredient['sell_price'] && $ingredient['buy_price'] != 0){
                            $tempValue += $ingredient['buy_price'];
                        } 
                        else if ($ingredient['buy_price'] > $ingredient['sell_price'] || ($ingredient['buy_price'] == 0 && $ingredient['sell_price'] != 0)) {
                            $tempValue += $ingredient['sell_price'];
                        } 
                        else {
                            $tempValue += 0;
                        }
                        $this->bestTreePath($ingredient);
                        break;
                    case "Crafting":
                        $tempValue += $this->bestTreePath($ingredient);
                        break;
                }
            } else {
                if ($ingredient['buy_price'] < $ingredient['sell_price'] && $ingredient['buy_price'] != 0){
                    $tempValue += $ingredient['buy_price'];
                } 
                else if ($ingredient['buy_price'] > $ingredient['sell_price'] || ($ingredient['buy_price'] == 0 && $ingredient['sell_price'] != 0)) {
                    $tempValue += $ingredient['sell_price'];
                } 
                else {
                    $tempValue += 0;
                }
            }
            
        }
        return $returnArray['craftingValue'] = $tempValue; 
    }

    
}
