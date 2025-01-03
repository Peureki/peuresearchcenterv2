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
        $this->addCustomAchievements();
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
    // *
    // * ADD CUSTOM ACHIEVEMENTS
    // * 
    // * These are achievements that are in the game, but for some reason are not in the gw2api... 
    // * 
    private function addCustomAchievements(){
        
        Achievement::updateOrCreate(
            [
                'id' => 7804
            ],
            [
                'icon' => null,
                'name' => 'Avid Horn of Maguuma Fisher',
                'description' => "<c=@flavor>The charm of fishing is in pursuing something elusive, though attainable. It is a simple yet profound practice of hope.</c>",
                'requirement' => "Collect  different fish from the waterways of the Horn of Maguuma.",
                'locked_text' => "",
                'type' => "ItemSet",
                'flags' => ["IgnoreNearlyComplete","Pvp","RepairOnLogin","Repeatable","Permanent"],
                'tiers' => [
                    'count' => 21,
                    'points' => 0
                ],
                'prerequisites' => [7114],
                'rewards' => [
                    'type' => 'Item',
                    'id' => 101610,
                    'count' => 1,
                ],
                'bits' => [
                    ['type' => 'Item', 'id' => 100682],
                    ['type' => 'Item', 'id' => 99986],
                    ['type' => 'Item', 'id' => 100298],
                    ['type' => 'Item', 'id' => 100887],
                    ['type' => 'Item', 'id' => 100399],
                    ['type' => 'Item', 'id' => 100517],
                    ['type' => 'Item', 'id' => 100032],
                    ['type' => 'Item', 'id' => 100046],
                    ['type' => 'Item', 'id' => 100845],
                    ['type' => 'Item', 'id' => 100526],
                    ['type' => 'Item', 'id' => 100751],
                    ['type' => 'Item', 'id' => 100354],
                    ['type' => 'Item', 'id' => 100904],
                    ['type' => 'Item', 'id' => 100180],           
                    ['type' => 'Item', 'id' => 101241],
                    ['type' => 'Item', 'id' => 101127],
                    ['type' => 'Item', 'id' => 101622],
                    ['type' => 'Item', 'id' => 101240],
                    ['type' => 'Item', 'id' => 101523],
                    ['type' => 'Item', 'id' => 101209],
                    ['type' => 'Item', 'id' => 101446],
                ],
                'point_cap' => -1,
            ]
        );

        Achievement::updateOrCreate(
            [
                'id' => 8246
            ],
            [
                'icon' => null,
                'name' => 'Avid Janthir Fisher',
                'description' => "<c=@flavor>The charm of fishing is in pursuing something elusive, though attainable. It is a simple yet profound practice of hope.</c>",
                'requirement' => "Collect  different fish from the waterways around Janthir.",
                'locked_text' => "",
                'type' => "ItemSet",
                'flags' => ["IgnoreNearlyComplete","Pvp","RepairOnLogin","Repeatable","Permanent"],
                'tiers' => [
                    'count' => 12,
                    'points' => 0
                ],
                'prerequisites' => [8168],
                'rewards' => [
                    'type' => 'Item',
                    'id' => 103117,
                    'count' => 1,
                ],
                'bits' => [
                    ['type' => 'Item', 'id' => 102451],
                    ['type' => 'Item', 'id' => 103280],
                    ['type' => 'Item', 'id' => 102523],
                    ['type' => 'Item', 'id' => 102796],
                    ['type' => 'Item', 'id' => 103274],
                    ['type' => 'Item', 'id' => 103060],
                    ['type' => 'Item', 'id' => 102966],
                    ['type' => 'Item', 'id' => 102930],
                    ['type' => 'Item', 'id' => 103511],
                    ['type' => 'Item', 'id' => 102667],
                    ['type' => 'Item', 'id' => 102600],
                    ['type' => 'Item', 'id' => 102437],
                ],
                'point_cap' => -1,
            ]
        );
    }
}
