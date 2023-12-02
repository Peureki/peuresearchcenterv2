<?php

namespace App\Jobs\Fetches;

use App\Models\Items;
use App\Models\Recipes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchRecipes implements ShouldQueue
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
        // $perPage = 200; 
        // $currentPage = 0;
        
        // $apiIds = Http::get('https://api.guildwars2.com/v2/recipes?v=2022-03-09T02:00:00.000Z'); 
        // $idList = $apiIds->json(); 

        // $totalEntries = count($idList); 
        // $totalPages = ceil($totalEntries / $perPage);

        // $batch = array_chunk($idList, $perPage);

        // while ($currentPage < $totalPages){
        //     $apiBatch = Http::get('https://api.guildwars2.com/v2/recipes?ids='.implode(',', $batch[$currentPage]).'&v=2022-03-09T02:00:00.000Z');
        //     $batchList = $apiBatch->json(); 

        //     foreach($batchList as $recipe){
        //         // For some reason, there are some output items that do not exist? 
        //         // Check for that
        //         $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
                

        //         if (array_key_exists('guild_ingredients', $recipe)){
        //             $guildIngredients = $recipe['guild_ingredients'];
        //         } else {
        //             $guildIngredients = [];
        //         }

        //         if ($itemsIDExists){
        //             Recipes::updateOrCreate(
        //                 [
        //                     'id' => $recipe['id']
        //                 ],
        //                 [
        //                     'type' => $recipe['type'],
        //                     'output_item_id' => $recipe['output_item_id'],
        //                     'output_item_count' => $recipe['output_item_count'],
        //                     'time_to_craft_ms' => $recipe['time_to_craft_ms'],
        //                     'disciplines' => $recipe['disciplines'],
        //                     'min_rating' => $recipe['min_rating'],
        //                     'flags' => $recipe['flags'],
        //                     'ingredients' => $recipe['ingredients'],
        //                     'guild_ingredients' => $guildIngredients,
        //                     'chat_link' => $recipe['chat_link'],
        //                 ]
        //             );
        //         }
        //     }
        //     $currentPage++;
        // }

        $recipes = Recipes::get(); 
        // Go through all recipes
        foreach ($recipes as $recipe){
            //dd($recipe);
            $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
            if ($itemsIDExists){
                $this->fetchRecipeTree($recipe);
            }
            
        }
    }

    private function fetchRecipeTree($recipe){
        $nestedRecipe = '';
        // Go through each recipe's ingredients
        foreach ($recipe['ingredients'] as $ingredient){
            $this->checkRecipeTree($ingredient, $nestedRecipe);
        }
        if ($nestedRecipe != ''){
            Recipes::where('id', $recipe['id'])
                ->update(['ingredients' => $nestedRecipe]);
        }
        
    }
    // Check if there is a nested recipe within the current ingredient
    private function checkRecipeTree($ingredient, &$nestedRecipe){
        $recipe = Recipes::where('output_item_id', $ingredient['id']); 
        // If yes, explore and use recursion on the ingredients to see how far the tree goes
        if ($recipe->exists()){
            $nestedRecipe = $ingredient;
            $nestedRecipe['ingredients'] = $recipe->first()['ingredients'];
            
            $this->exploreRecipeTree($recipe->first(), $nestedRecipe);
        } else {
            return; 
        }
    }
    private function exploreRecipeTree($recipe, &$nestedRecipe){
        foreach ($recipe['ingredients'] as $index => $ingredient){
            $component = Recipes::where('output_item_id', $ingredient['id']);
    
            if ($component->exists()){
                // Update the nested ingredients at the specific index
                $nestedRecipe['ingredients'][$index]['ingredients'] = $component->first()['ingredients'];
                //dd($nestedRecipe);
                // Recursively explore further nested recipes
                $this->exploreRecipeTree($component->first(), $nestedRecipe['ingredients'][$index]);
            }
        }

        return $nestedRecipe;
    }
}
// TypeError: Cannot access offset of type string on string in C:\xampp\htdocs\peuresearchcenterv2\app\Jobs\Fetches\FetchRecipes.php:108


