<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    // * BAG CONTROLLER
    // * 
    // * This controller is to return a COLLECTION of bags

    // *
    // * VOLATILE MAGIC
    // *
    public function volatileMagic($priceSetting, $tax){
        // Initialize each shipment with the Shipment Model
        $trophyShipments = (new Shipment)->setTable('trophy_shipments')->get(); 
        $metalShipments = (new Shipment)->setTable('metal_shipments')->get();
        $leatherShipments = (new Shipment)->setTable('leather_shipments')->get();
        $woodShipments = (new Shipment)->setTable('wood_shipments')->get(); 
        $clothShipments = (new Shipment)->setTable('cloth_shipments')->get(); 

        // If the tax param exist, then that will be the tax
        // Otherwise, default to 0.85
        if ($tax){
            $tax = $tax;
        } else {
            $tax = 0.85; 
        }
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
        
        $shipments = [
            "trophyShipments" => ["name" => "Trophy Shipments"] + $this->processShipment($trophyShipments, $priceSetting, $tax),
            "metalShipments" => ["name" => "Metal Shipments"] + $this->processShipment($metalShipments, $priceSetting, $tax),
            "leatherShipments" => ["name" => "Leather Shipments"] + $this->processShipment($leatherShipments, $priceSetting, $tax),
            "woodShipments" => ["name" => "Wood Shipments"] + $this->processShipment($woodShipments, $priceSetting, $tax),
            "clothShipments" => ["name" => "Cloth Shipments"] + $this->processShipment($clothShipments, $priceSetting, $tax),
        ];

        return response()->json($shipments);
    }

    private function processShipment($bag, $priceSetting, $tax){
        $shipmentValue = 0;
        $currencyValue = 0;

        foreach ($bag as $mat){
            // items is the foriegn key to access the main items table
            $item = $mat->items; 
            $shipmentValue += ($item[$priceSetting] * $tax) * $mat['drop_rate'];
        }

        $currencyValue = ($shipmentValue - 10000)/250;

        return [
            'shipmentValue' => $shipmentValue, 
            'currencyValue' => $currencyValue
        ]; 
    }

    
}
