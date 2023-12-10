<?php

namespace App\Jobs\Fetches;

use App\Models\Currencies;
use App\Models\Items;
use App\Models\Recipes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchRecipeTrees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recipes = Recipes::get();
        // AGONY RESISTATANCE beyond +10
        // Because Agony has a recipe on top of a recipe the higher you go, by +17, it broke mySQL
        $restrictedIDs = [
            49434,
            49435,
            49436,
            49437,
            49438,
            49439,
            49440,
            49441,
            49442,
            49443,
            49444,
            49445,
            49446,
            49447,
        ];
        // Go through each recipe and fetch any recipe trees
        foreach ($recipes as $recipe){
            $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
            // Check if the output item exist and check if it's restricted
            if ($itemsIDExists && !in_array($recipe['output_item_id'], $restrictedIDs)){
                $this->fetchRecipeTree($recipe, $recipe['output_item_count']);
            } 
        }
    }

    private function fetchRecipeTree($recipe, $parentCount){
        // Create an empty array to replace regular recipes with the nested recipe
        $nestedRecipe = [];

        // For each recipe ingredient -> check if there's a recipe tree
        foreach ($recipe['ingredients'] as $index => $ingredient){
            $this->checkRecipeTree($ingredient, $parentCount, $nestedRecipe[$index]);
        }
        // After returning the $nestedRecipe, add it to the db
        Recipes::where('id', $recipe['id'])
            ->update(['ingredients' => $nestedRecipe]);
    }
    // Check if there is a nested recipe within the current ingredient
    private function checkRecipeTree($ingredient, $parentCount, &$nestedRecipe){
        $recipe = Recipes::where('output_item_id', $ingredient['id']); 
        $nestedRecipe = $ingredient;
        // Check if the ingredient is an item or currency
        switch ($ingredient['type']){
            case "Item": 
                $nestedRecipe['name'] = Items::where('id', $ingredient['id'])->first()['name'] ?? ""; 
                $nestedRecipe['icon'] = Items::where('id', $ingredient['id'])->first()['icon'] ?? ""; 
                break;
            case "Currency":
                $nestedRecipe['name'] = Currencies::where('id', $ingredient['id'])->first()['name'] ?? ""; 
                $nestedRecipe['icon'] = Currencies::where('id', $ingredient['id'])->first()['icon'] ?? ""; 
                break;
        }
        $nestedRecipe['count'] *= $parentCount; 
        
        // If yes, explore and use recursion on the ingredients to see how far the tree goes
        if ($recipe->exists()){
            $nestedRecipe['ingredients'] = $recipe->first()['ingredients'];
            $this->exploreRecipeTree($recipe->first(), $nestedRecipe['count'], $nestedRecipe);
        }

        return $nestedRecipe;
    }
    private function exploreRecipeTree($recipe, $parentCount, &$nestedRecipe){
        foreach ($recipe['ingredients'] as $index => $ingredient){
            $component = Recipes::where('output_item_id', $ingredient['id']);
            // Check if the ingredient is an item or currency
            switch ($ingredient['type']){
                case "Item":
                    $nestedRecipe['ingredients'][$index]['name'] = Items::where('id', $ingredient['id'])->first()['name'] ?? ""; 
                    $nestedRecipe['ingredients'][$index]['icon'] = Items::where('id', $ingredient['id'])->first()['icon'] ?? "";
                    break;
                case "Currency":
                    $nestedRecipe['ingredients'][$index]['name'] = Currencies::where('id', $ingredient['id'])->first()['name'] ?? ""; 
                    $nestedRecipe['ingredients'][$index]['icon'] = Currencies::where('id', $ingredient['id'])->first()['icon'] ?? "";
            }
            $nestedRecipe['ingredients'][$index]['count'] *= $parentCount; 
            
    
            if ($component->exists()){
                // Update the nested ingredients at the specific index
                $nestedRecipe['ingredients'][$index]['ingredients'] = $component->first()['ingredients'];
                // Recursively explore further nested recipes
                $this->exploreRecipeTree($component->first(), $nestedRecipe['ingredients'][$index]['count'], $nestedRecipe['ingredients'][$index]);
            }
        }
        return $nestedRecipe;
    }
}
