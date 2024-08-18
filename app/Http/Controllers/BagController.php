<?php

namespace App\Http\Controllers;

use App\Models\BagDropRate;
use App\Models\ContainerDropRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PgSql\Lob;

class BagController extends Controller
{
    public function getTable($table, $sellOrderSetting, $tax){
        $returnArray = []; 

        $data = DB::table($table)
            ->join('items', "items.id", '=', "{$table}.item_id")
            ->select("{$table}.*", 'items.*')
            ->get();

        foreach ($data as $item){
            $entry = [
                'name' => $item->name,
                'icon' => $item->icon,
                'sellOrderSetting' => $item->$sellOrderSetting,
                'dropRate' => $item->drop_rate,
                'value' => ($item->$sellOrderSetting * $item->drop_rate) * $tax,
            ];
            $returnArray[] = $entry;

        }
        return response()->json($returnArray);
    }

    public function exchangeables($request, $includes, $sellOrderSetting, $tax){
        // Make it a workable arrays
        $includes = json_decode($includes);
        $request = json_decode($request);
        // This is where bag_ids will be pushed depending on what exchangable item is being exchanged
        $requestedBags = []; 

        // Input IDs of bags that are related to the exchangebles/currencies
        foreach ($request as $exchangeable){
            switch ($exchangeable){
                case "Bandit Crest":
                    // Sandy Bag of Gear
                    // Bag of Rare Gear
                    $requestedBags = array_merge($requestedBags, [66399, 67261]);
                    break;

                case "Empyreal Fragment":
                    // Fluctuating Mass
                    array_push($requestedBags, 79264);
                case "Dragonite Ore":
                    // Fluctuating Mass
                    array_push($requestedBags, 79264);
                    break;

                case "Geode":
                    // Sandy Bag of Gear
                    $requestedBags = array_merge($requestedBags, [66399]);
                    break;

                case "Imperial Favor":
                    // Bounty of Dragon's End
                    // Bounty of Echovald Wilds
                    // Bounty of New Kaineng City
                    // Bounty of Seitung Province
                    $requestedBags = array_merge($requestedBags, [95796, 97797, 95771, 96345, 96978]);
                    break;

                case "Jade Sliver":
                    
                    break;

                    // Crafting Bags
                case "Laurel":
                    $requestedBags = array_merge($requestedBags, [39124, 39123, 39121, 39122, 39119]);
                    break;

                case "Ley Line Crystal":
                case "Lump of Aurillium": 
                case "Airship Part":
                    $requestedBags = array_merge($requestedBags, $this->leyEnergyMatter);
                    break;

                case "Pile of Bloodstone Dust":
                    // Fluctuating Mass
                    $requestedBags = array_merge($requestedBags, [79264]);
                    break;

                    // Trade Crates
                case "Trade Contract":
                    $requestedBags = array_merge($requestedBags, [84783, 83352, 84254, 83265, 82825, 82564, 83419, 83298, 83462, 82946, 82219, 83554, 83582, 84668, 82969]);
                    break;
                    // Magic Warped Packet
                    // Magic Warped Bundle
                case "Unbound Magic":
                    $requestedBags = array_merge($requestedBags, [79114, 79186]);
                    break;
                case "Volatile Magic":
                    $requestedBags = array_merge($requestedBags, [85873, 86231, 85725, 86053, 85990]);
                    break;
            }
        }

        $response = []; 
        $bag = [];

        $bagDropRates = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
        ->join('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
        ->join('items as bag_item', 'bags.id', '=', 'bag_item.id')
        ->select(
            'bag_drop_rates.*', 
            'bags.*', 
            'item.icon as item_icon',
            'item.name as item_name', 
            'item.*', 
            'bag_item.icon as bag_icon',
            'bag_item.name as bag_name'
        )
        ->whereIn('bag_id', $requestedBags)
        ->get()
        ->groupBy('bag_id');

        if (in_array("Dragonite Ore", $request)
            || in_array("Empyreal Fragment", $request)
            || in_array("Pile of Bloodstone Dust", $request)
            || in_array("Unbound Magic", $request)
        ){
            foreach ($bagDropRates as $id => $tempBag){
                // Fluctuating Mass
                if ($id == 79264){
                    // ORDER is to distinquish each bag with different conversions of the same Exchangeable
                    $tempBag->order = 0; 
                    $duplicateBag = clone $tempBag;
                    $duplicateBag->order = 1;
                    $bagDropRates->push($duplicateBag);
                }
                // Magic Warped Bundle
                if ($id == 79186){
                    $tempBag->order = 0; 
                    $duplicateBag = clone $tempBag;
                    $duplicateBag->order = 1;
                    $bagDropRates->push($duplicateBag);
                }
            }
        }

        //dd($bagDropRates);

        foreach ($bagDropRates as $group){
            //dd($group);
            $total = 0;
            $bagName = '';
            $icon = '';
            $fee = 0;
            $profitPerBag = 0;
            $currency = [];
            // Initialize as an array to potentially store more than 1 currency for a bag
            // ie Trade Crates use Trade Contracts && Karma
            $currencyPerBag = [0];
            $costOfCurrencyPerBag = [1];

            foreach ($group as $item){
                // Check if there's uni gear && if toggled in Includes settings
                // UNIDENTIFIED GEAR
                if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                    $value = $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                } 
                // CHAMP BAGS, CONTAINERS
                else if ($item->type == "Container" && strpos($item->description, 'Salvage') === false){
                    $value = $this->getContainerValue($item->item_id, $includes,$sellOrderSetting, $tax); 
                } 
                // SALVAGEABLES (exclu uni gear)
                else if ($item->description === "Salvage Item" && in_array('Salvageables', $includes)){
                    $value = $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                }
                // ASCENDED JUNK
                else if ($item->rarity == 'Ascended' && $item->type == 'CraftingMaterial' && in_array('AscendedJunk', $includes)) {
                    // There's a lot of ascended and crafteringMaterials so switch the $item->name to check for specifically the ascended junk
                    switch ($item->name){
                        case 'Dragonite Ore':
                            $value = $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                            break;
                    }
                }
                // JUNK
                else if ($item->rarity === "Junk"){
                    $value = $item->vendor_value * $item->drop_rate; 
                }
                // ANYTHING ELSE NOT FROM ABOVE 
                else {
                    $value = ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                }

                $item->value = $value;

                $bagName = $item->bag_name;
                $icon = $item->bag_icon;
                
                $total += $value;
            }
            // Input the amount of cost for each currency
            // If a currency or exchangeable has the same bag 
            // then => $currency[0] = [exchangeable]
            // => $currency[1] = [other exchangeable]
            // => $costOfCurrencyPerBag[0] => [cost of exchangeable]
            // etc
            switch (true){
                case in_array('Bandit Crest', $request):
                    $currency[0] = 'Bandit Crest';
                    if ($item->bag_name == 'Bag of Rare Gear'){
                        $costOfCurrencyPerBag[0] = 250;
                        $fee = 2000;
                    }
                    if ($item->bag_name == 'Sandy Bag of Gear'){
                        $costOfCurrencyPerBag[0] = 15;
                        $fee = 80;
                    }
                    break;

                case in_array('Empyreal Fragment', $request):
                    if ($group->order == 0){
                        $currency[0] = 'Empyreal Fragment';
                        $currency[1] = 'Dragonite Ore';
                        $costOfCurrencyPerBag[0] = 25; 
                        $costOfCurrencyPerBag[1] = 25;

                    }
                    if ($group->order == 1){
                        $currency[0] = 'Empyreal Fragment';
                        $currency[1] = 'Dragonite Ore';
                        $costOfCurrencyPerBag[0] = 25;
                        $costOfCurrencyPerBag[1] = 25; 
                    }
                    break; 
                case in_array('Dragonite Ore', $request):
                    if ($group->order == 0){
                        $currency[0] = 'Dragonite Ore';
                        $currency[1] = 'Empyreal Fragment';
                        $costOfCurrencyPerBag[0] = 25; 
                        $costOfCurrencyPerBag[1] = 25;

                    }
                    if ($group->order == 1){
                        $currency[0] = 'Dragonite Ore';
                        $currency[1] = 'Empyreal Fragment';
                        $costOfCurrencyPerBag[0] = 25;
                        $costOfCurrencyPerBag[1] = 25; 
                    }
                    break; 

                case in_array('Geode', $request):
                    $currency[0] = 'Geode';
                    if ($item->bag_name == 'Sandy Bag of Gear'){
                        $costOfCurrencyPerBag[0] = 28;
                        $fee = 1024;
                    }
                    break;

                case in_array('Imperial Favor', $request):
                    $currency[0] = 'Imperial Favor';

                    if ($item->name === 'Antique Summoning Stone'){
                        $costOfCurrencyPerBag[0] = 100;
                    } else {
                        $costOfCurrencyPerBag[0] = 200;
                    }  
                    break;

                case in_array('Laurel', $request):
                    $currency[0] = 'Laurel';
                    $costOfCurrencyPerBag[0] = 1; 
                    break;

                case in_array('Ley Line Crystal', $request):
                case in_array('Lump of Aurillium', $request):
                case in_array('Airship Part', $request):
                    $currency[0] = 'Ley Line Crystal';
                    $costOfCurrencyPerBag[0] = 25;
                    break;

                case in_array('Pile of Bloodstone Dust', $request):
                    if ($group->order == 0){
                        $currency[0] = 'Pile of Bloodstone Dust';
                        $currency[1] = 'Dragonite Ore';
                        $costOfCurrencyPerBag[0] = 25; 
                        $costOfCurrencyPerBag[1] = 25;

                    }
                    if ($group->order == 1){
                        $currency[0] = 'Pile of Bloodstone Dust';
                        $currency[1] = 'Empyreal Fragment';
                        $costOfCurrencyPerBag[0] = 25;
                        $costOfCurrencyPerBag[1] = 25; 
                    }
                    break; 

                case in_array('Trade Contract', $request):
                    $currency[0] = 'Trade Contract';
                    $currency[1] = 'Karma';
                    $costOfCurrencyPerBag[0] = 50;
                    $costOfCurrencyPerBag[1] = 630;
                    break;

                case in_array('Unbound Magic', $request):
                    if (isset($group->order)){
                        // Magic Waraped Bundle (Ember Bay)
                        if ($group->order == 0){
                            $bagName = "Magic-Warped Bundle (Ember Bay)";
                            $currency[0] = 'Unbound Magic';
                            $costOfCurrencyPerBag[0] = 1250;
                            $fee = 4000;
                        }
                        // Magic Warped Bundle (everywhere else)
                        if ($group->order == 1){
                            $currency[0] = 'Unbound Magic';
                            $costOfCurrencyPerBag[0] = 500;
                            $fee = 10000;
                        }
                    // Magic Warped Packet
                    } else {
                        $currency[0] = 'Unbound Magic';
                        $costOfCurrencyPerBag[0] = 250;
                        $fee = 5000;
                    }
                    break;
                
                case in_array("Volatile Magic", $request):
                    $currency[0] = 'Volatile Magic';
                    $costOfCurrencyPerBag[0] = 250;
                    $fee = 10000;
                    break;
                
                
            }

            $profitPerBag = $total - $fee; 

            foreach ($costOfCurrencyPerBag as $index => $currencyCost){
                $currencyPerBag[$index] = $profitPerBag / $currencyCost;
            }

            array_push($bag, [
                'total' => $total,
                'name' => $bagName,
                'icon' => $icon,
                'fee' => $fee,
                'profitPerBag' => $profitPerBag,
                'currency' => $currency,
                'currencyPerBag' => $currencyPerBag,
                'costOfCurrencyPerBag' => $costOfCurrencyPerBag,  
            ]);
        }

        $bagDropRates = $bagDropRates->values(); 

        $response = [
            'dropRates' => $bagDropRates,
            'bag' => $bag, 
        ];

        return response()->json($response);
    }
}
