<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Models\Items;
use App\Models\Bag;
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

        foreach ($bags as $bag){
            // Need:
            // case [name of the bag in the api]: $this->processBags($bag, '[name of the db]'); break;
            switch ($bag['name']){
                // * 
                // * UNBOUND MAGIC 
                // * 
                case 'Magic-Warped Packet': $this->processBags($bag, 'magic_warped_packet'); break;
                case 'Mist-Warped Bundle': $this->processBags($bag, 'mist_warped_bundle'); break;
                // * 
                // * VOLATILE MAGIC 
                // * 
                case 'Trophy Shipments': $this->processBags($bag, 'trophy_shipments'); break; 
                case 'Metal Shipments': $this->processBags($bag, 'metal_shipments'); break;
                case 'Leather Shipments': $this->processBags($bag, 'leather_shipments'); break; 
                case 'Wood Shipments': $this->processBags($bag, 'wood_shipments'); break;
                case 'Cloth Shipments': $this->processBags($bag, 'cloth_shipments'); break;
            }
        }
    }
    // Since the spreadsheet API returns IDs and DROP RATES as "something, something" .. 
    // .. use explode to make it an array to easily traverse the list 
    private function processBags($bag, $table){
        $ids = explode(",", $bag['id']);
        $drs = explode(",", $bag['dr']);
        $db = (new Bag)->setTable($table); 

        foreach ($ids as $key => $id){
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
