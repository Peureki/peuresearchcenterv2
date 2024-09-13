<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipes;
use App\Jobs\Fetches\FetchRecipeTrees;
use App\Jobs\Fetches\FetchRecipeValues;
use App\Jobs\Fetches\FetchResearchNotes;
use App\Models\Items;
use App\Models\Bag;
use App\Models\BagDropRate;
use App\Models\Benchmarks;
use App\Models\ChoiceChest;
use App\Models\ChoiceChestOption;
use App\Models\Consumable;
use App\Models\ConsumableDropRate;
use App\Models\ContainerDropRate;
use App\Models\CopperFedSalvageable;
use App\Models\CopperFedSalvageableDropRate;
use App\Models\Currencies;
use App\Models\CurrencyBagDropRates;
use App\Models\Exotic;
use App\Models\Fish;
use App\Models\FishDropRate;
use App\Models\FishingEstimate;
use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use App\Models\MapBenchmark;
use App\Models\MapBenchmarkDropRate;
use App\Models\MixedSalvageable;
use App\Models\MixedSalvageableDropRate;
use App\Models\Recipes;
use App\Models\ResearchNote;
use App\Models\ResearchNotes;
use App\Models\RunecraftersSalvageable;
use App\Models\RunecraftersSalvageableDropRate;
use App\Models\Salvageable;
use App\Models\SalvageableDropRate;
use App\Models\SampleSize;
use App\Models\SilverFedSalvageable;
use App\Models\SilverFedSalvageableDropRate;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchController extends Controller
{
    public function fetchItems(){
        dispatch(new FetchItems());
        return response()->json(['message' => 'Fetching items job has been queued']);
    }

    public function fetchPrices(){
        dispatch(new FetchPrices());
        return response()->json(['message' => 'Fetching prices job has been queued']);
    }

    public function fetchRecipes(){
        dispatch(new FetchRecipes());
        return response()->json(['message' => 'Fetching recipes job has been queued']);
    }

    public function fetchRecipeTrees(){
        dispatch(new FetchRecipeTrees());
        return response()->json(['message' => 'Fetching recipe trees job has been queued']);
    }

    public function fetchRecipeValues(){
        dispatch(new FetchRecipeValues());
        return response()->json(['message' => 'Fetching recipe tree values job has been queued']);
    }

    public function fetchResearchNotes(){
        dispatch(new FetchResearchNotes());
        return response()->json(['message' => 'Fetching research notes job has been queued']);
    }

    // *
    // * GET SEARCH ITEMS REQUEST
    // *
    // * When users type in a search bar, it sends a request to find recipes that contain the name/keywords 
    // * Returns => array of search results
    public function searchItems(Request $request, $quantity){
        $query = $request->input('request');
        // Combine the Recipes db and the Items db to get more info
        $items = Items::where('name', 'like', '%'.$query.'%')
            ->select('name', 'icon', 'id', 'rarity')
            ->get()
            ->map(function ($item) use ($quantity){
                return [
                    'name' => $item->name,
                    'icon' => $item->icon,
                    'id' => $item->id,
                    'rarity' => $item->rarity,
                    'count' => $quantity
                ];
            })
            ->toArray();

        //dd($items);

        return response()->json($items);
    }

    public function fetchConsumables(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbyrf0hBgaLDMtUYIqQUZ4Gv2VTZAwU7vs1jXIVMbW9xge8Hdf1ft880nOjeULKJniQ7qg/exec');
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['consumables'] as $consumable){
            Consumable::updateOrCreate(
                [
                    'id' => $consumable['id'],
                ],
                [
                    'sample_size' => $consumable['sampleSize'],
                ]
            );

            $currencyIDs = explode(",", $consumable['currencyID']); 
            $currencyDropRates = explode(",", $consumable['currencyDropRate']); 

            foreach ($currencyIDs as $key => $currency){
                ConsumableDropRate::updateOrCreate(
                    [
                        'consumable_id' => $consumable['id'],
                        'currency_id' => $currency
                    ],
                    [
                        'drop_rate' => $currencyDropRates[$key],
                    ]
                );
            }
        }
    }

    /*
        *
        * FISHING HOLES AND ESTIMATES 
        *
    */
    public function fetchFishingHoles(){
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

    /*
        *
        * EXOTICS
        * 
    */
    public function fetchExotics(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbzNLFImc6N-uGhnXo_Po3GTEzLkivpOQ0jI-bYXbxvV9KwCv5V2ZS_msnZB1kFDr_3N/exec?endpoint=exotic'); 

        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['exotic'] as $exotic){
            Exotic::updateOrCreate(
                [
                    'id' => $exotic['id'],
                ],
                [
                    'id' => $exotic['id'],
                ]
            );
        }
    }


    public function fetchMapBenchmarks(){
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

    public function fetchFishes(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbyusqQd274FeAyE_8vP7fRgO0Nu9rTy8Bb1O8-uQdvp-qBQ3TLpjQJr58djFcm9louiTw/exec?endpoint=fishes');
        $spreadsheet = $api->json(); 

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
    // *
    // * CHOICE CHESTS
    // * Fetches chests that give players the option to choice their loot
    // * Ex: Hero Choice Chests
    public function fetchChoiceChests(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwRZ5MH8MQ80kyvPV-WoZFh0z1OzKkktF_AW_AEcpNDGXWyQ5wOksILO6OfWO6Fxvk9gQ/exec?endpoint=choiceChests');
        $spreadsheet = $api->json(); 

        // Populate these for upsert() 
        // $ids => PK, ids of the chests
        // $options => FKs of the chests, bags, currencies, and the drop quantities
        $ids = [];
        $options = []; 
        
        foreach ($spreadsheet['choiceChests'] as $chest){
            // Populate chest IDs
            $ids[] = ['id' => $chest['id']];

            // Make arrays for all item info
            // $itemChoice will always have the full array
            // Ex: if there's a currency, $itemChoice will count that
            $itemChoice = explode(",", $chest['itemChoice']);
            $itemIDs = explode(",", $chest['itemID']);
            $itemQty = explode(",", $chest['itemQuantity']); 

            //dd($itemChoice);
            // Use $itemChoice since it represents all items and currencies
            foreach ($itemChoice as $key => $choice){
                $bag = null; 
                // If there's a currency, the last $key will only contain the currency
                if (!empty($itemIDs[$key])){
                    // Check if there's a Bag
                    if (Bag::find($itemIDs[$key])){
                        $bag = $itemIDs[$key];
                    }

                    $options[] = [
                        'choice_chest_id' => $chest['id'],
                        'item_id' => $itemIDs[$key],
                        'bag_id' => $bag,
                        'currency_id' => null, 
                        'currency_quantity' => null,
                        'option' => $choice, 
                        'quantity' => $itemQty[$key],
                    ];
                } else {
                    $options[] = [
                        'choice_chest_id' => $chest['id'],
                        'item_id' => null,
                        'bag_id' => $bag,
                        'currency_id' => $chest['currencyID'], 
                        'currency_quantity' => $chest['currencyQuantity'],
                        'option' => $choice, 
                        'quantity' => null,
                    ];
                }
            }
        }
        // Populate databases
        ChoiceChest::upsert($ids, ['id']);
        ChoiceChestOption::upsert($options, [
            'choice_chest_id',
            'item_id',
            'bag_id',
            'currency_id',
            'currency_quantity',
            'option',
            'quantity'
        ]);
    }

    public function fetchBags(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwRZ5MH8MQ80kyvPV-WoZFh0z1OzKkktF_AW_AEcpNDGXWyQ5wOksILO6OfWO6Fxvk9gQ/exec?endpoint=bags'); 
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['bags'] as $bag){
            Bag::updateOrCreate(
                [
                    'id' => $bag['id'],
                ],
                [
                    'sample_size' => $bag['sampleSize'],
                ]
            ); 

            if ($bag['itemID']){
                $items = explode(",", $bag['itemID']); 
                $itemDrs = explode(",", $bag['itemDropRate']); 
            }
            // NO ITEMS, ONLY CURRENCIES AS DROPS 
            else {
                $currencies = explode(",", $bag['currencyID']);
                $currenciesDrs = explode(",", $bag['currencyDropRate']); 

                foreach ($currencies as $key => $currency){
                    //dd($currency, $bag['id']);
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
                            'currency_id' => $currency,
                        ],
                        [
                            'drop_rate' => $currenciesDrs[$key],
                        ]
                    );
                }
                continue; 
            }
            

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                if ($id === 'Exotic'){
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
                            'item_id' => null, 
                        ],
                        [
                            'exotic' => true,
                            'drop_rate' => $itemDrs[$key],
                        ]
                    );
                } else {
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'], 
                            'item_id' => $id,
                        ],
                        [
                            'drop_rate' => $itemDrs[$key],
                        ]
                    );
                }

                
            }

            if (!empty($bag['currencyID'])){
                $currencies = explode(",", $bag['currencyID']);
                $currenciesDrs = explode(",", $bag['currencyDropRate']); 

                foreach ($currencies as $key => $currency){
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
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

    public function fetchSalvageables(){
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
        
                        MixedSalvageableDropRate::updateOrCreate(
                            [ 
                                'item_id' => $id,
                                'mixed_salvageable_id' => $salvageable['id'],
                            ],
                            [
                                'drop_rate' => $itemDrs[$key],
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

    public function fetchCurrencies(){
        $apiIds = Http::get('https://api.guildwars2.com/v2/currencies?ids=all'); 
        $idList = $apiIds->json(); 

        foreach ($idList as $id){
            Currencies::updateOrCreate(
                [
                    'id' => $id['id']
                ],
                [
                    'name' => $id['name'] ?? "",
                    'description' => $id['description'] ?? "",
                    'order' => $id['order'] ?? "",
                    'icon' => $id['icon'] ?? "",
                ],
            );
        }
    }
}
