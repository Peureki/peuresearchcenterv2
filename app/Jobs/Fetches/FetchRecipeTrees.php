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
        //$recipe = Recipes::find(14018);
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
                // Check if the OUTPUT_ITEM_COUNT is > 1 
                // If not, this causes recipe counts to be squared/grow expo for each recipe tree
                // This still keeps the main item output at the appropiate amount though, without change the ingredients
                // Ex: Super Veggie Pizza
                
                //dd($recipe, $recipe['ingredients']);

                $nestedRecipe = []; 

                if ($recipe['output_item_count'] > 1){
                    $nestedRecipe = $this->fetchRecipeTree($recipe, 1);
                } else {
                    $nestedRecipe = $this->fetchRecipeTree($recipe, $recipe['output_item_count']);
                }
                //dd($recipe, $nestedRecipe);

                Recipes::where('id', $recipe['id'])->update(['ingredients' => $nestedRecipe]);
            } 
        }
    }

    private function fetchRecipeTree($recipe, $parentCount){
        //dd($recipe, $recipe['ingredients']);
        $newRecipeTree = []; 

        foreach($recipe['ingredients'] as $index => $ingredient){
            // Set ingredients to $newRecipeTree
            $newRecipeTree[$index] = $ingredient;
            $newRecipeTree[$index]['count'] *= $parentCount; 

            if ($ingredient['type'] == 'Item'){     
                $newRecipeTree[$index]['name'] = Items::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Items::where('id', $ingredient['id'])->first()['icon'];
            } 
            if ($ingredient['type'] == 'Currency'){
                $newRecipeTree[$index]['name'] = Currencies::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Currencies::where('id', $ingredient['id'])->first()['icon'];
            }
            // Check if recipe of ingredient exists
            // If yes => then there's another branch for the tree
            $newRecipe = Recipes::where('output_item_id', $ingredient['id'])->first();
            //dd($newRecipe, $newRecipe['ingredients'], $ingredient);

            if ($newRecipe){
                if ($newRecipe['output_item_count'] > 1){
                    $newRecipeTree[$index]['ingredients'] = $this->fetchRecipeTree($newRecipe, 1); 
                } else {
                    $newRecipeTree[$index]['ingredients'] = $this->fetchRecipeTree($newRecipe, $ingredient['count'] * $parentCount);
                }
            }          
        }
        return $newRecipeTree;
    }
}
