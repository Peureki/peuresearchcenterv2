<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\ContainerDropRate;
use App\Models\CurrencyBagDropRates;
use App\Models\MixedSalvageableDropRate;
use App\Models\Salvageable;
use App\Models\SalvageableDropRate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
    protected function getContainerValue($containerID, $sellOrderSetting, $tax){
        $dropRatesTable = ContainerDropRate::
        where('bag_id', $containerID)
        ->join('items', 'container_drop_rates.item_id', '=', 'items.id')
        ->get();
        ; 

        $value = 0; 

        foreach ($dropRatesTable as $item){
            $value += ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
        }

        return $value; 
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
        $salvageTable = SalvageableDropRate::join('salvageables', 'salvageable_id', '=', 'salvageables.id')
        ->where('salvageables.item_id', $salvageableID)
        ->join('items', 'salvageable_drop_rates.item_id', '=', 'items.id')
        ->get();
    
        $salvageableValue *= $tax; 

        $copperFedValue = 0;
        $runecraftersValue = 0;
        $silverFedValue = 0; 

        foreach ($salvageTable as $item){
            switch ($item->category){
                case "Copper-Fed":
                    $copperFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                    break;
                case "Runecrafter's":
                    $runecraftersValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
                    break;
                case "Silver-Fed":
                    $silverFedValue += ($item->$sellOrderSetting * $tax) * $item->drop_rate;
                    break; 
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
        ->where('mixed_salvageables.item_id', $gearID)
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
