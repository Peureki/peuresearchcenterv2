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
            ->select(
                'research_note.id as research_note_id',
                'research_note.*',
                'items.*'
            )
            ->get();
        $recipeController = new RecipeController();

        foreach ($recipes as $index => $recipe){
            $updateTreeWithValues = []; 
            $updateTreeWithValues = $recipeController->getRecipeValues($recipe['name'], 1); 
            $merp = json_decode($updateTreeWithValues->getContent());
            
            ResearchNotes::where('id', $recipe['research_note_id'])
                ->update(['crafting_value' => $merp[0]->crafting_value]);
            
            
        }
        
    }
}
