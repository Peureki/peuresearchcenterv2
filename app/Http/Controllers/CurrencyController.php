<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Bag;
use App\Models\SampleSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    // * CURRENCY CONTROLLER
    // * 
    // * This controller is to RETURN a COLLECTION of specific bags while calculating costs/tax to get the currency
    private function getTax($tax){
        // If the tax param exist, then that will be the tax
        // Otherwise, default to 0.85
        if ($tax){
            return $tax;
        } else {
            $tax = 0.85;
            return $tax;
        }
    }

    private function getBuyOrderSetting($buyOrderSetting){
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

    private function getSellOrderSetting($sellOrderSetting){
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

    // *
    // * VOLATILE MAGIC
    // *
    // RETURN json of each shipment's value and vm per shipment
    public function volatileMagic($sellOrderSetting, $tax){
        // Initialize each shipment with the Shipment Model
        $trophyShipments = (new Bag)->setTable('trophy_shipments')->get(); 
        $metalShipments = (new Bag)->setTable('metal_shipments')->get();
        $leatherShipments = (new Bag)->setTable('leather_shipments')->get();
        $woodShipments = (new Bag)->setTable('wood_shipments')->get(); 
        $clothShipments = (new Bag)->setTable('cloth_shipments')->get(); 

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $shipments = [
            "trophyShipments" => ["name" => "Trophy Shipments"] + $this->processBags($trophyShipments, $sellOrderSetting, $tax),
            "metalShipments" => ["name" => "Metal Shipments"] + $this->processBags($metalShipments, $sellOrderSetting, $tax),
            "leatherShipments" => ["name" => "Leather Shipments"] + $this->processBags($leatherShipments, $sellOrderSetting, $tax),
            "woodShipments" => ["name" => "Wood Shipments"] + $this->processBags($woodShipments, $sellOrderSetting, $tax),
            "clothShipments" => ["name" => "Cloth Shipments"] + $this->processBags($clothShipments, $sellOrderSetting, $tax),
        ];

        return response()->json($shipments);
    }
    // *
    // * UNBOUND MAGIC
    // *
    // RETURN each unbound bag's value and unbound magic per bag
    public function unboundMagic($sellOrderSetting, $tax){
        $magicWarpedPacket = (new Bag)->setTable('magic_warped_packet')->get();
        $mistWarpedBundle = (new Bag)->setTable('mist_warped_bundle')->get(); 

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $bag = [
            "magicWarpedPacket" => ["name" => "Magic-Warped Packet"] + $this->processBags($magicWarpedPacket, $sellOrderSetting, $tax),
            "mistWarpedBundle" => ["name" => "Mist-Warped Bundle"] + $this->processBags($mistWarpedBundle, $sellOrderSetting, $tax),
        ];

        return response()->json($bag);
    }
    private function processBags($bag, $sellOrderSetting, $tax){
        // Get the table name
        $db = $bag[0]->getTable();
        $sampleSize = SampleSize::where('name', $db)->get()[0]['sample_size']; 

        // Depending on the table name, switch cost and currency per bag purchase
        switch ($db){
            // *
            // * UNBOUND MAGIC BAGS
            // *
            case 'magic_warped_packet': 
                $costPerBag = 5000; 
                $currencyPerBag = 250;
                break;
            case 'mist_warped_bundle': 
                $costPerBag = 4000; 
                $currencyPerBag = 1250;
                break;
            // *
            // * VOLATILE MAGIC BAGS
            // *
            case 'trophy_shipments':
            case 'metal_shipments':
            case 'leather_shipments':
            case 'wood_shipments':
            case 'cloth_shipments':
                $costPerBag = 10000;
                $currencyPerBag = 250;
                break;
        }
        // Initlize bag and currency values 
        $bagTotal = 0;
        $profitPerBag = 0;
        $currencyValue = 0; 
        
        // Go through each material using the $sellOrderSetting and $tax 
        foreach ($bag as $mat){
            // ->items as the items db is a foreign key attached to the bags
            $item = $mat->items; 
            $bagTotal += (($item[$sellOrderSetting] * $tax) * $mat['drop_rate']);
        }
        // Evaluate
        $profitPerBag = $bagTotal - $costPerBag; 
        $currencyValue = $profitPerBag/$currencyPerBag;

        return [
            'dbName' => $db,
            'costPerBag' => $costPerBag,
            'currencyPerBag' => $currencyPerBag,
            'total' => $bagTotal,
            'profitPerBag' => $profitPerBag,
            'currencyValue' => $currencyValue,
            'sampleSize' => $sampleSize,
        ];
    }

    public function getSpiritShards($buyOrderSetting, $sellOrderSetting, $tax){
        $jsonFilePath = base_path("resources/js/vue/components/json/recipes.json");
        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting); 
        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        foreach ($data as &$outputMat){
            foreach ($outputMat as &$ingredients){
                $outputInfo = Items::where('id', $ingredients['id'])->get()[0];

                $ingredients['value'] = $outputInfo->$sellOrderSetting; 

                foreach ($ingredients['ingredients'] as $key => &$ingredient){
                    $ingredientInfo = Items::where('id', $ingredient['id'])->get()[0]; 

                    $ingredient['icon'] = $ingredientInfo->icon; 
                    $ingredient['value'] = $ingredientInfo->$buyOrderSetting;
                }
            }
        }

        return response()->json($data);
    }

    
}
