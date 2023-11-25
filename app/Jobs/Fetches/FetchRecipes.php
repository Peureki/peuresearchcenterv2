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
        {
            $perPage = 200; 
            $currentPage = 0;
            
            $apiIds = Http::get('https://api.guildwars2.com/v2/recipes'); 
            $idList = $apiIds->json(); 
    
            $totalEntries = count($idList); 
            $totalPages = ceil($totalEntries / $perPage);
    
            $batch = array_chunk($idList, $perPage);
            
    
            while ($currentPage < $totalPages){
                $apiBatch = Http::get('https://api.guildwars2.com/v2/recipes?ids='.implode(',', $batch[$currentPage]));
                $batchList = $apiBatch->json(); 
    
                foreach($batchList as $recipe){
                    $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
                    if ($itemsIDExists){
                        Recipes::updateOrCreate(
                            [
                                'id' => $recipe['id']
                            ],
                            [
                                'type' => $recipe['type'],
                                'output_item_id' => $recipe['output_item_id'],
                                'output_item_count' => $recipe['output_item_count'],
                                'time_to_craft_ms' => $recipe['time_to_craft_ms'],
                                'disciplines' => $recipe['disciplines'],
                                'min_rating' => $recipe['min_rating'],
                                'flags' => $recipe['flags'],
                                'ingredients' => $recipe['ingredients'],
                                'guild_ingredients' => $recipe['guild_ingredients'],
                                'chat_link' => $recipe['chat_link'],
                            ]
                        );
                    }
                    
                }
                $currentPage++;
            }
        }
    }
}
