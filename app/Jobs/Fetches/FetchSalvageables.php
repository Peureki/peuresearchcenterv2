<?php

namespace App\Jobs\Fetches;

use App\Models\CopperFedSalvageable;
use App\Models\CopperFedSalvageableDropRate;
use App\Models\MixedSalvageable;
use App\Models\MixedSalvageableDropRate;
use App\Models\RunecraftersSalvageable;
use App\Models\RunecraftersSalvageableDropRate;
use App\Models\SilverFedSalvageable;
use App\Models\SilverFedSalvageableDropRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchSalvageables implements ShouldQueue
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
        // Get all salvageable apis from the spreadsheet
        // COPPERFED
        // RUNECRAFTERS
        // SILVERFED
        // MIXED
        $apis = array(
            "https://script.google.com/macros/s/AKfycbzNLFImc6N-uGhnXo_Po3GTEzLkivpOQ0jI-bYXbxvV9KwCv5V2ZS_msnZB1kFDr_3N/exec?endpoint=copperFed",

            "https://script.google.com/macros/s/AKfycbzNLFImc6N-uGhnXo_Po3GTEzLkivpOQ0jI-bYXbxvV9KwCv5V2ZS_msnZB1kFDr_3N/exec?endpoint=runecrafters",

            "https://script.google.com/macros/s/AKfycbzNLFImc6N-uGhnXo_Po3GTEzLkivpOQ0jI-bYXbxvV9KwCv5V2ZS_msnZB1kFDr_3N/exec?endpoint=silverFed",

            "https://script.google.com/macros/s/AKfycbzNLFImc6N-uGhnXo_Po3GTEzLkivpOQ0jI-bYXbxvV9KwCv5V2ZS_msnZB1kFDr_3N/exec?endpoint=mixed"

        );

        foreach ($apis as $apiIndex => $api){
            $spreadsheet = Http::get($api)->json(); 
            // Get the first index of a named key array
            $spreadsheet = reset($spreadsheet); 

            //  *
            //  * COPPERFED SALVAGEABLES
            //  *
            if ($apiIndex == 0){
                foreach ($spreadsheet as $salvageable){
                    CopperFedSalvageable::updateOrCreate(
                        [
                            'id' => $salvageable['id'],
                        ],
                        [
                            'sample_size' => $salvageable['sampleSize'],
                        ]
                    );

                    $ids = explode(",", $salvageable['dropID']);
                    $dropRates = explode(',', $salvageable['dropRate']);

                    foreach ($ids as $key => $id){
                        CopperFedSalvageableDropRate::updateOrCreate(
                            [
                                'item_id' => $id,
                                'copper_fed_salvageable_id' => $salvageable['id'],
                            ],
                            [
                                'drop_rate' => $dropRates[$key],           
                            ]
                        );
                    }
                }
            //  *
            //  * RUNECRAFTERS SALVAGEABLES
            //  *
            } else if ($apiIndex == 1){
                foreach ($spreadsheet as $salvageable){
                    RunecraftersSalvageable::updateOrCreate(
                        [
                            'id' => $salvageable['id'],
                        ],
                        [
                            'sample_size' => $salvageable['sampleSize'],
                        ]
                    );

                    $ids = explode(",", $salvageable['dropID']);
                    $dropRates = explode(',', $salvageable['dropRate']);

                    foreach ($ids as $key => $id){
                        RunecraftersSalvageableDropRate::updateOrCreate(
                            [
                                'item_id' => $id,
                                'runecrafters_salvageable_id' => $salvageable['id'],
                            ],
                            [
                                'drop_rate' => $dropRates[$key], 
                            ]
                        );
                    }
                }
            //  *
            //  * SILVER FED SALVAGEABLES
            //  *
            } else if ($apiIndex == 2){
                foreach ($spreadsheet as $salvageable){
                    SilverFedSalvageable::updateOrCreate(
                        [
                            'id' => $salvageable['id'],
                        ],
                        [
                            'sample_size' => $salvageable['sampleSize'],
                        ]
                    );

                    $ids = explode(",", $salvageable['dropID']);
                    $dropRates = explode(',', $salvageable['dropRate']);

                    foreach ($ids as $key => $id){
                        SilverFedSalvageableDropRate::updateOrCreate(
                            [
                                'item_id' => $id,
                                'silver_fed_salvageable_id' => $salvageable['id'],
                            ],
                            [
                                'drop_rate' => $dropRates[$key], 
                            ]
                        );
                    }
                }
            //  *
            //  * MIXED SALVAGEABLES
            //  *
            } else if ($apiIndex == 3){
                foreach ($spreadsheet as $salvageable){
                    MixedSalvageable::updateOrCreate(
                        [
                            'id' => $salvageable['id'], 
                        ],
                        [
                            'category' => $salvageable['category'],
                            'sample_size' => $salvageable['sampleSize'],
                        ]
                    );
        
                    $items = explode(",", $salvageable['dropID']); 
                    $itemDrs = explode(",", $salvageable['dropRate']); 
        
                    foreach ($items as $key => $item){
                        // In the spreadsheet, there may be blank entries
                        // Trim them and skip if there is any
                        $id = trim($item); 
                        if (empty($item)){
                            continue; 
                        }

                        // $id itself on the spreadsheet might be labeled as 'Exotic'
                        MixedSalvageableDropRate::updateOrCreate(
                            [ 
                                'mixed_salvageable_id' => $salvageable['id'],
                                'item_id' => $id === 'Exotic' ? null : $id,
                            ],
                            [
                                'drop_rate' => $itemDrs[$key],
                                'exotic' => $id === 'Exotic' ? true : null, 
                            ]
                        );
                    }
        
                    if (!empty($salvageable['currencyID'])){
                        $currencies = explode(",", $salvageable['currencyID']);
                        $currenciesDrs = explode(",", $salvageable['currencyDropRate']); 
        
                        foreach ($currencies as $key => $currency){
                            MixedSalvageableDropRate::updateOrCreate(
                                [
                                    'currency_id' => $currency,
                                    'mixed_salvageable_id' => $salvageable['id'],
                                ],
                                [
                                    'drop_rate' => $currenciesDrs[$key],
                                ]
                            );
                        }
                    }
                }
            }

        }
    }
}
