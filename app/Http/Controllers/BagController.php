<?php

namespace App\Http\Controllers;

use App\Models\ContainerDropRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        foreach ($request as $exchangeable){
            switch ($exchangeable){
                case "Empyreal Fragment":
                    // Fluctuating Mass
                    array_push($requestedBags, 79264);
                case "Dragonite Ore":
                    // Fluctuating Mass
                    array_push($requestedBags, 79264);
                    break;
            }
        }

        $response = []; 
        $bag = [];

        $containerDropRatesTable = ContainerDropRate::join('bags', 'container_drop_rates.bag_id', '=', 'bags.id')
        ->join('items as item', 'container_drop_rates.item_id', '=', 'item.id')
        ->join('items as bag_item', 'bags.id', '=', 'bag_item.id')
        ->select(
            'container_drop_rates.*', 
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
        ){
            foreach ($containerDropRatesTable as $id => $container){
                // Fluctuating Mass
                if ($id == 79264){
                    // ORDER is to distinquish each bag with different conversions of the same Exchangeable
                    $container->order = 0; 
                    $duplicateBag = clone $container;
                    $duplicateBag->order = 1;
                    $containerDropRatesTable->push($duplicateBag);
                }
            }
        }

        //dd($containerDropRatesTable);

        foreach ($containerDropRatesTable as $group){
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
                if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){

                    $value = $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                    
                } 
                else if ($item->description === "Salvage Item" && in_array('Salvageables', $includes)){
                    $value = $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                }
                
                
                else {
                    $value = ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                }

                $item->value = $value;

                $bagName = $item->bag_name;
                $icon = $item->bag_icon;
                
                $total += $value;
            }

            switch (true){
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

        $containerDropRatesTable = $containerDropRatesTable->values(); 

        $response = [
            'dropRates' => $containerDropRatesTable,
            'bag' => $bag, 
        ];

        return response()->json($response);
    }
}
