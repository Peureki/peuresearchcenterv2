<?php

namespace App\Http\Controllers;

use App\Models\Bags\TrophyShipment;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BagController extends Controller
{
    public function updateTrophyShipment(){
        $targetItems = ["24358", "24289", "83757", "24300", "83103", "24299", "24341", "24350", "24356", "24288", "24277", "24276", "24282", "24283", "24294", "24295", "24351", "24357"];

        $dropRate = ["1.00157032827339", "1.10782920810588", "0.20189934943543", "1.01809616391236", "0.198010917520377", "4.97607118821506", "5.05197038809542", "5.04037986988709", "4.93382187990728", "4.98392282958199", "1.00837508412473", "4.99700889852688", "5.02205937336424", "1.12914080610185", "5.03477155462499", "0.993045689075002", "1.04090331264488", "1.00388843191505"];

        foreach ($targetItems as $key => $item){
            $matchedItem = Items::where('id', $item)->get()[0]; 
            TrophyShipment::updateOrCreate(
                [
                    'id' => $item
                ],
                [
                    'item_id' => $matchedItem['id'],
                    'name' => $matchedItem['name'],
                    'drop_rate' => $dropRate[$key],
                ]
            );
        }
    }

    
}
