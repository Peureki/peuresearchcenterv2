<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Bag;
use App\Models\Recipes;
use App\Models\ResearchNotes;
use App\Models\SampleSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    // *
    // * RESEARCH NOTES
    // *
    // * RETURN recipe value and research note value
    public function researchNote($buyOrderSetting, $filter){
        $buyOrderSetting = $this->getBuyOrderSetting($buyOrderSetting);
        $filteredArray = explode(',', $filter);
        // $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        // $tax = $this->getTax($tax);

        $filteredQuery = ResearchNotes::select('*')
            ->join('recipes', 'research_note.recipe_id', '=', 'recipes.id')
            ->join('items', 'research_note.item_id', '=', 'items.id')
            ->where('items.name', 'not like', '%Plaguedoctor%');
            
        $filteredQuery->whereIn('preference', $filteredArray);
 
        // Return Research Notes db 
        // Calculate crafting_value / avg_output and sort by that (cost/note column)
        $researchNotes = $filteredQuery
            ->orderByRaw("
                CASE 
                WHEN (items.buy_price = 0 AND items.sell_price = 0) OR (items.buy_price IS NULL OR items.sell_price IS NULL)
                    THEN crafting_value / avg_output
                WHEN '$buyOrderSetting' = 'buy_price' AND items.buy_price = 0
                    THEN crafting_value / avg_output
                WHEN '$buyOrderSetting' = 'buy_price' THEN
                    CASE 
                    WHEN items.buy_price < crafting_value 
                        THEN items.buy_price / avg_output
                        ELSE crafting_value / avg_output
                    END
                WHEN '$buyOrderSetting' = 'sell_price' THEN
                    CASE 
                    WHEN items.sell_price < crafting_value
                        THEN items.sell_price / avg_output
                        ELSE crafting_value / avg_output
                    END
                END
            ")
            ->paginate(50);

        return response()->json($researchNotes);

    }
    // *
    // * LAURELS
    // *
    // * RETURN each crafint bags's value and laurels per bag
    public function laurel($sellOrderSetting, $tax){
        $heavyCraftingBag = (new Bag)->setTable('heavy_crafting_bag')->get();
        $largeCraftingBag = (new Bag)->setTable('large_crafting_bag')->get();
        $lightCraftingBag = (new Bag)->setTable('light_crafting_bag')->get(); 
        $mediumCraftingBag = (new Bag)->setTable('medium_crafting_bag')->get();
        $smallCraftingBag = (new Bag)->setTable('small_crafting_bag')->get(); 
        $tinyCraftingBag = (new Bag)->setTable('tiny_crafting_bag')->get();

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $bags = [
            "heavyCraftingBag" => ["name" => "Heavy Crafting Bag"] + $this->processBags($heavyCraftingBag, $sellOrderSetting, $tax),
            "largeCraftingBag" => ["name" => "Large Crafting Bag"] + $this->processBags($largeCraftingBag, $sellOrderSetting, $tax),
            "lightCraftingBag" => ["name" => "Light Crafting Bag"] + $this->processBags($lightCraftingBag, $sellOrderSetting, $tax),
            "mediumCraftingBag" => ["name" => "Medium Crafting Bag"] + $this->processBags($mediumCraftingBag, $sellOrderSetting, $tax),
            "smallCraftingBag" => ["name" => "Small Crafting Bag"] + $this->processBags($smallCraftingBag, $sellOrderSetting, $tax),
            "tinyCraftingBag" => ["name" => "Tiny Crafting Bag"] + $this->processBags($tinyCraftingBag, $sellOrderSetting, $tax),
        ];

        return response()->json($bags);
    }

    // *
    // * TRADE CONTRACTS
    // *
    // * RETURN each trade crate's value and trade contract per bag
    public function tradeContract($sellOrderSetting, $tax){
        $cowrieLeagueClothCrate = (new Bag)->setTable('cowrie_league_cloth_crate')->get(); 
        $cowrieLeagueLeatherCrate = (new Bag)->setTable('cowrie_league_leather_crate')->get();
        $cowrieLeagueMetalCrate = (new Bag)->setTable('cowrie_league_metal_crate')->get(); 
        $cowrieLeagueTrophyCrate = (new Bag)->setTable('cowrie_league_trophy_crate')->get(); 
        $cowrieLeagueWoodCrate = (new Bag)->setTable('cowrie_league_wood_crate')->get(); 
        $hamaseenClothCrate = (new Bag)->setTable('hamaseen_cloth_crate')->get();
        $hamaseenLeatherCrate = (new Bag)->setTable('hamaseen_leather_crate')->get(); 
        $hamaseenIngotCrate = (new Bag)->setTable('hamaseen_ingot_crate')->get(); 
        $hamaseenTrophyCrate = (new Bag)->setTable('hamaseen_trophy_crate')->get(); 
        $hamaseenWoodCrate = (new Bag)->setTable('hamaseen_wood_crate')->get(); 
        $houseOfDaoudClothCrate = (new Bag)->setTable('house_of_daoud_cloth_crate')->get();
        $houseOfDaoudLeatherCrate = (new Bag)->setTable('house_of_daoud_leather_crate')->get();
        $houseOfDaoudMetalCrate = (new Bag)->setTable('house_of_daoud_metal_crate')->get();
        $houseOfDaoudTrophyCrate = (new Bag)->setTable('house_of_daoud_trophy_crate')->get();
        $houseOfDaoudWoodCrate = (new Bag)->setTable('house_of_daoud_wood_crate')->get();

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $crates = [
            "cowrieLeagueClothCrate" => ["name" => "Cowrie League Cloth Crate"] + $this->processBags($cowrieLeagueClothCrate, $sellOrderSetting, $tax),
            "cowrieLeagueLeatherCrate" => ["name" => "Cowrie League Leather Crate"] + $this->processBags($cowrieLeagueLeatherCrate, $sellOrderSetting, $tax),
            "cowrieLeagueMetalCrate" => ["name" => "Cowrie League Metal Crate"] + $this->processBags($cowrieLeagueMetalCrate, $sellOrderSetting, $tax),
            "cowrieLeagueTrophyCrate" => ["name" => "Cowrie League Trophy Crate"] + $this->processBags($cowrieLeagueTrophyCrate, $sellOrderSetting, $tax),
            "cowrieLeagueWoodCrate" => ["name" => "Cowrie League Wood Crate"] + $this->processBags($cowrieLeagueWoodCrate, $sellOrderSetting, $tax),
            "hamaseenClothCrate" => ["name" => "Hamaseen Cloth Crate"] + $this->processBags($hamaseenClothCrate, $sellOrderSetting, $tax),
            "hamaseenLeatherCrate" => ["name" => "Hamaseen Leather Crate"] + $this->processBags($hamaseenLeatherCrate, $sellOrderSetting, $tax),
            "hamaseenIngotCrate" => ["name" => "Hamaseen Ingot Crate"] + $this->processBags($hamaseenIngotCrate, $sellOrderSetting, $tax),
            "hamaseenTrophyCrate" => ["name" => "Hamaseen Trophy Crate"] + $this->processBags($hamaseenTrophyCrate, $sellOrderSetting, $tax),
            "hamaseenWoodCrate" => ["name" => "Hamaseen Wood Crate"] + $this->processBags($hamaseenWoodCrate, $sellOrderSetting, $tax),
            "houseOfDaoudClothCrate" => ["name" => "House of Daoud Cloth Crate"] + $this->processBags($houseOfDaoudClothCrate, $sellOrderSetting, $tax),
            "houseOfDaoudLeatherCrate" => ["name" => "House of Daoud Leather Crate"] + $this->processBags($houseOfDaoudLeatherCrate, $sellOrderSetting, $tax),
            "houseOfDaoudMetalCrate" => ["name" => "House of Daoud Metal Crate"] + $this->processBags($houseOfDaoudMetalCrate, $sellOrderSetting, $tax),
            "houseOfDaoudTrophyCrate" => ["name" => "House of Daoud Trophy Crate"] + $this->processBags($houseOfDaoudTrophyCrate, $sellOrderSetting, $tax),
            "houseOfDaoudWoodCrate" => ["name" => "House of Daoud Wood Crate"] + $this->processBags($houseOfDaoudWoodCrate, $sellOrderSetting, $tax),
        ];

        return response()->json($crates);
    }

    // *
    // * VOLATILE MAGIC
    // *
    // * RETURN json of each shipment's value and vm per shipment
    public function volatileMagic($sellOrderSetting, $tax){
        // Initialize each shipment with the Shipment Model
        $trophyShipment = (new Bag)->setTable('trophy_shipment')->get(); 
        $metalShipment = (new Bag)->setTable('metal_shipment')->get();
        $leatherShipment = (new Bag)->setTable('leather_shipment')->get();
        $woodShipment = (new Bag)->setTable('wood_shipment')->get(); 
        $clothShipment = (new Bag)->setTable('cloth_shipment')->get(); 

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $shipments = [
            "trophyShipment" => ["name" => "Trophy Shipment"] + $this->processBags($trophyShipment, $sellOrderSetting, $tax),
            "metalShipment" => ["name" => "Metal Shipment"] + $this->processBags($metalShipment, $sellOrderSetting, $tax),
            "leatherShipment" => ["name" => "Leather Shipment"] + $this->processBags($leatherShipment, $sellOrderSetting, $tax),
            "woodShipment" => ["name" => "Wood Shipment"] + $this->processBags($woodShipment, $sellOrderSetting, $tax),
            "clothShipment" => ["name" => "Cloth Shipment"] + $this->processBags($clothShipment, $sellOrderSetting, $tax),
        ];

        return response()->json($shipments);
    }
    // *
    // * UNBOUND MAGIC
    // *
    // * RETURN each unbound bag's value and unbound magic per bag
    public function unboundMagic($sellOrderSetting, $tax){
        $magicWarpedPacket = (new Bag)->setTable('magic_warped_packet')->get();
        $magicWarpedBundle = (new Bag)->setTable('magic_warped_bundle')->get(); 

        $sellOrderSetting = $this->getSellOrderSetting($sellOrderSetting);
        $tax = $this->getTax($tax);

        $bag = [
            "magicWarpedPacket" => ["name" => "Magic-Warped Packet"] + $this->processBags($magicWarpedPacket, $sellOrderSetting, $tax),
            "magicWarpedBundle" => ["name" => "Magic-Warped Bundle"] + $this->processBags($magicWarpedBundle, $sellOrderSetting, $tax),
        ];

        return response()->json($bag);
    }

    private function processBags($bag, $sellOrderSetting, $tax){
        // Get the table name
        $db = $bag[0]->getTable();
        $sampleDB = SampleSize::where('name', $db)->first(); 
        if ($sampleDB){
            $sampleSize = $sampleDB->sample_size;
            $icon = $sampleDB->icon;
        }

        // Initialize
        $costPerBag = 0; // != 0 if there's an liquid gold expenses. Ex: trophy shipments cost 1g 
        $costOfCurrencyPerBag = 0; // != 0 the same currency that's being calculated is an expense. Ex: trophy shipments cost 250 vm
        $costofOtherCurrencyPerBag = 0; // != 0 if another currency is included in the expense. Ex: cowrie crates cost 630 karma

        // Initlize bag and currency values 
        $bagTotal = 0;
        $profitPerBag = 0;
        $currencyValue = 0;
        $otherCurrencyValue = 0; 

        // Depending on the table name, switch cost and currency per bag purchase
        switch ($db){
            // *
            // * LAUREL BAGS
            // *
            case strpos($db, 'crafting_bag') !== false:
                $costOfCurrencyPerBag = 1; 
                break;
            // *
            // * TRADE CONTRACT BAGS
            // *
            case strpos($db, 'cowrie') !== false: 
            case strpos($db, 'hamaseen') !== false:
            case strpos($db, 'daoud') !== false:
                $costOfCurrencyPerBag = 50;
                $costofOtherCurrencyPerBag = 630; 
                break;
            // *
            // * UNBOUND MAGIC BAGS
            // *
            case 'magic_warped_packet': 
                $costPerBag = 5000; 
                $costOfCurrencyPerBag = 250;
                break;
            case 'magic_warped_bundle': 
                $costPerBag = 4000; 
                $costOfCurrencyPerBag = 1250;
                break;
            // *
            // * VOLATILE MAGIC BAGS
            // *
            case 'trophy_shipment':
            case 'metal_shipment':
            case 'leather_shipment':
            case 'wood_shipment':
            case 'cloth_shipment':
                $costPerBag = 10000;
                $costOfCurrencyPerBag = 250;
                break;
        }
        
        // Go through each material using the $sellOrderSetting and $tax 
        // -> return the total value of the bag
        foreach ($bag as $mat){
            // ->items as the items db is a foreign key attached to the bags
            $item = $mat->items; 
            $bagTotal += (($item[$sellOrderSetting] * $tax) * $mat['drop_rate']);
        }
        // Evaluate
        $profitPerBag = $bagTotal - $costPerBag; 
        // Check if not dividing by 0
        if ($costOfCurrencyPerBag != 0){
            $currencyValue = $profitPerBag/$costOfCurrencyPerBag;
        }
        if ($costofOtherCurrencyPerBag != 0){
            $otherCurrencyValue = $profitPerBag/$costofOtherCurrencyPerBag; 
        }
        
        return [
            'dbName' => $db,
            'icon' => $icon,
            'costPerBag' => $costPerBag,
            'costOfCurrencyPerBag' => $costOfCurrencyPerBag,
            'costOfOtherCurrencyPerBag' => $costofOtherCurrencyPerBag,
            'total' => $bagTotal,
            'profitPerBag' => $profitPerBag,
            'currencyValue' => $currencyValue,
            'otherCurrencyValue' => $otherCurrencyValue,
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

        // >> OUTPUT MATERIAL LIST
        foreach ($data as &$outputList){

            // >> OUTPUT MATERIAL
            foreach ($outputList as &$outputMat){
                // Initialize final values
                $profitPerConversion = 0;
                $profitPerSpiritShard = 0;
                $philosopherStone = 0;
                $mysticCrystal = 0;
                // Get more info out of the output items via Items table
                $outputInfo = Items::where('id', $outputMat['id'])->get()[0];

                // Set up a new property 'value' with the sellOrderSetting * output amount
                $outputMat['value'] = $outputInfo->$sellOrderSetting * $outputMat['count'] * $tax; 

                // >> INDIVIDUAL INGREDIENTS
                foreach ($outputMat['ingredients'] as $key => &$ingredient){
                    // Get more info out of the individual ingredient items via Items table
                    $ingredientInfo = Items::where('id', $ingredient['id'])->get()[0]; 
                    
                    // Get the icon and set a new value property with the buyOrderSetting
                    $ingredient['name'] = $ingredientInfo->name;
                    $ingredient['icon'] = $ingredientInfo->icon; 
                    $ingredient['value'] = $ingredientInfo->$buyOrderSetting * $ingredient['count'] * $tax;
                    // For each ingredient, add each of their values for the profit/conversion
                    $profitPerConversion += $ingredient['value']; 
                    // Check if the ingredient is a spirit shard item
                    if ($ingredient['name'] == "Philosopher's Stone"){
                        $philosopherStone = $ingredient['count'] / 10; 
                    }
                    if ($ingredient['name'] == "Mystic Crystal"){
                        $mysticCrystal = $ingredient['count'] * 0.6;
                    }
                }
                $profitPerConversion = $outputMat['value'] - $profitPerConversion; 
                $profitPerSpiritShard = $profitPerConversion / ($philosopherStone + $mysticCrystal);

                $outputMat['profitPerConversion'] = $profitPerConversion; 
                $outputMat['profitPerSpiritShard'] = $profitPerSpiritShard;
            }
        }
        return response()->json($data);
    }

    
}
