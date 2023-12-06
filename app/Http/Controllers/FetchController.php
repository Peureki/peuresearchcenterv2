<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipes;
use App\Jobs\Fetches\FetchRecipeTrees;
use App\Models\Items;
use App\Models\Bag;
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
        // salvagedable item ID, avg output
        $salvagableItemIDs = [
            [24574, 1],
            [24559, 1],
            [24578, 1],
            [24664, 1],
            [24648, 1],
            [24599, 1],
            [85223, 275],
            [85286, 213],
            // Start of Draconic Armor
            [36827, 75],
            [45649, 75],
            [10614, 75],
            [10611, 75],
            [48606, 75],
            [43782, 75],
            [10612, 75],
            [48602, 75],
            [10616, 75],
            [48603, 75],
            [48601, 75],
            [10615, 75],
            [48607, 75],
            [48604, 75],
            [10617, 75],
            [85498, 75],
            [36802, 75],
            [45675, 75],
            [10684, 75],
            [10681, 75],
            [48620, 75],
            [10682, 75],
            [48616, 75],
            [10686, 75],
            [48617, 75],
            [73104, 75],
            [48615, 75],
            [10685, 75],
            [48621, 75],
            [48618, 75],
            [10687, 75],
            [36732, 75],
            [45610, 75],
            [10509, 75],
            [10506, 75],
            [48585, 75],
            [10507, 75],
            [48581, 75],
            [10511, 75],
            [48582, 75],
            [48582, 75],
            [76937, 75],
            [48580, 75],
            [10510, 75],
            [48586, 75],
            [48583, 75],
            [10512, 75],
            [36857, 75],
            [45659, 75],
            [10635, 75],
            [10632, 75],
            [48613, 75],
            [10633, 75],
            [48609, 75],
            [10637, 75],
            [48610, 75],
            [75437, 75],
            [48608, 75],
            [10636, 75],
            [48614, 75],
            [48611, 75],
            [10638, 75],
            [36765, 75],
            [45623, 75],
            [10544, 75],
            [10541, 75],
            [48592, 75],
            [10542, 75],
            [48588, 75],
            [10546, 75],
            [48589, 75],
            [72262, 75],
            [48587, 75],
            [10545, 75],
            [48593, 75],
            [48590, 75],
            [10547, 75],
            [36878, 75],
            [45636, 75],
            [10579, 75],
            [10576, 75],
            [48599, 75],
            [10577, 75],
            [48595, 75],
            [10581, 75],
            [48596, 75],
            [77178, 75],
            [48594, 75],
            [10580, 75],
            [48600, 75],
            [48597, 75],
            [10582, 75],
        ];

        foreach ($salvagableItemIDs as $inputItem){
            $item = Items::find($inputItem[0]);
            $recipe = Recipes::where('output_item_id', $item['id'])->first();

            //dd($recipe['id']);

            ResearchNotes::updateOrCreate([
                'recipe_id' => $recipe['id']
            ],
            [
                'item_id' => $item['id'],
                'name' => $item['name'],
                'disciplines' => $recipe['disciplines'],
                'min_rating' => $recipe['min_rating'],
                'avg_output' => $inputItem[1],
                'ingredients' => $recipe['ingredients'],
                'buy_price' => $item['buy_price'],
                'sell_price' => $item['sell_price'],
            ]);
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
