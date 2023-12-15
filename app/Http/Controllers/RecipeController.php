<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    public function searchRecipes(Request $request){
        // Combine the Recipes db and the Items db to get more info
        // $recipes = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
        //     ->select("recipes.*", 'items.*')
        //     ->get();
        

        $query = $request->input('request');

        $recipes = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('name', 'like', '%'.$query.'%')
            ->pluck('name', 'icon')
            ->map(function ($name, $icon){
                return [
                    'name' => $name,
                    'icon' => $icon,
                ];
            })
            ->toArray();

        return response()->json($recipes);
    }
    // * CALLED AS A REQUEST FROM THE USER VIA RECIPE FORMS
    // *
    // * Request = Name of the recipe => return recipe tree array
    public function getRecipeValues($request, $quantity){
        // Decode the $request 
        // When users type in a request, it comes out as Sigil20%of20%Blood or something 
        $requestName = urldecode($request);
        
        // Combine the Recipes db and the Items db to get more info
        $recipe = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('items.name', $requestName)
            ->first(); 

        // To be returned
        // Start with index of 0 so that the output item is the first of the recipe tree displayed
        $returnArray[] = [
            "name" => $recipe['name'],
            "buy_price" => $recipe['buy_price'] * $quantity,
            "sell_price" => $recipe['sell_price'] * $quantity,
            "count" => $recipe['output_item_count'] * $quantity,
            "icon" => $recipe['icon'],
            "type" => $recipe['type'],
        ];

        
        // Foreach ingredient in a recipe, add their values, icons
        foreach ($recipe['ingredients'] as $index => $ingredient){
            $this->addRecipeTreePrices($ingredient, $returnArray[0]['ingredients'][$index], $quantity);  
        }

        // After getting the whole recipe tree
        // CALCULATE each level of the tree by their crafting
        $this->calculateRecipeTree($returnArray[0]);

        //dd($returnArray);
        
        return response()->json($returnArray);
    }
    // First ingredients of recipe
    private function addRecipeTreePrices($ingredient, &$returnArray, $quantity){
        
        $returnArray = $ingredient;
        $returnArray['count'] = $ingredient['count'] * $quantity; 
        $returnArray['buy_price'] = Items::where('id', $ingredient['id'])->first()['buy_price'] * $ingredient['count'] * $quantity;
        $returnArray['sell_price'] = Items::where('id', $ingredient['id'])->first()['sell_price'] * $ingredient['count'] * $quantity;

        $this->exploreRecipeTreePrices($ingredient, $returnArray, $quantity); 
    }
    // Recipe tree beyond the first ingredients
    private function exploreRecipeTreePrices($ingredients, &$returnArray, $quantity){
        if (array_key_exists('ingredients', $ingredients)){
            foreach ($ingredients['ingredients'] as $index => $ingredient){
                $returnArray['ingredients'][$index] = $ingredient;
                $returnArray['ingredients'][$index]['count'] = $ingredient['count'] * $quantity; 
                $returnArray['ingredients'][$index]['buy_price'] = Items::where('id', $ingredient['id'])->first()['buy_price'] * $ingredient['count'] * $quantity;
                $returnArray['ingredients'][$index]['sell_price'] = Items::where('id', $ingredient['id'])->first()['sell_price'] * $ingredient['count'] * $quantity;
                // Recusion if the recipe tree is greater than 2 levels
                $this->exploreRecipeTreePrices($ingredient, $returnArray['ingredients'][$index], $quantity);
            }
        } else {
            $returnArray = $ingredients;
            $returnArray['count'] = $ingredients['count'] * $quantity; 
            $returnArray['buy_price'] = Items::where('id', $ingredients['id'])->first()['buy_price'] * $ingredients['count'] * $quantity;
            $returnArray['sell_price'] = Items::where('id', $ingredients['id'])->first()['sell_price'] * $ingredients['count'] * $quantity;
        }
    }
    // * CALCULATE RECIPE **TREE**
    // *
    // *
    private function calculateRecipeTree(&$returnArray){
        // Check if the current ingredient has a tree
        if (array_key_exists('ingredients', $returnArray)){
            // If yes => calculate crafting value from the tree
            $returnArray['craftingValue'] = $this->calculateRecipeLevel($returnArray['ingredients']);
            // Go through the tree and repeat process until the tree line stops
            foreach ($returnArray['ingredients'] as $index => $ingredient){
                $this->calculateRecipeTree($returnArray['ingredients'][$index]);
            }
        // If no tree => return 0
        } else {
            $returnArray['craftingValue'] = 0;
        }
    }
    // * CALCULATE RECIPE **INDIVIDUAL LEVEL**
    // *
    // *
    private function calculateRecipeLevel($recipeLevel){
        $value = 0;
        // Go through each ingredient under the tree and add values
        foreach ($recipeLevel as $ingredient){
            if ($ingredient['buy_price'] != 0){
                $value += $ingredient['buy_price'];
            } else {
                $value += $ingredient['sell_price'];
            }
        }
        return $value; 
    }

    
}
