<?php

namespace App\Jobs\Fetches;

use App\Models\Bag;
use App\Models\Fish;
use App\Models\FishDropRate;
use App\Models\FishingEstimate;
use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchGeneral implements ShouldQueue
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
        //$this->fetchFishes();
        //$this->fetchFishingHoles();
    }

    // *
    // * FETCH GENERAL STUFF
    // * Any small fetches, dump it in this function
    protected function fetchFishes(): void {
        $api = Http::get('https://script.google.com/macros/s/AKfycbyusqQd274FeAyE_8vP7fRgO0Nu9rTy8Bb1O8-uQdvp-qBQ3TLpjQJr58djFcm9louiTw/exec?endpoint=fishes');
        $spreadsheet = $api->json(); 

        Log::info("API Response for fishes", [$spreadsheet]);

        foreach ($spreadsheet['fishes'] as $index => $fish){

            // For fish samples that are Karma based
            // On the spreadsheet, their sampleSize = 0
            $sampleSize = isset($fish['sampleSize']) ? $fish['sampleSize'] : 0; 
            
            Fish::updateOrCreate(
                [
                    'id' => $fish['id'],
                    'bait_id' => is_numeric($fish['baitID']) ? $fish['baitID'] : null,
                ],
                [
                    'map' => $fish['map'],
                    'fishing_hole' => $fish['fishingHole'],
                    'time' => $fish['time'],
                    'sample_size' => $sampleSize,
                ]
            );

            if ($sampleSize == 0){
                // If karma fish => update the currency ID of karma
                FishDropRate::updateOrCreate(
                    [
                        'fish_id' => $fish['id'],
                        'currency_id' => $fish['materialID']
                    ],
                    [
                        'drop_rate' => 1500,
                    ]
                );
            } else {
                $ids = explode(",", $fish['materialID']); 
                $dropRates = explode(",", $fish['dropRate']); 

                foreach ($ids as $key => $id){
                    // In the spreadsheet, there may be blank entries
                    // Trim them and skip if there is any
                    $id = trim($id); 
                    if (empty($id)){
                        continue; 
                    }

                    FishDropRate::updateOrCreate(
                        [
                            'fish_id' => $fish['id'], 
                            'item_id' => $id,
                        ],
                        [
                            'drop_rate' => $dropRates[$key],
                        ]
                    );
                }
            }
        }
    }

    /*
        *
        * FISHING HOLES AND ESTIMATES 
        *
    */
    protected function fetchFishingHoles(): void {
        $api = Http::get('https://script.google.com/macros/s/AKfycbyusqQd274FeAyE_8vP7fRgO0Nu9rTy8Bb1O8-uQdvp-qBQ3TLpjQJr58djFcm9louiTw/exec?endpoint=fishingHoles');
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['fishingHoles'] as $index => $hole){
            FishingHole::updateOrCreate(
                [
                    'id' => $index + 1,
                    'bait_id' => is_numeric($hole['baitID']) ? $hole['baitID'] : null,
                ],
                [
                    'name' => $hole['fishingHole'],
                    'map' => $hole['map'],
                    'region' => $hole['region'],
                    'time' => $hole['time'],
                    'fishing_power' => $hole['fishingPower'],
                    'sample_size' => $hole['sampleSize'],
                ]
            );
            // For some routes, they may not have sufficient data or optimal route so the spreadsheet is empty for map, avgholes, etc
            FishingEstimate::updateOrCreate(
                [
                    'fishing_hole_id' => $index + 1,
                ],
                [
                    'map' => $hole['map'],
                    'average_fishing_holes' => !empty($hole['avgHoles']) ? $hole['avgHoles'] : null,
                    'average_time' => !empty($hole['avgTime']) ? $hole['avgTime'] : null,
                    'time_variable' => !empty($hole['timeVar']) ? $hole['timeVar'] : null,
                    'estimate_variable' => !empty($hole['estVar']) ? $hole['estVar'] : null,
                ]
            );

            $ids = explode(",", $hole['materialID']); 
            $dropRates = explode(",", $hole['dropRate']); 

            foreach ($ids as $key => $id){
                $fish = null;
                $bag = null;

                // For $fish and $bag, check to see if they exist
                // This check is to ensure these foreign keys will be implemented into db
                if (Fish::find($id)){
                    $fish = $id;
                }
                if (Bag::find($id)){
                    $bag = $id;
                }

                FishingHoleDropRate::updateOrCreate(
                    [
                        'fishing_hole_id' => $index + 1,
                        'item_id' => $id,
                        'fish_id' => $fish,
                        'bag_id' => $bag,
                    ],
                    [
                        'drop_rate' => $dropRates[$key],
                    ]
                );
            }
        }
    }
}
