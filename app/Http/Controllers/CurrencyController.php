<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Bag;
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

    private function getPriceSetting($priceSetting){
        // If the price setting exist, then be that
        // Otherwise, default to sell_price
        // sell_price and buy_price are going to be params for the items table to get their respective columns in the db
        if ($priceSetting){
            if ($priceSetting == 'sell_price'){
                $priceSetting == 'sell_price';
            } 
            if ($priceSetting == 'buy_price'){
                $priceSetting == 'buy_price';
            }
        } else {
            $priceSetting = 'sell_price';
        }
        return $priceSetting;
    }

    // *
    // * VOLATILE MAGIC
    // *
    // RETURN json of each shipment's value and vm per shipment
    public function volatileMagic($priceSetting, $tax){
        // Initialize each shipment with the Shipment Model
        $trophyShipments = (new Bag)->setTable('trophy_shipments')->get(); 
        $metalShipments = (new Bag)->setTable('metal_shipments')->get();
        $leatherShipments = (new Bag)->setTable('leather_shipments')->get();
        $woodShipments = (new Bag)->setTable('wood_shipments')->get(); 
        $clothShipments = (new Bag)->setTable('cloth_shipments')->get(); 

        $priceSetting = $this->getPriceSetting($priceSetting);
        $tax = $this->getTax($tax);

        $shipments = [
            "trophyShipments" => ["name" => "Trophy Shipments"] + $this->processBags($trophyShipments, $priceSetting, $tax),
            "metalShipments" => ["name" => "Metal Shipments"] + $this->processBags($metalShipments, $priceSetting, $tax),
            "leatherShipments" => ["name" => "Leather Shipments"] + $this->processBags($leatherShipments, $priceSetting, $tax),
            "woodShipments" => ["name" => "Wood Shipments"] + $this->processBags($woodShipments, $priceSetting, $tax),
            "clothShipments" => ["name" => "Cloth Shipments"] + $this->processBags($clothShipments, $priceSetting, $tax),
        ];

        return response()->json($shipments);
    }

    private function processShipment($bag, $priceSetting, $tax){
        $shipmentValue = 0;
        $currencyValue = 0;

        foreach ($bag as $mat){
            // items is the foriegn key to access the main items table
            $item = $mat->items; 
            $shipmentValue += (($item[$priceSetting] * $tax) * $mat['drop_rate']);
        }
        // Cost to buy each shipment is 1g (10000) and 250VM 
        $shipmentValue -= 10000; 
        $currencyValue = ($shipmentValue)/250;

        return [
            'shipmentValue' => $shipmentValue, 
            'currencyValue' => $currencyValue
        ]; 
    }
    // *
    // * UNBOUND MAGIC
    // *
    // RETURN each unbound bag's value and unbound magic per bag
    public function unboundMagic($priceSetting, $tax){
        $magicWarpedPacket = (new Bag)->setTable('magic_warped_packet')->get();
        $mistWarpedBundle = (new Bag)->setTable('mist_warped_bundle')->get(); 

        $priceSetting = $this->getPriceSetting($priceSetting);
        $tax = $this->getTax($tax);

        $bag = [
            "magicWarpedPacket" => ["name" => "Magic-Warped Packet"] + $this->processBags($magicWarpedPacket, $priceSetting, $tax),
            "mistWarpedBundle" => ["name" => "Mist-Warped Bundle"] + $this->processBags($mistWarpedBundle, $priceSetting, $tax),
        ];

        return response()->json($bag);
    }
    private function processBags($bag, $priceSetting, $tax){
        // Get the table name
        $db = $bag[0]->getTable();
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
        $bagSubValue = 0;
        $bagValue = 0;
        $currencyValue = 0; 
        
        // Go through each material using the $priceSetting and $tax 
        foreach ($bag as $mat){
            // ->items as the items db is a foreign key attached to the bags
            $item = $mat->items; 
            $bagSubValue += (($item[$priceSetting] * $tax) * $mat['drop_rate']);
        }
        // Evaluate
        $bagValue = $bagSubValue - $costPerBag; 
        $currencyValue = $bagValue/$currencyPerBag;

        return [
            'dbName' => $db,
            'costPerBag' => $costPerBag,
            'currencyPerBag' => $currencyPerBag,
            'bagSubValue' => $bagSubValue,
            'bagValue' => $bagValue,
            'currencyValue' => $currencyValue
        ];
    }

    
}
