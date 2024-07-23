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
use App\Models\Currencies;
use App\Models\CurrencyBagDropRates;
use App\Models\Fish;
use App\Models\FishDropRate;
use App\Models\FishingEstimate;
use App\Models\FishingHole;
use App\Models\FishingHoleDropRate;
use App\Models\MixedSalvageable;
use App\Models\MixedSalvageableDropRate;
use App\Models\Recipes;
use App\Models\ResearchNote;
use App\Models\ResearchNotes;
use App\Models\Salvageable;
use App\Models\SalvageableDropRate;
use App\Models\SampleSize;
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
        $api = Http::get('https://script.google.com/macros/s/AKfycbzwHBOUwRwNwKLfyMBVjdj-Ji1l5psid87cqtn-GgSQHABkJO8oviSHBi4z9_-3ILV1kw/exec?endpoint=fishingHoles');
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['fishingHoles'] as $index => $hole){
            FishingHole::updateOrCreate(
                [
                    'id' => $index + 1,
                ],
                [
                    'name' => $hole['map'],
                    'bait' => $hole['bait'],
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

    public function fetchFishes(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbzwHBOUwRwNwKLfyMBVjdj-Ji1l5psid87cqtn-GgSQHABkJO8oviSHBi4z9_-3ILV1kw/exec?endpoint=fishes');
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['fishes'] as $index => $fish){

            // For fish samples that are Karma based
            // On the spreadsheet, their sampleSize = 0
            $sampleSize = isset($fish['sampleSize']) ? $fish['sampleSize'] : 0; 
            
            Fish::updateOrCreate(
                [
                    'id' => $fish['id'],
                ],
                [
                    'map' => $fish['map'],
                    'fishing_hole' => $fish['fishingHole'],
                    'bait' => $fish['bait'],
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

    public function fetchMixedSalvageables(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbxaXtnCWj88LEF06AqHMYF9TM_UPZcJIi8wcfKDiWYJb0ablcsoJBiB5dkBQot5SnJ-/exec');

        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['mixedSalvageables'] as $index => $salvageable){
            MixedSalvageable::updateOrCreate(
                [
                    'item_id' => $salvageable['id'], 
                ],
                [
                    'category' => $salvageable['category'],
                    'sample_size' => $salvageable['sampleSize'],
                ]
            );

            $items = explode(",", $salvageable['item']); 
            $itemDrs = explode(",", $salvageable['itemDr']); 

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                MixedSalvageableDropRate::updateOrCreate(
                    [
                        'mixed_salvageable_id' => $index + 1, 
                        'item_id' => $id,
                    ],
                    [
                        'drop_rate' => $itemDrs[$key],
                    ]
                );
            }

            if (!empty($salvageable['currency'])){
                $currencies = explode(",", $salvageable['currency']);
                $currenciesDrs = explode(",", $salvageable['currencyDr']); 

                foreach ($currencies as $key => $currency){
                    MixedSalvageableDropRate::updateOrCreate(
                        [
                            'mixed_salvageable_id' => $index + 1,
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
        $api = Http::get('https://script.google.com/macros/s/AKfycbz9eON6Mrcyib4o_2m9ZkH26ja3LAv0mogd7X3bmWw1iMyx6xn8lEY8-fCGISu4Iidz/exec');

        $spreadsheet = $api->json(); 


        foreach ($spreadsheet['salvageables'] as $index => $salvageable){
            Salvageable::updateOrCreate(
                [
                    // Since dbs start ids at 1 instead of 0
                    'id' => $index + 1,
                    'item_id' => $salvageable['id'], 
                ],
                [
                    'category' => $salvageable['category'],
                    'sample_size' => $salvageable['sampleSize'],
                ]
            );

            $ids = explode(",", $salvageable['item']);
            $dropRates = explode(',', $salvageable['dr']);
            
            foreach ($ids as $key => $id){
                SalvageableDropRate::updateOrCreate(
                    [
                        'item_id' => $id, 
                        // Match salvageables id table 
                        'salvageable_id' => $index + 1,
                    ],
                    [
                        'drop_rate' => $dropRates[$key],
                    ]
                ); 
            }
        }

    }

    // public function fetchBagDropRates(){
    //     $api = Http::get('https://script.google.com/macros/s/AKfycbzJGJVi_2GPMaLubmRzKx3WAuDvbo2rWnekz2t6luNCBTRfOIelSPDsac0Vemobobi8eQ/exec'); 
    //     $spreadsheet = $api->json(); 

    //     foreach ($spreadsheet['bags'] as $index => $bag){

    //     }
    // }

    

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

    public function fetchBenchmarks(){
        // Spreadsheet API
        $apiURL = Http::get("https://script.google.com/macros/s/AKfycbx5VDf5zzAuZf5h38BLuvLN_KD3Gu0A1CKWm19zg-YVeC1COBrYVONmvxqkJr_ANasJ/exec");
        // Turn API into a JSON so it's easier to work with
        $api = $apiURL->json(); 
        // Array in spreadsheet is labeled 'benchmarks' from the App Script
        $benchmarksSS = $api['benchmarks'];
        
        // Populate $benchmarks array and set each benchmark with their own database table (assuming the tables have already been migrated)
        foreach ($benchmarksSS as $benchmark){
            if ($benchmark['map'] != NULL){
                // Example: map_benchmark_auric_basin
                $db = (new Benchmarks)->setTable($benchmark['map']); 

                // 1. explode => From the SS, it returns a long string full of drops like "Merp1, Merp2, Merp3". Seperate each merp to be it's own cell in an array
                // 2. array_filter => Remove any empty cells in the array
                // 3. array_values => Reindex the array to avoid indexes such as 0, 4, 60. Now it should be 0, 1, 2
                $drops = array_values(array_filter(explode(",", $benchmark['drops']), 'strlen'));
                $dropRates = array_values(array_filter(explode(",", $benchmark['dropRates']), 'strlen'));

                // For each drop (using it as an index really), populate the database 
                foreach ($drops as $index => $drop){
                    $db->updateOrCreate(
                        [
                            // +1 because the $drop starts at index 0, but databases only count their IDs starting at 1
                            'id' => $index + 1,
                        ],
                        [
                            'drop' => $drops[$index],
                            'drop_rate' => floatval($dropRates[$index]),
                        ]
                    );
                }
            }      
        }
    }

    public function fetchResearchNotes(){
        $salvagableItemCategories = [
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

        foreach ($salvagableItemCategories as $items){
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
