<?php

namespace App\Jobs\Fetches;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Items;

class FetchItems implements ShouldQueue
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
            
            $apiIds = Http::get('https://api.guildwars2.com/v2/items'); 
            $idList = $apiIds->json(); 
    
            $totalEntries = count($idList); 
            $totalPages = ceil($totalEntries / $perPage);
    
            $batch = array_chunk($idList, $perPage);
            
    
            while ($currentPage < $totalPages){
                $apiBatch = Http::get('https://api.guildwars2.com/v2/items?ids='.implode(',', $batch[$currentPage]));
                $batchList = $apiBatch->json(); 
    
                foreach($batchList as $item){
                    Items::updateOrCreate(
                        [
                            'id' => $item['id']
                        ],
                        [
                            'chat_link' => $item['chat_link'] ?? "",
                            'description' => $item['description'] ?? "",
                            'icon' => $item['icon'] ?? "",
                            'level' => $item['level'] ?? "",
                            'name' => $item['name'] ?? "",
                            'rarity' => $item['rarity'] ?? "",
                            'type' => $item['type'] ?? "",
                            'vendor_value' => $item['vendor_value'] ?? "",
                        ]
                    );
                }
                $currentPage++;
            }
        }
    }
}
