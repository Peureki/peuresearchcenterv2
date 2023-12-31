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

        // To be returned
        // Start with index of 0 so that the output item is the first of the recipe tree displayed
        $returnArray[] = [
            "name" => $recipe['name'],
            "buy_price" => $recipe['buy_price'] * $recipe['output_item_count'] * $quantity,
            "sell_price" => $recipe['sell_price'] * $recipe['output_item_count'] * $quantity,
            "count" => $recipe['output_item_count'] * $quantity,
            "icon" => $recipe['icon'],
            "type" => $recipe['type'],
            "rarity" => $recipe['rarity'],
            "craftingValue" => 0,
            "preference" => null,
        ];

        
        // Foreach ingredient in a recipe, add their values, icons
        // This is the start of the recipe tree
        foreach ($recipe['ingredients'] as $index => $ingredient){
            $this->addRecipeTreePrices($ingredient, $returnArray[0]['ingredients'][$index], $quantity);  
        }

        //dd($returnArray);
        // After getting the whole recipe tree
        // CALCULATE each level of the tree by their crafting
        $this->calculateCraftingValue($returnArray[0]);
        $this->preferences($returnArray[0]);

        $this->bestTreePath($returnArray[0]);

        //dd($returnArray);
        
        return response()->json($returnArray);
    }
    // First ingredients of recipe
    private function addRecipeTreePrices($ingredient, &$returnArray, $quantity){
        // Get ingredient info from the Items db
        $itemInfo = Items::where('id', $ingredient['id'])->first();

        $returnArray = $ingredient;
        $returnArray['count'] = $ingredient['count'] * $quantity; 
        $returnArray['buy_price'] = $itemInfo['buy_price'] * $ingredient['count'] * $quantity;
        $returnArray['sell_price'] = $itemInfo['sell_price'] * $ingredient['count'] * $quantity;

        $this->exploreRecipeTreePrices($ingredient, $returnArray, $quantity); 
    }
    // Recipe tree beyond the first ingredients
    private function exploreRecipeTreePrices($ingredients, &$returnArray, $quantity){
        if (array_key_exists('ingredients', $ingredients)){
            foreach ($ingredients['ingredients'] as $index => $ingredient){
                // Get ingredient info from the Items db
                $itemInfo = Items::where('id', $ingredient['id'])->first();

                $returnArray['ingredients'][$index] = $ingredient;
                $returnArray['ingredients'][$index]['count'] = $ingredient['count'] * $quantity; 
                $returnArray['ingredients'][$index]['buy_price'] = $itemInfo['buy_price'] * $ingredient['count'] * $quantity;
                $returnArray['ingredients'][$index]['sell_price'] = $itemInfo['sell_price'] * $ingredient['count'] * $quantity;
                // Recusion if the recipe tree is greater than 2 levels
                $this->exploreRecipeTreePrices($ingredient, $returnArray['ingredients'][$index], $quantity);
            }
        } else {
            // Get ingredient info from the Items db
            $itemInfo = Items::where('id', $ingredients['id'])->first();

            $returnArray = $ingredients;
            $returnArray['count'] = $ingredients['count'] * $quantity; 
            $returnArray['buy_price'] = $itemInfo['buy_price'] * $ingredients['count'] * $quantity;
            $returnArray['sell_price'] = $itemInfo['sell_price'] * $ingredients['count'] * $quantity;
        }
    }


    public function calculateCraftingValue(&$returnArray){
        $tempValue = 0; 

        foreach ($returnArray['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                $tempValue += $this->calculateCraftingValue($ingredient);
                $this->preferences($ingredient);
            } else {
                if ($ingredient['buy_price'] < $ingredient['sell_price']){
                    $tempValue += $ingredient['buy_price'];
                } else if ($ingredient['buy_price'] > $ingredient['sell_price']) {
                    $tempValue += $ingredient['sell_price'];
                } else {
                    $tempValue += 0;
                }
            }
        }
        return $returnArray['craftingValue'] = $tempValue;
    }

    public function preferences(&$ingredient){
        if ($ingredient['craftingValue'] < $ingredient['buy_price'] || $ingredient['buy_price'] == 0){
            $ingredient['preference'] = 'Crafting';
        } else {
            $ingredient['preference'] = 'TP';
        }
    }

    public function bestTreePath(&$returnArray){
        $tempValue = 0; 

        foreach ($returnArray['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                switch ($ingredient['preference']){
                    case "TP":
                        if ($ingredient['buy_price'] < $ingredient['sell_price']){
                            $tempValue += $ingredient['buy_price'];
                        } else if ($ingredient['buy_price'] > $ingredient['sell_price']) {
                            $tempValue += $ingredient['sell_price'];
                        } else {
                            $tempValue += 0;
                        }
                        $this->bestTreePath($ingredient);
                        break;
                    case "Crafting":
                        $tempValue += $this->bestTreePath($ingredient);
                        break;
                }
            } else {
                if ($ingredient['buy_price'] < $ingredient['sell_price']){
                    $tempValue += $ingredient['buy_price'];
                } else if ($ingredient['buy_price'] > $ingredient['sell_price']) {
                    $tempValue += $ingredient['sell_price'];
                } else {
                    $tempValue += 0;
                }
            }
            
        }
        return $returnArray['craftingValue'] = $tempValue; 
    }

    
}
