<?php

namespace App\Jobs\Fetches;

use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchAchievements implements ShouldQueue
{
    use Queueable;

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
        $this->fetchAchievements();
    }

    /*
        *
        * ACHIEVEMENTS
        *
        * Fetch all the achievements from the GW2 API to the achievements database
        *
    */
    protected function fetchAchievements(): void{
        $perPage = 200; 
        $currentPage = 0;
        
        $apiIds = Http::get('https://api.guildwars2.com/v2/achievements?'); 
        $idList = $apiIds->json(); 

        $totalEntries = count($idList); 
        $totalPages = ceil($totalEntries / $perPage);

        $batch = array_chunk($idList, $perPage);

        while ($currentPage < $totalPages){
            $apiBatch = Http::get('https://api.guildwars2.com/v2/achievements?ids='.implode(',', $batch[$currentPage]));
            $batchList = $apiBatch->json(); 

            foreach($batchList as $achievement){
                Achievement::updateOrCreate(
                    [
                        'id' => $achievement['id'],
                    ],
                    [   
                        'icon' => $achievement['icon'] ?? null,
                        'name' => $achievement['name'] ?? null,
                        'description' => $achievement['description'] ?? null,
                        'requirement' => $achievement['requirement'] ?? null,
                        'locked_text' => $achievement['locked_text'] ?? null,
                        'type' => $achievement['type'] ?? null,
                        'flags' => $achievement['flags'] ?? null,
                        'tiers' => $achievement['tiers'] ?? null,
                        'prerequisites' => $achievement['prerequisites'] ?? null,
                        'rewards' => $achievement['rewards'] ?? null,
                        'bits' => $achievement['bits'] ?? null,
                        'point_cap' => $achievement['point_cap'] ?? null,
                    ],
                );
            }
            $currentPage++;
        }
    }
}
