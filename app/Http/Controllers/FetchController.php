<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipes;
use App\Jobs\Fetches\FetchRecipeTrees;
use App\Jobs\Fetches\FetchRecipeValues;
use App\Models\Items;
use App\Models\Bag;
use App\Models\Benchmarks;
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
                if ($id === 'Exotic'){
                    MapBenchmarkDropRate::updateOrCreate(
                        [
                            'map_benchmark_id' => $index + 1, 
                        ],
                        [
                            'drop_rate' => $dropRates[$key],
                        ]
                    );
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
                        ]
                    );
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

    public function fetchBags(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbzJGJVi_2GPMaLubmRzKx3WAuDvbo2rWnekz2t6luNCBTRfOIelSPDsac0Vemobobi8eQ/exec'); 
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['bags'] as $index => $bag){
            Bag::updateOrCreate(
                [
                    'id' => $bag['id'],
                ],
                [
                    'name' => $bag['name'],
                    'category' => $bag['category'],
                    'sample_size' => $bag['sampleSize'],
                ]
            ); 

            $ids = explode(",", $bag['item']); 
            $dropRates = explode(",", $bag['dr']); 

            foreach ($ids as $key => $id){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($id); 
                if (empty($id)){
                    continue; 
                }

                CurrencyBagDropRates::updateOrCreate(
                    [
                        'bag_id' => $bag['id'], 
                        'item_id' => $id,
                    ],
                    [
                        'drop_rate' => $dropRates[$key],
                    ]
                );
            }
        }
    }

    public function fetchContainers(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbx7pz5kg1wGJZF938M9f7rjxfkHRV7b-DgpmGQcnm5MgPU-kgWA7umpcT_DKkVQkEpsKg/exec'); 
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['containers'] as $container){
            Bag::updateOrCreate(
                [
                    'id' => $container['id'],
                ],
                [
                    'category' => $container['category'],
                    'sample_size' => $container['sampleSize'],
                ]
            ); 

            $items = explode(",", $container['item']); 
            $itemDrs = explode(",", $container['itemDr']); 

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                ContainerDropRate::updateOrCreate(
                    [
                        'bag_id' => $container['id'], 
                        'item_id' => $id,
                    ],
                    [
                        'drop_rate' => $itemDrs[$key],
                    ]
                );
            }

            if (!empty($container['currency'])){
                $currencies = explode(",", $container['currency']);
                $currenciesDrs = explode(",", $container['currencyDr']); 

                foreach ($currencies as $key => $currency){
                    ContainerDropRate::updateOrCreate(
                        [
                            'bag_id' => $container['id'],
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

    // Fetch all the bags
    // API = "Bags" Spreadsheet
    // Check Google Script for making the json into an api 
    // 
    // Grabs list of bags, their NAME, ID, and DROP RATE
    // Goes through the list of bags and processes each specific table
    // public function fetchBags(){
    //     $apiURL = Http::get('https://script.google.com/macros/s/AKfycbzJGJVi_2GPMaLubmRzKx3WAuDvbo2rWnekz2t6luNCBTRfOIelSPDsac0Vemobobi8eQ/exec');

    //     $api = $apiURL->json(); 
    //     $bags = $api['bags'];
    //     // For each bag => change the name from the spreadsheet to a db name 
    //     // => process bags into the db
    //     foreach ($bags as $bag){
    //         $bagName = $this->stringToDBFormat($bag['name']);
    //         $this->processBags($bag, $bagName);
    //     }
    // }

    public function fetchResearchNotes(){
        $salvageableItemCategories = [
            ["Draconic", 5.5],
            ["Tempered Scale", 6],
            ["Barbaric", 5.5],
            ["Splint", 5],
            ["Major Sigil", 1],
            ["Superior Sigil", 1],
            ["Nadijeh's", 275],
            ["Zehtuka's", 213],
            ["Wupwup", 275],
            ["Powerful Potion", 1],
            ["Potent Potion", 1],
            ["Strong Potion", 1],
            ["Minor Potion", 1],
            ["Soro's", 245],
            ["Grizzlemouth's", 245],
            ["Zintl", 240],
            ["Pearl", 45],
            ["Bottle of Batwing Brew", 1],
            ["Tuning Crystal", 1],
            ["Green Wood Scepter", 1],
            ["Irradiated Focus", 1],
            ["Harpy Totem", 1],
            ["Togo's", 240],
            ["Tengu Echo", 50],
            ["Astral", 50],
            ["Peppermint Oil", 1.03],
            ["Restored Boreal", 40],
            ["Mordant", 45],
            ["Elder Wood Warhorn", 5.83],
            ["Quality Maintenance Oil", 1.1],
            ["Hard Wood Warhorn", 6],
            ["Artisan Maintenance Oil", 1],
            ["Seasoned Wood Warhorn", 5],
            ["Soft Wood Short Bow", 3.14],
            ["Journeyman Maintenance Oil", 1.04],
            ["Bronze Rifle", 1],
            ["Orichalcum Earring", 83.33],
            ["Mithril Earring", 5],
            ["Mithril Amulet", 4],
            ["Mithril Ring", 5],
            ["Platinum Amulet", 3],
            ["Platinum Earring", 4],
            ["Platinum Ring", 4],
            ["Gold Band", 5],
            ["Gold Earring", 3.29],
            ["Gold Amulet", 3],
            ["Gold Ring", 3],
            ["Silver Earring", 2.17],
            ["Silver Ring", 3],
            ["Silver Pendant", 3],
            ["Silver Stud", 2.22],
            ["Copper Stud", 1],
            ["Copper Earring", 1],
            ["Copper Amulet", 1],
            ["Copper Ring", 1],
            ["The Twins'", 467],
            ["Togo's", 450],
            ["Ferratus's", 475],
            ["Emblazoned", 75],
            ["Lunatic Noble", 75],
            ["Prowler", 5],
            ["Noble", 5.36],
            ["Outlaw Mask", 3.2],
            ["Outlaw Shoulders", 3.2],
            ["Outlaw Coat", 3.2],
            ["Outlaw Gloves", 3.2],
            ["Outlaw Pants", 3.2],
            ["Outlaw Boots", 3.2],
            ["Seeker Shoulders", 1],
            ["Seeker Coat", 1],
            ["Seeker Gloves", 1],
            ["Seeker Pants", 1],
            ["Seeker Boots", 1],
            ["Jade Tech Masque", 75],
            ["Jade Tech Shoulderpads", 75],
            ["Jade Tech Vest", 75],
            ["Jade Tech Gloves", 75],
            ["Jade Tech Skirt", 75],
            ["Jade Tech Boots", 75],
            ["Exalted Masque", 75],
            ["Exalted Mantle", 75],
            ["Exalted Coat", 75],
            ["Exalted Gloves", 75],
            ["Exalted Pants", 75],
            ["Exalted Boots", 75],
            ["Stellar", 245],
            ["Zojja's", 345],
            ["Mathilde's", 250],
            ["Sharpening Skull", 1.12],
            ["Krait Slayer", 6],
            ["Krait Pilum", 5.12],
            ["Darksteel Dagger", 6.14],
            ["Darksteel Axe", 6.26],
            ["Beaded", 7],
            ["Dredge Spear", 4.98],
            ["Bronze Axe", 1],
            ["Bronze Sword", 1],
            ["Bronze Mace", 1],
            ["Bronze Spear", 1],
            // CHEF
            ["Tuning Icicle", 1.08],
            ["Lump of Crystallized Nougat", 1],
            ["Bowl of", 1.3],
            ["Cup of", 1.3],
            ["Saffron Stuffed Mushroom", 1.27],
            ["Flatbread", 1.38],
            ["Loaf of", 1.3],
            ["Chocolate Raspberry Cream", 1.13],
            ["Roasted Parsnip", 1.05],
            ["Spicier Flank Steak", 1.1],
            ["Griffon Egg Omelet", 1],
            ["Roasted Rutabaga", 1],
            ["Plate of", 1],
            ["Sushi", 1.37],
            ["Eztlitl Stuffed Mushroom", 1],
            ["Filet of", 1],
            ["Piece of Candy Corn Almond Brittle", 1],
            ["Grape Pie", 1],
            ["Stuffed Zucchini", 1],
            ["Cherry Pie", 1],
            ["Triktiki Omelet", 1],
            ["Yam Fritter", 1],
            ["Spinach Burger", 1],
            ["Zephyrite Fish Jerky", 1],
        ];

        $restrictedItems = [
            // CHEF
            "Bowl of Red Meat Stock",
            "Bowl of Salsa",
            "Bowl of Vegetable Stock",
            "Cup of Potato Fries",
            "Hamburger",
            "Cheeseburger",
            "Dragon's Breath Bun",
            "Dragonfish Candy",
            "Dragonfly Cupcake",
            "Koi Cake",
            "Kralkachocolate Bar",
            "Fried Golden Dumpling",
            "Steamed Red Dumpling",
            "Spring Roll",
            "Sweet Bean Bun",
            "Bowl of Carne Khan Chili",
            "Bowl of Firebreather Chili",
            "Bowl of Green Chili Ice Cream",
            "Cup of Light-Roasted Coffee",
            "Omnomberry Compote",
            "Plate of Beef Rendang",
            "Bowl of Poultry Satay",
            "Quiche of Darkness Vegetable Mix",
            "Side of Charred Meat",
            "Trickster's Cream Pie",
            "Avocado Smoothie",
            "Loaf of Raspberry Peach Bread",
            "Loaf of Tarragon Bread",
            "Raspberry Peach Compote",
            "Raspberry Passion Fruit Compote",
            "Loaf of Rosemary Bread",
            "Longevity Noodles",
            "Unidentified Purple Dye",
            "White Cake",
            "Bowl of Strawberry Apple Compote",
            "Fried Banana Chips",
            "Ball of Cookie Dough",
            "Bowl of Blueberry Pie Filling",
            "Bowl of Candy Corn Custard",
            "Bowl of Chocolate Chip Ice Cream",
            "Bowl of Simple Poultry Soup",
            "Bowl ofSimple Stirfry",
            "Bowl of Staple Soup Vegetables",
            "Candied Apple",
            "Caramel Apple",
            "Chili Pepper Popper",
            "Drottot's Poached Egg",
            "Loaf of Bread",
            "Pasta Noodles",
            "Roasted Meaty Sandwich",
            "Spicy Meat Kabob",
            "Bowl of Sage Stuffing",
            "Bowl of Blackberry Pie Filling",
            "Bowl of Tangy Sautee Mix",
            "Bowl of Strawberry Pie Filling",
            "Bowl of Chocolate Raspberry Frosting",
            "Bowl of Winter Vegetable Mix",
            "Bowl of Pesto",
            "Bowl of Chocolate Cherry Frosting",
            "Bowl of Mango Pie Filling",
            "Bowl of Cherry Pie Filling",
            "Bowl of Orange Coconut Frosting",
            "Bowl of Chocolate Omnomberry Frosting",
            "Bowl of Grape Pie Filling",
            "Bowl of Simple Salad",
            "Bowl of Dolyak Stew",
            "Bowl of Simple Vegetable Soup",
            "Bowl of Green Bean Stew",
            "Bowl of Blueberry apple Compote",
            "Bowl of Simple Meat Chili",
            "Bowl of Sauteed Carrots",
            "Bowl of Simple Meat Stew",
            "Bowl of Poultry Noodle Soup",
            "Bowl of Simple Stirfry",
            "Bowl of Basic Vegetable Soup",
            "Bowl of Baker's Dry Ingredients",
            "Bowl of White Frosting",
            "Bowl of Omnomberry Pie Filling",
            "Bowl of Watery Mushroom Soup",
            "Bowl of Chocolate Frosting",
            "Bowl of Eztlitl Stuffing",
            "Bowl of Gelatinous Ooze Custard",
            "Bowl of Stirfry Base",
            "Bowl of Blackberry Pear Compote"
        ];

        foreach ($salvageableItemCategories as $items){
            $item = Items::where('name', 'like', '%'.$items[0].'%')
                ->where('level', '!=', 0)
                ->where('vendor_value', '!=', 0)
                ->where('type', '!=', 'CraftingMaterial')
                ->whereNotIn('name', $restrictedItems)
                ->get(); 

            foreach ($item as $researchNote){
                $recipe = Recipes::where('output_item_id', $researchNote['id'])->first(); 
                
                if ($recipe){
                    ResearchNotes::updateOrCreate([
                        'recipe_id' => $recipe['id']
                    ],
                    [
                        'item_id' => $researchNote['id'],
                        'avg_output' => $items[1],
                        'ingredients' => $recipe['ingredients'],
                    ]);
                }
                
            }
        }
    }

    // Since the spreadsheet API returns IDs and DROP RATES as "something, something" .. 
    // .. use explode to make it an array to easily traverse the list 
    private function processBags($bag, $table){
        // Set sample sizes for the table
        SampleSize::updateOrCreate([
                'name' => $table,
            ],
            [
                'name' => $table,
                'icon' => Items::where('name', $this->dbNameToNormalString($table))->get()[0]['icon'],
                'sample_size' => $bag['sampleSize'],
            ]
        );
        $db = (new Bag)->setTable($table); 

        $ids = explode(",", $bag['id']);
        $drs = explode(",", $bag['dr']);

        
        foreach ($ids as $key => $id){
            if ($id !== '#N/A'){
                $db->updateOrCreate(
                    [
                        // Since item_id is always unique and not genaric like 'id', it can easily be tracked so no entries become repeated
                        'item_id' => $id,
                    ],
                    [
                        'item_id' => $id,
                        'drop_rate' => $drs[$key],
                    ]
                );
            }
        }   
    }
}
