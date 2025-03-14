<?php

namespace App\Jobs\Fetches;

use App\Http\Controllers\RecipeController;
use App\Models\Items;
use App\Models\Recipes;
use App\Models\ResearchNotes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class FetchRecipeValues implements ShouldQueue
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
        // Combine the Recipes db and the Items db to get more info
        $recipes = ResearchNotes::join('items', 'research_note.item_id', '=', 'items.id')
            ->join('recipes', 'research_note.recipe_id', '=', 'recipes.id')
            ->select(
                'research_note.id as research_note_id',
                'research_note.*',
                'items.*',
                'recipes.*'
            )
            ->get();
        $recipeController = new RecipeController();

        foreach ($recipes as $index => $recipe){
            //dd($recipe);
            $updateTreeWithValues = []; 
            // true = SKIP OtherRecipe check
            $updateTreeWithValues = $recipeController->getRecipeValues($recipe['name'], $recipe['item_id'], $recipe['recipe_id'],  1, true); 

            $recipeTree = json_decode($updateTreeWithValues->getContent());
            ResearchNotes::where('id', $recipe['research_note_id'])
                ->update([
                    'crafting_value' => $recipeTree->craftingValue,
                    'preference' => $recipeTree->preference,
                    'recipe_materials' => $recipeTree->recipe_materials,
                ]);
        }
        
    }
}
