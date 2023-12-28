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
