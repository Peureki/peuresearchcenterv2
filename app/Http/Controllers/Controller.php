<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\CurrencyBagDropRates;
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

    protected function getContainerValue($containerID, $sellOrderSetting, $tax){
        $dropRatesTable = CurrencyBagDropRates::
        where('bag_id', $containerID)
        ->join('items', 'currency_bag_drop_rates.item_id', '=', 'items.id')
        ->get();
        ; 

        $value = 0; 

        foreach ($dropRatesTable as $item){
            $value += ($item->$sellOrderSetting * $tax) * ($item->drop_rate); 
        }

        return $value; 

    }
}
