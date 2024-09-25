<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchBenchmarks;
use App\Jobs\Fetches\FetchGeneral;
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
    // * FETCH GENERAL STUFF
    // * Any small fetches, dump it in this function
    public function fetchGeneral(){
        dispatch(new FetchGeneral());
        return response()->json(['messasge' => 'Fetching general small stuff job has been queued']);
    }
    // *
    // * FETCH ALL BENCHMARKS
    // * Maps, Fishing, etc
    public function fetchBenchmarks(){
        dispatch(new FetchBenchmarks());
        return response()->json(['messasge' => 'Fetching benchmark job has been queued']);
    }

    public function merp(){
        return response()->json(['message' => 'merp']);
    }

    public function fetchDerp()
    {
        //$recipes = Recipes::get();
        //$recipe = Recipes::find(3300); 
        $recipe = Recipes::find(781); // Carrion Draconic Pauldrons
        // AGONY RESISTATANCE beyond +10
        // Because Agony has a recipe on top of a recipe the higher you go, by +17, it broke mySQL
        $restrictedIDs = [
            49434,
            49435,
            49436,
            49437,
            49438,
            49439,
            49440,
            49441,
            49442,
            49443,
            49444,
            49445,
            49446,
            49447,
        ];
        // Go through each recipe and fetch any recipe trees
        //foreach ($recipes as $recipe){
            $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
            // Check if the output item exist and check if it's restricted
            if ($itemsIDExists && !in_array($recipe['output_item_id'], $restrictedIDs)){
                // Check if the OUTPUT_ITEM_COUNT is > 1 
                // If not, this causes recipe counts to be squared/grow expo for each recipe tree
                // This still keeps the main item output at the appropiate amount though, without change the ingredients
                // Ex: Super Veggie Pizza
                
                //dd($recipe, $recipe['ingredients']);

                $nestedRecipe = []; 

                if ($recipe['output_item_count'] > 1){
                    $nestedRecipe = $this->fetchRecipeTree($recipe, 1);
                } else {
                    $nestedRecipe = $this->fetchRecipeTree($recipe, $recipe['output_item_count']);
                }
                //dd($recipe, $nestedRecipe);

                Recipes::where('id', $recipe['id'])->update(['ingredients' => $nestedRecipe]);
            } 
        //}
    }

    private function fetchRecipeTree($recipe, $parentCount){
        //dd($recipe, $recipe['ingredients'], $parentCount);
        $newRecipeTree = []; 

        foreach($recipe['ingredients'] as $index => $ingredient){
            // Set ingredients to $newRecipeTree
            $newRecipeTree[$index] = $ingredient;
            $newRecipeTree[$index]['count'] *= $parentCount; 

            if ($ingredient['type'] == 'Item'){     
                $newRecipeTree[$index]['name'] = Items::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Items::where('id', $ingredient['id'])->first()['icon'];
            } 
            if ($ingredient['type'] == 'Currency'){
                $newRecipeTree[$index]['name'] = Currencies::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Currencies::where('id', $ingredient['id'])->first()['icon'];
            }
            // Check if recipe of ingredient exists
            // If yes => then there's another branch for the tree
            $newRecipe = Recipes::where('output_item_id', $ingredient['id'])->first();
            //dd($newRecipe, $newRecipe['ingredients'], $ingredient);
            

            if ($newRecipe){
                //dd($newRecipe, $ingredient, $ingredient['ingredients']);
                //dd($newRecipe['output_item_count'], $ingredient['count']);
                if ($newRecipe['output_item_count'] > 1){
                    $newRecipeTree[$index]['ingredients'] = $this->fetchRecipeTree($newRecipe, $ingredient['count'] / $newRecipe['output_item_count']); 
                } else {
                    //dd($ingredient);
                    $newRecipeTree[$index]['ingredients'] = $this->fetchRecipeTree($newRecipe, $ingredient['count'] * $parentCount);
                    //dd($newRecipe['ingredients'][0]['count']);
                }
            }          
        }
        return $newRecipeTree;
    }


    public function fetchMerp(){
        $salvageableItemCategories = [
            // ["Draconic", 5.5],
            // ["Tempered Scale", 6],
            // ["Barbaric", 5.5],
            // ["Splint", 5],
            // ["Major Sigil", 1],
            // ["Superior Sigil", 1],
            // ["Nadijeh's", 275],
            // ["Zehtuka's", 213],
            // ["Wupwup", 275],
            // ["Powerful Potion", 1],
            // ["Potent Potion", 1],
            // ["Strong Potion", 1],
            // ["Minor Potion", 1],
            // ["Soro's", 245],
            // ["Grizzlemouth's", 245],
            // ["Zintl", 240],
            // ["Pearl", 45],
            // ["Bottle of Batwing Brew", 1],
            // ["Tuning Crystal", 1],
            // ["Green Wood Scepter", 1],
            // ["Irradiated Focus", 1],
            // ["Harpy Totem", 1],
            // ["Togo's", 240],
            // ["Tengu Echo", 50],
            // ["Astral", 50],
            // ["Peppermint Oil", 1.03],
            // ["Restored Boreal", 40],
            // ["Mordant", 45],
            // ["Elder Wood Warhorn", 5.83],
            // ["Quality Maintenance Oil", 1.1],
            // ["Hard Wood Warhorn", 6],
            // ["Artisan Maintenance Oil", 1],
            // ["Seasoned Wood Warhorn", 5],
            // ["Soft Wood Short Bow", 3.14],
            // ["Journeyman Maintenance Oil", 1.04],
            // ["Bronze Rifle", 1],
            // ["Orichalcum Earring", 83.33],
            // ["Mithril Earring", 5],
            // ["Mithril Amulet", 4],
            // ["Mithril Ring", 5],
            // ["Platinum Amulet", 3],
            // ["Platinum Earring", 4],
            // ["Platinum Ring", 4],
            // ["Gold Band", 5],
            // ["Gold Earring", 3.29],
            // ["Gold Amulet", 3],
            // ["Gold Ring", 3],
            // ["Silver Earring", 2.17],
            // ["Silver Ring", 3],
            // ["Silver Pendant", 3],
            // ["Silver Stud", 2.22],
            // ["Copper Stud", 1],
            // ["Copper Earring", 1],
            // ["Copper Amulet", 1],
            // ["Copper Ring", 1],
            // ["The Twins'", 467],
            // ["Togo's", 450],
            // ["Ferratus's", 475],
            // ["Emblazoned", 75],
            // ["Lunatic Noble", 75],
            // ["Prowler", 5],
            // ["Noble", 5.36],
            // ["Outlaw Mask", 3.2],
            // ["Outlaw Shoulders", 3.2],
            // ["Outlaw Coat", 3.2],
            // ["Outlaw Gloves", 3.2],
            // ["Outlaw Pants", 3.2],
            // ["Outlaw Boots", 3.2],
            // ["Seeker Shoulders", 1],
            // ["Seeker Coat", 1],
            // ["Seeker Gloves", 1],
            // ["Seeker Pants", 1],
            // ["Seeker Boots", 1],
            // ["Jade Tech Masque", 75],
            // ["Jade Tech Shoulderpads", 75],
            // ["Jade Tech Vest", 75],
            // ["Jade Tech Gloves", 75],
            // ["Jade Tech Skirt", 75],
            // ["Jade Tech Boots", 75],
            // ["Exalted Masque", 75],
            // ["Exalted Mantle", 75],
            // ["Exalted Coat", 75],
            // ["Exalted Gloves", 75],
            // ["Exalted Pants", 75],
            // ["Exalted Boots", 75],
            // ["Stellar", 245],
            // ["Zojja's", 345],
            // ["Mathilde's", 250],
            // ["Sharpening Skull", 1.12],
            // ["Krait Slayer", 6],
            // ["Krait Pilum", 5.12],
            // ["Darksteel Dagger", 6.14],
            // ["Darksteel Axe", 6.26],
            // ["Beaded", 7],
            // ["Dredge Spear", 4.98],
            // ["Bronze Axe", 1],
            // ["Bronze Sword", 1],
            // ["Bronze Mace", 1],
            // ["Bronze Spear", 1],
            // // CHEF
            // ["Tuning Icicle", 1.08],
            // ["Lump of Crystallized Nougat", 1],
            // ["Bowl of", 1.3],
            // ["Cup of", 1.3],
            // ["Saffron Stuffed Mushroom", 1.27],
            // ["Flatbread", 1.38],
            // ["Loaf of", 1.3],
            // ["Chocolate Raspberry Cream", 1.13],
            // ["Roasted Parsnip", 1.05],
            // ["Spicier Flank Steak", 1.1],
            // ["Griffon Egg Omelet", 1],
            // ["Roasted Rutabaga", 1],
            // ["Plate of", 1],
            // ["Sushi", 1.37],
            // ["Eztlitl Stuffed Mushroom", 1],
            // ["Filet of", 1],
            // ["Piece of Candy Corn Almond Brittle", 1],
            // ["Grape Pie", 1],
            // ["Stuffed Zucchini", 1],
            // ["Cherry Pie", 1],
            // ["Triktiki Omelet", 1],
            // ["Yam Fritter", 1],
            // ["Spinach Burger", 1],
            // ["Zephyrite Fish Jerky", 1],
            // ["Feathered", 5.5],
            ["Block of Tofu", 1.1],
        ];

        $restrictedItems = [
            "Recipe:",
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
            "Bowl of Blackberry Pear Compote",
            "Bowl of Basic Poultry Soup",
            "Feast of Yam Fritters",
        ];

        $salvageableItemNames = array_column($salvageableItemCategories, 0); 
        $salvageableMap = array_column($salvageableItemCategories, 1, 0);

        $researchNotesResponse = [];

        //dd($salvageableItemNames);

        Items::where(function ($goodItemQuery) use ($salvageableItemNames){
            foreach ($salvageableItemNames as $name){
                $goodItemQuery->orWhere('name', 'like', '%'.$name.'%');
            }
        })
        ->where('level', '!=', 0)
        ->where('vendor_value', '!=', 0)
        ->where('type', '!=', 'CraftingMaterial')
        ->where(function ($badItemQuery) use ($restrictedItems){
            foreach ($restrictedItems as $restricted){
                $badItemQuery->orWhere('name', 'not like', '%'.$restricted.'%');
            }
        })
        ->chunk(100, function ($salvageableItems) use ($salvageableMap){
            foreach ($salvageableItems as $item){
                $recipe = Recipes::where('output_item_id', $item->id)->first();
                
                //dd($recipe);

                if ($recipe) {
                    $avgOutput = null; 
                    foreach ($salvageableMap as $category => $value){
                        //dd($item->name, $category, $value);
                        //dd(strpos($item->name, $category));
                        if (strpos($item->name, $category) != false || $item->name == $category){
                            //dd($category, $value);
                            $avgOutput = $value; 
                            break;
                        }
                    }

                    //dd($salvageableItems);

                    if ($avgOutput){
                        //dd($recipe->id, $item->id, $avgOutput, $recipe->ingredients);

                        ResearchNotes::updateOrCreate(
                            [
                                'recipe_id' => $recipe->id,
                                'item_id' => $item->id,
                            ],
                            [
                                'avg_output' => $avgOutput, // Use avg_output from map
                                'ingredients' => $recipe->ingredients,
                            ]  
                        );
                    }
                    
                }
            }
        });
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
