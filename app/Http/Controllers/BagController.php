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
        // This is where bag_ids will be pushed depending on what exchangable item is being exchanged
        $requestedBags = []; 


        // Input IDs of bags that are related to the exchangebles/currencies
        switch ($request){
            case "Bandit Crest":
                // Sandy Bag of Gear
                // Bag of Rare Gear
                $requestedBags = array_merge($requestedBags, $this->banditCrest['id']);
                break;

            case "Empyreal Fragment":
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
            case "Dragonite Ore":
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
                break;

            case "Geode":
                // Sandy Bag of Gear
                $requestedBags = array_merge($requestedBags, $this->geode['id']);
                break;

            case "Imperial Favor":
                // Bounty of Dragon's End
                // Bounty of Echovald Wilds
                // Bounty of New Kaineng City
                // Bounty of Seitung Province
                $requestedBags = array_merge($requestedBags, $this->imperialFavor['id']);
                $conversionRate = $this->imperialFavor['conversionRate'];
                $fee = $this->imperialFavor['fee'];

                //dd($requestedBags, $conversionRate, $fee);
                break;

            case "Jade Sliver":
                $requestedBags = array_merge($requestedBags, $this->jadeSliver['id']);
                break;

                // Crafting Bags
            case "Laurel":
                $requestedBags = array_merge($requestedBags, $this->laurel['id']);
                $conversionRate = $this->laurel['conversionRate'];
                $fee = $this->laurel['fee'];
                break;

            case "Ley Line Crystal":
            case "Lump of Aurillium": 
            case "Airship Part":
                $requestedBags = array_merge($requestedBags, $this->leyEnergyMatter['id']);
                break;

            case "Pile of Bloodstone Dust":
                
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
                break;

                // Trade Crates
            case "Trade Contract":
                $requestedBags = array_merge($requestedBags, $this->tradeContract['id']);
                break;
                // Magic Warped Packet
                // Magic Warped Bundle
            case "Unbound Magic":
                $requestedBags = array_merge($requestedBags, $this->unboundMagic['id']);
                break;
            case "Volatile Magic":
                $requestedBags = array_merge($requestedBags, $this->volatileMagic['id']);
                break;
        }

        //dd('requested bags: ', $requestedBags);

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

        //dd('bag drop rates: ', $bagDropRates);

        $orderedResults = [];
        // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
        // This is to match the conversionRates and fees
        foreach ($requestedBags as $id){
            if (isset($bagDropRates[$id])){
                $orderedResults[$id] = $bagDropRates[$id];
            }
        }
        // Make the indexes reset to 0, 1, 2, etc instead of the item IDs
        $bagDropRates = array_values($orderedResults);

        // if ($request == 'Dragonite Ore'
        //     || $request == 'Empyreal Fragment'
        //     || $request == 'Bloodstone Dust'
        //     || $request == 'Unbound Magic'
        // ){
        //     foreach ($bagDropRates as $id => $tempBag){
        //         // Fluctuating Mass
        //         if ($id == 79264){
        //             // ORDER is to distinquish each bag with different conversions of the same Exchangeable
        //             $tempBag->order = 0; 
        //             $duplicateBag = clone $tempBag;
        //             $duplicateBag->order = 1;
        //             $bagDropRates->push($duplicateBag);
        //         }
        //         // Magic Warped Bundle
        //         if ($id == 79186){
        //             $tempBag->order = 0; 
        //             $duplicateBag = clone $tempBag;
        //             $duplicateBag->order = 1;
        //             $bagDropRates->push($duplicateBag);
        //         }
        //     }
        // }

        foreach ($bagDropRates as $index => $group){
            //dd($group);
            $total = 0;
            $bagName = '';
            $icon = '';
            $profitPerBag = 0;
            $currency = $request;
            // Initialize as an array to potentially store more than 1 currency for a bag
            // ie Trade Crates use Trade Contracts && Karma
            $currencyPerBag = 0;
            $costOfCurrencyPerBag = 0;

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
                // Insert 'value' into $items collection
                $item->value = $value;

                $bagName = $item->bag_name;
                $icon = $item->bag_icon;
                
                $total += $value;
            }
            // Input the amount of cost for each currency
            // If a currency or exchangeable has the same bag 
            // then 
            // => $currency[0] = [exchangeable]
            // => $currency[1] = [other exchangeable]
            // => $costOfCurrencyPerBag[0] => [cost of exchangeable]
            // => $costOfCurrencyPerBag[1] => [cost of other exchangeable]
            // switch (true){
            //     case in_array('Bandit Crest', $request):
            //         $currency[0] = 'Bandit Crest';
            //         if ($item->bag_name == 'Bag of Rare Gear'){
            //             $costOfCurrencyPerBag[0] = 250;
            //             $fee = 2000;
            //         }
            //         if ($item->bag_name == 'Sandy Bag of Gear'){
            //             $costOfCurrencyPerBag[0] = 15;
            //             $fee = 80;
            //         }
            //         break;

            //     case in_array('Empyreal Fragment', $request):
            //         if ($group->order == 0){
            //             $currency[0] = 'Empyreal Fragment';
            //             $currency[1] = 'Dragonite Ore';
            //             $costOfCurrencyPerBag[0] = 25; 
            //             $costOfCurrencyPerBag[1] = 25;

            //         }
            //         if ($group->order == 1){
            //             $currency[0] = 'Empyreal Fragment';
            //             $currency[1] = 'Dragonite Ore';
            //             $costOfCurrencyPerBag[0] = 25;
            //             $costOfCurrencyPerBag[1] = 25; 
            //         }
            //         break; 
            //     case in_array('Dragonite Ore', $request):
            //         if ($group->order == 0){
            //             $currency[0] = 'Dragonite Ore';
            //             $currency[1] = 'Empyreal Fragment';
            //             $costOfCurrencyPerBag[0] = 25; 
            //             $costOfCurrencyPerBag[1] = 25;

            //         }
            //         if ($group->order == 1){
            //             $currency[0] = 'Dragonite Ore';
            //             $currency[1] = 'Empyreal Fragment';
            //             $costOfCurrencyPerBag[0] = 25;
            //             $costOfCurrencyPerBag[1] = 25; 
            //         }
            //         break; 

            //     case in_array('Geode', $request):
            //         $currency[0] = 'Geode';
            //         if ($item->bag_name == 'Sandy Bag of Gear'){
            //             $costOfCurrencyPerBag[0] = 28;
            //             $fee = 1024;
            //         }
            //         break;

            //     case in_array('Imperial Favor', $request):
            //         $currency[0] = 'Imperial Favor';

            //         if ($item->name === 'Antique Summoning Stone'){
            //             $costOfCurrencyPerBag[0] = 100;
            //         } else {
            //             $costOfCurrencyPerBag[0] = 200;
            //         }  
            //         break;

            //     case in_array('Jade Sliver', $request):
            //         $currency[0] = 'Jade Sliver';
            //         $costOfCurrencyPerBag[0] = 10;

            //         break;

            //     case in_array('Laurel', $request):
            //         $currency[0] = 'Laurel';
            //         $costOfCurrencyPerBag[0] = 1; 
            //         break;

            //     case in_array('Ley Line Crystal', $request):
            //     case in_array('Lump of Aurillium', $request):
            //     case in_array('Airship Part', $request):
            //         $currency[0] = 'Ley Line Crystal';
            //         $costOfCurrencyPerBag[0] = 25;
            //         break;

            //     case in_array('Pile of Bloodstone Dust', $request):
            //         if ($group->order == 0){
            //             $currency[0] = 'Pile of Bloodstone Dust';
            //             $currency[1] = 'Dragonite Ore';
            //             $costOfCurrencyPerBag[0] = 25; 
            //             $costOfCurrencyPerBag[1] = 25;

            //         }
            //         if ($group->order == 1){
            //             $currency[0] = 'Pile of Bloodstone Dust';
            //             $currency[1] = 'Empyreal Fragment';
            //             $costOfCurrencyPerBag[0] = 25;
            //             $costOfCurrencyPerBag[1] = 25; 
            //         }
            //         break; 

            //     case in_array('Trade Contract', $request):
            //         $currency[0] = 'Trade Contract';
            //         $currency[1] = 'Karma';
            //         $costOfCurrencyPerBag[0] = 50;
            //         $costOfCurrencyPerBag[1] = 630;
            //         break;

            //     case in_array('Unbound Magic', $request):
            //         if (isset($group->order)){
            //             // Magic Waraped Bundle (Ember Bay)
            //             if ($group->order == 0){
            //                 $bagName = "Magic-Warped Bundle (Ember Bay)";
            //                 $currency[0] = 'Unbound Magic';
            //                 $costOfCurrencyPerBag[0] = 1250;
            //                 $fee = 4000;
            //             }
            //             // Magic Warped Bundle (everywhere else)
            //             if ($group->order == 1){
            //                 $currency[0] = 'Unbound Magic';
            //                 $costOfCurrencyPerBag[0] = 500;
            //                 $fee = 10000;
            //             }
            //         // Magic Warped Packet
            //         } else {
            //             $currency[0] = 'Unbound Magic';
            //             $costOfCurrencyPerBag[0] = 250;
            //             $fee = 5000;
            //         }
            //         break;
                
            //     case in_array("Volatile Magic", $request):
            //         $currency[0] = 'Volatile Magic';
            //         $costOfCurrencyPerBag[0] = 250;
            //         $fee = 10000;
            //         break;
            // }
            //dd('total: ', $total, 'fee: ', $fee[$index]);
            $profitPerBag = $total - $fee[$index]; 
            $currencyPerBag = $profitPerBag / $conversionRate[$index]; 
            //dd($profitPerBag);

            array_push($bag, [
                'total' => $total,
                'name' => $bagName,
                'icon' => $icon,
                'fee' => $fee[$index],
                'profitPerBag' => $profitPerBag,
                'currency' => $currency,
                'currencyPerBag' => $currencyPerBag,
                'costOfCurrencyPerBag' => $conversionRate[$index],  
            ]);
        }

        $response = [
            'dropRates' => $bagDropRates,
            'bag' => $bag, 
        ];

        return response()->json($response);
    }
}
