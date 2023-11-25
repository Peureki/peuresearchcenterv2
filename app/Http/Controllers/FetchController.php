<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipes;
use App\Models\Items;
use App\Models\Bag;
use App\Models\Recipes;
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

    public function fetchRecipesTest(){
        $perPage = 200; 
        $currentPage = 0;
        
        $apiIds = Http::get('https://api.guildwars2.com/v2/recipes'); 
        $idList = $apiIds->json(); 

        $totalEntries = count($idList); 
        $totalPages = ceil($totalEntries / $perPage);

        $batch = array_chunk($idList, $perPage);
        

        while ($currentPage < $totalPages){
            $apiBatch = Http::get('https://api.guildwars2.com/v2/recipes?ids='.implode(',', $batch[$currentPage]));
            $batchList = $apiBatch->json(); 

            foreach($batchList as $recipe){
                $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists();
                if ($itemsIDExists){
                    Recipes::updateOrCreate(
                        [
                            'id' => $recipe['id']
                        ],
                        [
                            'type' => $recipe['type'],
                            'output_item_id' => $recipe['output_item_id'],
                            'output_item_count' => $recipe['output_item_count'],
                            'time_to_craft_ms' => $recipe['time_to_craft_ms'],
                            'disciplines' => $recipe['disciplines'],
                            'min_rating' => $recipe['min_rating'],
                            'flags' => $recipe['flags'],
                            'ingredients' => $recipe['ingredients'],
                            'guild_ingredients' => $recipe['guild_ingredients'],
                            'chat_link' => $recipe['chat_link'],
                        ]
                    );
                }
                
            }
            $currentPage++;
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
