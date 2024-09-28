<?php

namespace App\Jobs\Fetches;

use App\Models\Items;
use App\Models\OtherRecipe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchOtherRecipes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jsonFilePath = base_path("resources/js/vue/components/json/recipes.json");
        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        $dataCollection = collect($data); 

        foreach ($dataCollection as $index => $entry){
            if (Items::where('id', $entry['output_item_id'])->exists() && $entry['disciplines'][0] == 'Mystic Forge'){
                //dd($entry['ingredients']);
                OtherRecipe::updateOrCreate(
                    [
                        'id' => $index
                    ],
                    [
                        'output_item_id' => $entry['output_item_id'],
                        'disciplines' => $entry['disciplines'] ?? null,
                        'merchant' => $entry['merchant'] ?? null,
                        'name' => $entry['name'] ?? null,
                        'output_item_count' => $entry['output_item_count'] ?? 1,
                        'merchant_data_hash' => $entry['merchant_data_hash'] ?? null,
                        'ingredients' => $entry['ingredients'],
                    ]
                );
            }
            
        }
    }
}
