<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipes;
use App\Jobs\Fetches\FetchRecipeTrees;
use App\Jobs\Fetches\FetchRecipeValues;
use App\Models\Items;
use App\Models\Bag;
use App\Models\Currencies;
use App\Models\Recipes;
use App\Models\ResearchNote;
use App\Models\ResearchNotes;
use App\Models\SampleSize;
use Illuminate\Http\Request;
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
    public function fetchBags(){
        $apiURL = Http::get('https://script.google.com/macros/s/AKfycbzJGJVi_2GPMaLubmRzKx3WAuDvbo2rWnekz2t6luNCBTRfOIelSPDsac0Vemobobi8eQ/exec');

        $api = $apiURL->json(); 
        $bags = $api['bags'];
        // For each bag => change the name from the spreadsheet to a db name 
        // => process bags into the db
        foreach ($bags as $bag){
            $bagName = $this->stringToDBFormat($bag['name']);
            $this->processBags($bag, $bagName);
        }
    }

    public function fetchResearchNotes(){
        // Carrion
        // Knights
        // Valkyrie
        // Rampager
        // Assassins
        // Shamans
        // Rabid
        // Dire
        // Soldier's
        // Magis
        // Cavalier
        // Settler
        // Berserker
        // Cleric
        // salvagedable item ID, avg output
        // $salvagableItemIDs = [
        //     [24574, 1],
        //     [24559, 1],
        //     [24578, 1],
        //     [24664, 1],
        //     [24648, 1],
        //     [24599, 1],
        //     [85223, 275],
        //     [85286, 213],
        //     // Start of Draconic Armor
        //     [36827, 75],
        //     [45649, 75],
        //     [10614, 75],
        //     [10611, 75],
        //     [48606, 75],
        //     [43782, 75],
        //     [10612, 75],
        //     [48602, 75],
        //     [10616, 75],
        //     [48603, 75],
        //     [48601, 75],
        //     [10615, 75],
        //     [48607, 75],
        //     [48604, 75],
        //     [10617, 75],
        //     [85498, 75],
        //     [36802, 75],
        //     [45675, 75],
        //     [10684, 75],
        //     [10681, 75],
        //     [48620, 75],
        //     [10682, 75],
        //     [48616, 75],
        //     [10686, 75],
        //     [48617, 75],
        //     [73104, 75],
        //     [48615, 75],
        //     [10685, 75],
        //     [48621, 75],
        //     [48618, 75],
        //     [10687, 75],
        //     [36732, 75],
        //     [45610, 75],
        //     [10509, 75],
        //     [10506, 75],
        //     [48585, 75],
        //     [10507, 75],
        //     [48581, 75],
        //     [10511, 75],
        //     [48582, 75],
        //     [48582, 75],
        //     [76937, 75],
        //     [48580, 75],
        //     [10510, 75],
        //     [48586, 75],
        //     [48583, 75],
        //     [10512, 75],
        //     [36857, 75],
        //     [45659, 75],
        //     [10635, 75],
        //     [10632, 75],
        //     [48613, 75],
        //     [10633, 75],
        //     [48609, 75],
        //     [10637, 75],
        //     [48610, 75],
        //     [75437, 75],
        //     [48608, 75],
        //     [10636, 75],
        //     [48614, 75],
        //     [48611, 75],
        //     [10638, 75],
        //     [36765, 75],
        //     [45623, 75],
        //     [10544, 75],
        //     [10541, 75],
        //     [48592, 75],
        //     [10542, 75],
        //     [48588, 75],
        //     [10546, 75],
        //     [48589, 75],
        //     [72262, 75],
        //     [48587, 75],
        //     [10545, 75],
        //     [48593, 75],
        //     [48590, 75],
        //     [10547, 75],
        //     [36878, 75],
        //     [45636, 75],
        //     [10579, 75],
        //     [10576, 75],
        //     [48599, 75],
        //     [10577, 75],
        //     [48595, 75],
        //     [10581, 75],
        //     [48596, 75],
        //     [77178, 75],
        //     [48594, 75],
        //     [10580, 75],
        //     [48600, 75],
        //     [48597, 75],
        //     [10582, 75],
        //     // BARBARIC HELMS
        //     [10675, 5.5],
        //     [10676, 5.5],
        //     [10674, 5.5],
        //     [45672, 9.74],
        //     [10672, 6],
        //     [10673, 5.5],
        //     [10678, 5.5],
        //     [36819, 5.5],
        //     [36815, 5.5],
        //     [45673, 5.5],
        //     [10677, 5.5],
        //     [10667, 5.5],
        //     [10668, 5.5],
        //     [10680, 5.5],
        //     [10669, 5.5],
        //     // BARBARIC PAULDRONS
        //     [10500, 5.5],
        //     [10501, 5.5],
        //     [10499, 5.5],
        //     [36759, 5.5],
        //     [45607, 5.5],
        //     [10497, 5.5],
        //     [10498, 5.5],
        //     [10503, 5.5],
        //     [36749, 5.5],
        //     [45608, 5.5],
        //     [10502, 5.5],
        //     [10492, 5.5],
        //     [10495, 5.5],
        //     [10493, 5.5],
        //     [10494, 5.5],
        //     // BARBARIC COATS
        //     [10647, 5.5],
        //     [10648, 5.5],
        //     [10646, 5.5],
        //     [36872, 5.5],
        //     [45660, 5.5],
        //     [10644, 5.5],
        //     [10645, 5.5],
        //     [10650, 5.5],
        //     [10650, 5.5],
        //     [36870, 5.5],
        //     [45661, 5.5],
        //     [10649, 5.5],
        //     [10639, 5.5],
        //     [10642, 5.5],
        //     [10640, 5.5],
        //     [10652, 5.5],
        //     [10641, 5.5],
        //     // BARBARIC GLOVES
        //     [10605, 5.5],
        //     [10606, 5.5],
        //     [10604, 5.5],
        //     [36850, 5.5],
        //     [45646, 5.5],
        //     [10602, 5.5],
        //     [10603, 5.5],
        //     [10608, 5.5],
        //     [36843, 5.5],
        //     [45647, 5.5],
        //     [10607, 5.5],
        //     [10597, 5.5],
        //     [10600, 5.5],
        //     [10598, 5.5],
        //     [10610, 5.5],
        //     [10599, 5.5],
        //     // BARBARIC LEGPLATES
        //     [10535, 5.5],
        //     [10536, 5.5],
        //     [10534, 5.5],
        //     [36789, 5.5],
        //     [45620, 5.5],
        //     [10532, 5.5],
        //     [10533, 5.5],
        //     [10538, 5.5],
        //     [36785, 5.5],
        //     [45621, 5.5],
        //     [10537, 5.5],
        //     [10527, 5.5],
        //     [10527, 5.5],
        //     [10530, 5.5],
        //     [10528, 5.5],
        //     [10540, 5.5],
        //     [10529, 5.5],
        //     // BARBARIC BOOTS
        //     [10570, 5.5],
        //     [10571, 5.5],
        //     [10569, 5.5],
        //     [36897, 5.5],
        //     [45633, 5.5],
        //     [10567, 5.5],
        //     [10568, 5.5],
        //     [10573, 5.5],
        //     [36890, 5.5],
        //     [45634, 5.5],
        //     [10572, 5.5],
        //     [10562, 5.5],
        //     [10565, 5.5],
        //     [10563, 5.5],
        //     [10575, 5.5],
        //     [10564, 5.5],
        //     // TEMPERED SCALE
        // ];

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
            ["Tuning Icicle", 1.08],
            ["Lump of Crystallized Nougat", 1],
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
            ["Outlaw", 3.2],
            ["Seeker Mask", 1],
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



        ];

        foreach ($salvagableItemCategories as $items){
            $item = Items::where('name', 'like', '%'.$items[0].'%')
                ->where('level', '!=', 0)
                ->where('vendor_value', '!=', 0)
                ->get(); 

            foreach ($item as $researchNote){
                $recipe = Recipes::where('output_item_id', $researchNote['id'])->first(); 
                
                if ($recipe){
                    ResearchNotes::updateOrCreate([
                        'recipe_id' => $recipe['id']
                    ],
                    [
                        'item_id' => $researchNote['id'],
                        'name' => $researchNote['name'],
                        'disciplines' => $recipe['disciplines'],
                        'min_rating' => $recipe['min_rating'],
                        'avg_output' => $items[1] * $recipe['output_item_count'],
                        'ingredients' => $recipe['ingredients'],
                        'buy_price' => $researchNote['buy_price'],
                        'sell_price' => $researchNote['sell_price'],
                    ]);
                }
                
            }
        }

        // foreach ($salvagableItemIDs as $inputItem){
        //     $item = Items::find($inputItem[0]);
        //     $recipe = Recipes::where('output_item_id', $item['id'])->first();

        //     //dd($recipe['id']);

        //     ResearchNotes::updateOrCreate([
        //         'recipe_id' => $recipe['id']
        //     ],
        //     [
        //         'item_id' => $item['id'],
        //         'name' => $item['name'],
        //         'disciplines' => $recipe['disciplines'],
        //         'min_rating' => $recipe['min_rating'],
        //         'avg_output' => $inputItem[1],
        //         'ingredients' => $recipe['ingredients'],
        //         'buy_price' => $item['buy_price'],
        //         'sell_price' => $item['sell_price'],
        //     ]);
        // }
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
