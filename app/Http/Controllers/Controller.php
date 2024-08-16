<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\BagDropRate;
use App\Models\ConsumableDropRate;
use App\Models\ContainerDropRate;
use App\Models\CopperFedSalvageableDropRate;
use App\Models\CurrencyBagDropRates;
use App\Models\FishDropRate;
use App\Models\MixedSalvageableDropRate;
use App\Models\RunecraftersSalvageableDropRate;
use App\Models\Salvageable;
use App\Models\SalvageableDropRate;
use App\Models\SilverFedSalvageableDropRate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use PDO;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Convert regular strings into db name formats 
    // Ex: Trophy Shipments => trophy_shipments
    protected function stringToDBFormat($name){
        $dbName = strtolower(str_replace([' ', '-'], '_', $name));
        return $dbName; 
    }

    protected function dbNameToNormalString($name){
        switch ($name){
            case "magic_warped_packet":
                $dbName = "Magic-Warped Packet"; 
                break; 
            case "magic_warped_bundle":
                $dbName = "Magic-Warped Bundle";
                break;
            default: 
                $dbName = ucwords(str_replace('_', ' ', $name)); 
                break;
        }
        return $dbName;
    }

    protected function getTax($tax){
        // If the tax param exist, then that will be the tax
        // Otherwise, default to 0.85
        if ($tax){
            return $tax;
        } else {
            $tax = 0.85;
            return $tax;
        }
    }

    protected function getBuyOrderSetting($buyOrderSetting){
        // If the price setting exist, then be that
        // Otherwise, default to buy_price
        // sell_price and buy_price are going to be params for the items table to get their respective columns in the db
        if ($buyOrderSetting){
            if ($buyOrderSetting == 'sell_price'){
                $buyOrderSetting == 'sell_price';
            } 
            if ($buyOrderSetting == 'buy_price'){
                $buyOrderSetting == 'buy_price';
            }
        } else {
            $buyOrderSetting = 'buy_price';
        }
        return $buyOrderSetting;
    }

    protected function getSellOrderSetting($sellOrderSetting){
        // If the price setting exist, then be that
        // Otherwise, default to sell_price
        // sell_price and buy_price are going to be params for the items table to get their respective columns in the db
        if ($sellOrderSetting){
            if ($sellOrderSetting == 'sell_price'){
                $sellOrderSetting == 'sell_price';
            } 
            if ($sellOrderSetting == 'buy_price'){
                $sellOrderSetting == 'buy_price';
            }
        } else {
            $sellOrderSetting = 'sell_price';
        }
        return $sellOrderSetting;
    }

    // GET CONTAINER VALUE
    // ie. Bag of Fish in Bounty of New Kaineng City bag
    // Get the value of a container that's within another bag since these container have their own drop tables and loot and not a straight up sell price
    protected function getContainerValue($containerID, $includes, $sellOrderSetting, $tax){
        $dropRatesTable = BagDropRate::
        where('bag_id', $containerID)
        ->join('items', 'bag_drop_rates.item_id', '=', 'items.id')
        ->get();
        ; 

        $value = 0; 

        foreach ($dropRatesTable as $item){
            if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                $value += $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
            } 
            // CHAMP BAGS, CONTAINERS
            else if ($item->type == "Container" && strpos($item->description, 'Salvage') === false){
                $value += $this->getContainerValue($item->item_id, $includes,$sellOrderSetting, $tax); 
            } 
            // SALVAGEABLES (exclu uni gear)
            else if ($item->description === "Salvage Item" && in_array('Salvageables', $includes)){
                $value += $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
            }
            // ASCENDED JUNK
            else if ($item->rarity == 'Ascended' && $item->type == 'CraftingMaterial' && in_array('AscendedJunk', $includes)) {
                // There's a lot of ascended and crafteringMaterials so switch the $item->name to check for specifically the ascended junk
                switch ($item->name){
                    case 'Dragonite Ore':
                        $value += $this->getAscendedJunkValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                        break;
                }
            }
            // JUNK
            else if ($item->rarity === "Junk"){
                $value += $item->vendor_value * $item->drop_rate; 
            }
            // ANYTHING ELSE NOT FROM ABOVE 
            else {
                $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
            }
        }

        return $value; 
    }

    protected function getFishValue($fishID, $sellOrderSetting, $tax){
        $fishDropRates = FishDropRate::
        where('fish_id', $fishID)
        ->join('items', 'fish_drop_rates.item_id', '=', 'items.id')
        ->get(); 

        $value = 0;

        foreach ($fishDropRates as $item){
            $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
        }

        return $value;
    }

    protected function getCurrencyValue($currencyID, $currencyDropRate, $includes, $sellOrderSetting, $tax){
        
        $containerIDs = [];

        switch ($currencyID){
            // GOLD
            case 1: 
                return 1 * $currencyDropRate;
            //UNBOUND MAGIC
            case 32:
                $containerIDs = array_merge($containerIDs, [79114, 79186]);
                $conversionRate = 1250; 
                $fee = 4000;
                break;

            // TRADE CONTRACTS
            case 34:
                $containerIDs = array_merge($containerIDs, [84783, 83352, 84254, 83265, 82825, 82564, 83419, 83298, 83462, 82946, 82219, 83554, 83582, 84668, 82969]);
                $conversionRate = 50;
                $fee = 0;
                break;

            // VOLATILE MAGIC
            case 45:
                $containerIDs = array_merge($containerIDs, [85873, 86231, 85725, 86053, 85990]);
                $conversionRate = 250; 
                $fee = 10000;
                break;
            default: return; 
        }

        $containerTable = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
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
        ->whereIn('bag_id', $containerIDs)
        ->get()
        ->groupBy('bag_id');

        //dd('container table: ', $containerTable);

        $containerTable = $containerTable->values();

        $allValues = []; 

        foreach ($containerTable as $group){
            $value = 0;
            foreach ($group as $item){
                // Check if there's uni gear && if toggled in Includes settings
                if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                    $value += $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                    
                } 
                // Check if there's salvageables && if toggled in Includes settings
                else if ($item->description === "Salvage Item" && in_array('Salvageables', $includes)){
                    $value += $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                }
                // Junk items
                else if ($item->rarity === 'Junk'){
                    $value += $item->vendor_value * $item->drop_rate;
                }
                // Everything else
                else {
                    $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                }
            }
            array_push($allValues, $value); 
        }
        
            $currencyValue = (max($allValues) - $fee) / $conversionRate; 
        

        return $currencyValue * $currencyDropRate; 

        
    }

    protected function getConsumableValue($consumableID, $consumableDropRate, $includes, $sellOrderSetting, $tax){
        $consumableTable = ConsumableDropRate::where('consumable_id', $consumableID)->get(); 

        $value = $this->getCurrencyValue($consumableTable[0]->currency_id, $consumableTable[0]->drop_rate, $includes, $sellOrderSetting, $tax); 

        return $value * $consumableDropRate; 
    }

    protected function getAscendedJunkValue($ascendedID, $ascendedValue, $ascendedDropRate, $includes, $sellOrderSetting, $tax){

        $containerIDs = [];

        switch ($ascendedID){
            // DRAGONITE ORE
            // List specific bags associated with dragonite ore conversions
            case 46733:
                array_push($containerIDs, 
                    [
                        // Fluctuating Mass
                        'id' => 79264,
                        'conversionRate' => 25
                    ],
                ); 
                break;
            // EMPYREAL FRAGMENTS
            case 46735:
                array_push($containerIDs, 
                    [
                        // Fluctuating Mass
                        'id' => 79264,
                        'conversionRate' => 25
                    ],
                ); 
                break;
            // PILE OF BLOODSTONE DUST
            case 46731:
                array_push($containerIDs, 
                    [
                        // Fluctuating Mass
                        'id' => 79264,
                        'conversionRate' => 25
                    ],
                ); 
                break;
        }
        // Only grab the 'ids' from $containerIDs for the query
        $containerIDQuery = array_column($containerIDs, 'id');

        $containerTable = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
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
        ->whereIn('bag_id', $containerIDQuery)
        ->get()
        ->groupBy('bag_id');

        $containerTable = $containerTable->values();

        foreach ($containerTable as $index => $group){
            $value = 0; 
            $currencyPerContainer = 0;

            foreach ($group as $item){
                // Check if there's uni gear && if toggled in Includes settings
                if (strpos($item->name, "Unidentified Gear") !== false && in_array('Salvageables', $includes)){
                    $value += $this->getUnidentifiedGearValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                    
                } 
                // Check if there's salvageables && if toggled in Includes settings
                else if ($item->description === "Salvage Item" && in_array('Salvageables', $includes)){
                    $value += $this->getSalvageableValue($item->item_id, $item->$sellOrderSetting, $item->drop_rate, $sellOrderSetting, $tax);
                }
                // Junk items
                else if ($item->rarity === 'Junk'){
                    $value += $item->vendor_value * $item->drop_rate;
                }
                // Everything else
                else {
                    $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                }
                
            }
            // Take total value and / by conversion rate of the container and ascended junk
            $currencyValuePerContainer = $value / $containerIDs[$index]['conversionRate'];
            
        }
        return $currencyValuePerContainer * $ascendedDropRate; 
    }

    // GET SALVAGEABLE VALUE
    // Goal: 
    // Determine if salvging salvageable items is worth more than selling it straight to the tp
    // 
    // If yes => return and add that value on top of the salvageable buy/sell price
    // If no => return salvageable buy/sell price 
    // 
    // This function is used to determine of salvageable gear value dropped in bags or other sources 
    protected function getSalvageableValue($salvageableID, $salvageableValue, $salvageableDropRate, $sellOrderSetting, $tax){
        $copperFedDropRates = CopperFedSalvageableDropRate::join('copper_fed_salvageables', 'copper_fed_salvageable_drop_rates.copper_fed_salvageable_id', '=', 'copper_fed_salvageables.id')
        ->where('copper_fed_salvageables.id', $salvageableID)
        ->join('items', 'copper_fed_salvageable_drop_rates.item_id', '=', 'items.id')
        ->get(); 

        $runecraftersDropRates = RunecraftersSalvageableDropRate::join('runecrafters_salvageables', 'runecrafters_salvageable_drop_rates.runecrafters_salvageable_id', '=', 'runecrafters_salvageables.id')
        ->where('runecrafters_salvageables.id', $salvageableID)
        ->join('items', 'runecrafters_salvageable_drop_rates.item_id', '=', 'items.id')
        ->get(); 

        $silverFedDropRates = SilverFedSalvageableDropRate::join('silver_fed_salvageables', 'silver_fed_salvageable_drop_rates.silver_fed_salvageable_id', '=', 'silver_fed_salvageables.id')
        ->where('silver_fed_salvageables.id', $salvageableID)
        ->join('items', 'silver_fed_salvageable_drop_rates.item_id', '=', 'items.id')
        ->get(); 

        $salvageableValue *= $tax; 

        $salvageKitData = array($copperFedDropRates, $runecraftersDropRates, $silverFedDropRates); 

        $copperFedValue = 0;
        $runecraftersValue = 0;
        $silverFedValue = 0; 

        foreach ($salvageKitData as $kitIndex => $kit){
            foreach ($kit as $item){
                // Compare each kit
                // 0 == Copper
                // 1 == Runecrafters
                // 2 = Silver
                switch ($kitIndex){
                    case 0: 
                        $copperFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                        break;
                    case 1:
                        $runecraftersValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                        break;
                    case 2: 
                        $silverFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
                        break;  
                }
            }
        }

        // Profit values for each salvage kit
        $copperFedValue = ($copperFedValue - $salvageableValue) - 3; 
        $runecraftersValue = ($runecraftersValue - $salvageableValue) - 30; 
        $silverFedValue = ($silverFedValue - $salvageableValue) - 60; 
        // Input the best out of the 3 into this
        $bestValue = 0;

        // Check if any of the salvage values are above 0
        // If yes => do checks to see which is the highest value
        if ($copperFedValue > 0 || $runecraftersValue > 0 || $silverFedValue > 0){
            // Check copperfed
            if ($copperFedValue > $runecraftersValue && $copperFedValue > $silverFedValue) {
                $bestValue = $copperFedValue; 
            // Check runecrafter's
            } else if ($runecraftersValue > $copperFedValue && $runecraftersValue > $silverFedValue) {
                $bestValue = $runecraftersValue;
            // Otherwise silverfed
            } else {
                $bestValue = $silverFedValue; 
            }
        }

        // If any of the 3 salvage kit values are > 0
        // => return that value 
        // => else return value without salvaging
        if ($bestValue > 0){
            return ($bestValue + $salvageableValue) * $salvageableDropRate; 
        } else {
            return $salvageableValue * $salvageableDropRate; 
        }
    }


    // protected function getMerp($salvageableID, $salvageableValue, $salvageableDropRate, $sellOrderSetting, $tax){
    //     $salvageTable = SalvageableDropRate::join('salvageables', 'salvageable_id', '=', 'salvageables.id')
    //     ->where('salvageables.item_id', $salvageableID)
    //     ->join('items', 'salvageable_drop_rates.item_id', '=', 'items.id')
    //     ->get();
    
    //     $salvageableValue *= $tax; 

    //     $copperFedValue = 0;
    //     $runecraftersValue = 0;
    //     $silverFedValue = 0; 

    //     foreach ($salvageTable as $item){
    //         switch ($item->category){
    //             case "Copper-Fed":
    //                 $copperFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
    //                 break;
    //             case "Runecrafter's":
    //                 $runecraftersValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
    //                 break;
    //             case "Silver-Fed":
    //                 $silverFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
    //                 break; 
    //         }
    //     }

    //     // Profit values for each salvage kit
    //     $copperFedValue = ($copperFedValue - $salvageableValue) - 3; 
    //     $runecraftersValue = ($runecraftersValue - $salvageableValue) - 30; 
    //     $silverFedValue = ($silverFedValue - $salvageableValue) - 60; 
    //     // Input the best out of the 3 into this
    //     $bestValue = 0;

    //     // Check if any of the salvage values are above 0
    //     // If yes => do checks to see which is the highest value
    //     if ($copperFedValue > 0 || $runecraftersValue > 0 || $silverFedValue > 0){
    //         // Check copperfed
    //         if ($copperFedValue > $runecraftersValue && $copperFedValue > $silverFedValue) {
    //             $bestValue = $copperFedValue; 
    //         // Check runecrafter's
    //         } else if ($runecraftersValue > $copperFedValue && $runecraftersValue > $silverFedValue) {
    //             $bestValue = $runecraftersValue;
    //         // Otherwise silverfed
    //         } else {
    //             $bestValue = $silverFedValue; 
    //         }
    //     }
    //     // If any of the 3 salvage kit values are > 0
    //     // => return that value 
    //     // => else return value without salvaging
    //     if ($bestValue > 0){
    //         return ($bestValue + $salvageableValue) * $salvageableDropRate; 
    //     } else {
    //         return $salvageableValue * $salvageableDropRate; 
    //     }
    // }

    // GET UNI GEAR SALVAGE VALUE
    // Goal: 
    // Determine if opening and salvging uni gear is worth more than selling straight up uni gear
    // 
    // If yes => return and add that value on top of the uni buy/sell price
    // If no => return uni buy/sell price 
    // 
    // This function is used to determine of uni gear value dropped in bags or other sources 
    protected function getUnidentifiedGearValue($gearID, $gearValue, $gearDR, $sellOrderSetting, $tax){
        $salvageTable = MixedSalvageableDropRate::join('mixed_salvageables', 'mixed_salvageable_id', '=', 'mixed_salvageables.id')
        ->where('mixed_salvageables.id', $gearID)
        ->join('items', 'mixed_salvageable_drop_rates.item_id', '=', 'items.id')
        ->get(); 

        // Initialize original item with tax to compare later
        $gearValue *= $tax; 

        $value = 0;
        $total = 0;
        $fee = 0;
        $profit = 0;

        foreach ($salvageTable as $item){
            switch ($item->name){
                case "Copper-Fed Salvage-o-Matic":
                    $fee = $item->drop_rate;
                    break;

                case "Runecrafter's Salvage-o-Matic":
                    $fee = $item->drop_rate; 
                    break;

                case "Silver-Fed Salvage-o-Matic":
                    $fee = $item->drop_rate; 
                    break;

                default: 
                    $value = ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
                    break; 
            }

            $total += $value - $fee; 
        }

        $profit = $total - $gearValue; 

        if ($profit > 0){
            return ($profit + $gearValue) * $gearDR; 
        } 
        else {
            return $gearValue * $gearDR;
        }
    }
}
