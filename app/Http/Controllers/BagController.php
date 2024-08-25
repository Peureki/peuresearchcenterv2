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
            case "Airship Part":
            case "Lump of Aurillium": 
            case "Ley Line Crystal":
                $requestedBags = array_merge($requestedBags, $this->leyEnergyMatter['id']);
                $conversionRate = $this->leyEnergyMatter['conversionRate'];
                $fee = $this->leyEnergyMatter['fee'];
                $outputQty = $this->leyEnergyMatter['outputQty'];
                break;

            case "Bandit Crest":
                // Sandy Bag of Gear
                // Bag of Rare Gear
                $requestedBags = array_merge($requestedBags, $this->banditCrest['id']);
                $conversionRate = $this->banditCrest['conversionRate'];
                $fee = $this->banditCrest['fee'];
                $outputQty = $this->banditCrest['outputQty'];
                break;

            case "Empyreal Fragment":
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
                $conversionRate = $this->ascendedJunk['conversionRate'];
                $fee = $this->ascendedJunk['fee'];
                $outputQty = $this->ascendedJunk['outputQty'];
                break;

            case "Dragonite Ore":
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
                $conversionRate = $this->ascendedJunk['conversionRate'];
                $fee = $this->ascendedJunk['fee'];
                $outputQty = $this->ascendedJunk['outputQty'];
                break;

            case "Fine Rift Essence":
            case "Masterwork Rift Essence":
                $requestedBags = array_merge($requestedBags, $this->fineAndMasterworkRiftEssences['id']);
                $conversionRate = $this->fineAndMasterworkRiftEssences['conversionRate'];
                $fee = $this->fineAndMasterworkRiftEssences['fee'];
                $outputQty = $this->fineAndMasterworkRiftEssences['outputQty'];
                break;


            case "Geode":
                // Sandy Bag of Gear
                $requestedBags = array_merge($requestedBags, $this->geode['id']);
                $conversionRate = $this->geode['conversionRate'];
                $fee = $this->geode['fee'];
                $outputQty = $this->geode['outputQty'];
                break;

            case "Imperial Favor":
                $requestedBags = array_merge($requestedBags, $this->imperialFavor['id']);
                $conversionRate = $this->imperialFavor['conversionRate'];
                $fee = $this->imperialFavor['fee'];
                $outputQty = $this->imperialFavor['outputQty'];
                break;

            case "Jade Sliver":
                $requestedBags = array_merge($requestedBags, $this->jadeSliver['id']);
                $conversionRate = $this->jadeSliver['conversionRate'];
                $fee = $this->jadeSliver['fee'];
                $outputQty = $this->jadeSliver['outputQty'];
                break;

            case "Laurel":
                $requestedBags = array_merge($requestedBags, $this->laurel['id']);
                $conversionRate = $this->laurel['conversionRate'];
                $fee = $this->laurel['fee'];
                $outputQty = $this->laurel['outputQty'];
                break;

            case "Pile of Bloodstone Dust":
                $requestedBags = array_merge($requestedBags, $this->ascendedJunk['id']);
                $conversionRate = $this->ascendedJunk['conversionRate'];
                $fee = $this->ascendedJunk['fee'];
                $outputQty = $this->ascendedJunk['outputQty'];
                break;

            case "Rare Rift Essence":
                $requestedBags = array_merge($requestedBags, $this->rareRiftEssence['id']);
                $conversionRate = $this->rareRiftEssence['conversionRate'];
                $fee = $this->rareRiftEssence['fee'];
                $outputQty = $this->rareRiftEssence['outputQty'];
                break;

            case "Trade Contract":
                $requestedBags = array_merge($requestedBags, $this->tradeContract['id']);
                $conversionRate = $this->tradeContract['conversionRate'];
                $fee = $this->tradeContract['fee'];
                $outputQty = $this->tradeContract['outputQty'];
                break;
   
            case "Unbound Magic":
                $requestedBags = array_merge($requestedBags, $this->unboundMagic['id']);
                $conversionRate = $this->unboundMagic['conversionRate'];
                $fee = $this->unboundMagic['fee'];
                $outputQty = $this->unboundMagic['outputQty'];
                break;

            case "Volatile Magic":
                $requestedBags = array_merge($requestedBags, $this->volatileMagic['id']);
                $conversionRate = $this->volatileMagic['conversionRate'];
                $fee = $this->volatileMagic['fee'];
                $outputQty = $this->volatileMagic['outputQty'];
                break;
        }

        //dd('requested bags: ', $requestedBags);

        $response = []; 
        $bag = [];

        $bagDropRates = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
        ->leftjoin('items as item', 'bag_drop_rates.item_id', '=', 'item.id')
        ->leftjoin('items as bag_item', 'bags.id', '=', 'bag_item.id')
        ->leftjoin('currencies as currency', 'bag_drop_rates.currency_id', '=', 'currency.id')
        ->select(
            'bag_drop_rates.*', 
            'bags.*', 
            'currency.*',
            'currency.name as currency_name',
            'currency.icon as currency_icon',
            'currency.icon as item_icon',
            'item.icon as item_icon',
            'item.name as item_name', 
            'item.*', 
            'bag_item.icon as bag_icon',
            'bag_item.name as bag_name',
            
        )
        ->whereIn('bag_id', $requestedBags)
        ->get()
        ->groupBy('bag_id');

        //dd('bag drop rates: ', $bagDropRates, $requestedBags);

        $orderedResults = [];

        // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
        // This is to match the conversionRates and fees
        foreach ($requestedBags as $id){
            if (isset($bagDropRates[$id])){
                $orderedResults[$id] = $bagDropRates[$id];
            }
        }

        //dd($orderedResults); 
        // Make the indexes reset to 0, 1, 2, etc instead of the item IDs
        $bagDropRates = array_values($orderedResults);

        //dd($bagDropRates);

        if ($request == 'Unbound Magic'){
            foreach ($bagDropRates as $index => $targetBag){
                if ($targetBag[0]->bag_id == 79186){
                    $duplicatedBag = clone $targetBag; 
                    $duplicatedBag->duplicated = true; 
                    $duplicatedBag->duplicated_name = 'Magic-Warped Bundle (Ember Bay)'; 

                    array_splice($bagDropRates, $index + 1, 0, [$duplicatedBag]);
                }
            }
        }

        //dd($bagDropRates, $requestedBags);

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

            foreach ($group as $item){
                $bagName = $item->bag_name;
                $icon = $item->bag_icon;

                if ($index == 1){
                    //dd($group);
                }
                //dd($item);
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
                } else if ($item->currency_id){
                    //dd($item->item_id);
                    $value = $this->getCurrencyValue($item->currency_id, $item->drop_rate, $includes, $sellOrderSetting, $tax); 
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

                
                
                $total += $value;
            }
            // Check if there's a duplicated bag
            if (isset($group->duplicated)){
                $bagName = $group->duplicated_name; 
            }

            $profitPerBag = ($total - $fee[$index]) * $outputQty[$index]; 
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
                'outputQty' => $outputQty[$index],
            ]);
        }

        $response = [
            'dropRates' => $bagDropRates,
            'bag' => $bag, 
        ];

        return response()->json($response);
    }
}
