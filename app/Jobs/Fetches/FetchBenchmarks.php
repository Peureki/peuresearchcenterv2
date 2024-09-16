<?php

namespace App\Jobs\Fetches;

use App\Models\Bag;
use App\Models\CopperFedSalvageable;
use App\Models\Fish;
use App\Models\MapBenchmark;
use App\Models\MapBenchmarkDropRate;
use App\Models\MixedSalvageable;
use App\Models\RunecraftersSalvageable;
use App\Models\SilverFedSalvageable;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchBenchmarks implements ShouldQueue
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
        $this->fetchMapBenchmarks();
    }

    private function fetchMapBenchmarks(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbyzWrCVxCsN_eCAaOrLG-dae6H5IjZJsyFpvrCr-cJK66R05Cyc0cOsbkKlpGPcX6A/exec'); 
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['benchmarks'] as $index => $benchmark){
            $latestRun = Carbon::parse($benchmark['latestRun'])->format('Y-m-d H:i:s');

            MapBenchmark::updateOrCreate(
                [
                    'id' => $index + 1
                ],
                [
                    'name' => $benchmark['name'],
                    'type' => $benchmark['type'],
                    'sample_size' => $benchmark['sampleSize'],
                    'latest_run' => $latestRun,
                    'time' => $benchmark['time'],
                ]
            );

            $ids = explode(",", $benchmark['itemID']); 
            $dropRates = explode(",", $benchmark['itemDropRate']); 

            //dd($ids);

            foreach ($ids as $key => $id){
                if (empty($id)){
                    continue; 
                }
                if ($id === 'Exotic'){
                    continue; 
                    // MapBenchmarkDropRate::updateOrCreate(
                    //     [
                    //         'map_benchmark_id' => $index + 1, 
                    //     ],
                    //     [
                    //         'exotic' => true,
                    //         'drop_rate' => $dropRates[$key],
                    //     ]
                    // );
                } else {
                    $copperFed = null;
                    $runecrafters = null;
                    $silverFed = null;
                    $mixed = null;
                    $bag = null;
                    $fish = null; 

                    if (CopperFedSalvageable::find($id)){
                        $copperFed = $id; 
                    }
                    if (RunecraftersSalvageable::find($id)){
                        $runecrafters = $id;
                    }
                    if (SilverFedSalvageable::find($id)){
                        $silverFed = $id;
                    }
                    if (MixedSalvageable::find($id)){
                        $mixed = $id;
                    }
                    if (Bag::find($id)){
                        $bag = $id;
                    }
                    if (Fish::find($id)){
                        $fish = $id; 
                    }

                    MapBenchmarkDropRate::updateOrCreate(
                        [
                            'map_benchmark_id' => $index + 1,    
                            'item_id' => $id,
                            'copper_fed_salvageable_id' => $copperFed,
                            'runecrafters_salvageable_id' => $runecrafters,
                            'silver_fed_salvageable_id' => $silverFed,
                            'mixed_salvageable_id' => $mixed,
                            'bag_id' => $bag,
                            'fish_id' => $fish,
                        ],
                        [
                            'drop_rate' => $dropRates[$key],
                            'exotic' => null,
                        ]
                    );
                }
                // CURRENCIES
                if (!empty($benchmark['currencyID'])){
                    $currencies = explode(",", $benchmark['currencyID']);
                    $currenciesDrs = explode(",", $benchmark['currencyDropRate']); 
    
                    foreach ($currencies as $key => $currency){
                        MapBenchmarkDropRate::updateOrCreate(
                            [
                                'map_benchmark_id' => $index + 1,
                                'currency_id' => $currency,
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
