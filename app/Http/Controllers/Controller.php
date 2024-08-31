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
    
    // *
    // * PREMADE BAG EXCHANGES
    // * Use key names
    // * 'id' => array of ids of bags or items needed to find the value of currency or target
    // * 'conversionRate' => match index array of 'id'. Associate the conversion rate specific to an index
    // * 'fee' => same as 'conversionRate' 
    // *
    // * DAILY EXCHANGES VIA Ley Energy Matter, Wizard Tower, etc
    // * These are the same with slight variations 1 or 2 items
    protected $dailyExchanges;
    // For Dragontie Ore, Bloodstone Dust, Emp Fragments
    protected $dailyAscendedJunk;

    protected $airshipPart;
    protected $ascendedJunk; 
    protected $banditCrest;
    protected $currencyBags;
    protected $dragoniteOre; 
    protected $empyrealFragment;
    protected $exchangeableIDs;
    
    protected $fineAndMasterworkRiftEssences;
    protected $geode;
    protected $imperialFavor;
    protected $jadeSliver;
    protected $laurel;
    protected $leyEnergyMatter;
    protected $rareRiftEssence; 
    protected $pileOfBloodstoneDust;
    protected $tradeContract;
    protected $tyrianDefenseSeal;
    protected $unboundMagic;
    protected $volatileMagic; 
    protected $writs;

    // NON-MONETIZABLE EXCHANGEABLES
    // Example:
    // Homested materials
    protected $homesteadWood;

    protected $exchangeableMap; 

    public function __construct()
    {
        // Use this for other daily material exchanges
        // Static Charge
        // Pinch of Stardust
        // Calcified Gasp
        // etc
        // COUNT: 21 items
        $this->dailyExchanges = [  
            67259, // Bag of Obsidian 
            67249, // Medium Bag of Obsidian
            67250, // Large Bag of Obsidian
            67264, // Rune Bag (Masterwork)
            67263, // Rune Bag (Rare)
            67266, // Sigil Bag (Masterwork)
            67265, // Sigil Bag (Rare)
            67260, // Bag of Masterwork Gear
            67261, // Bag of Rare Gear
            39124, // Heavy Crafting Bag
            39123, // Large Crafting Bag
            39121, // Light Crafting Bag
            39122, // Medium Crafting Bag
            39120, // Small Crafting Bag
            39119, // Tiny Crafting Bag
            67246, // Bag of Scrap
            67269, // Trophy Bag (Fine)
            67268, // Tropy Bag (Masterwork),
            67267, // Trophy Bag (Rare),
            9257, // Bag of Jewels
            67247, // Bag of Educational Supplies
            67253, // Bag of Bloodstone
            67251, // Bag of Dragonite Ore
            50027, // Bag of Empyreal Fragment
        ];

        // Dragonite Ore
        // Empy Fragments
        // Pile of Bloodstone
        $this->ascendedJunk = [
            'id' => [
                79264, // Fluctuating Mass
                101727, // Astral Fluctuating Mass
                101727, // Astral Fluctuating Mass (60 conversion)
            ],
            'conversionRate' => array_merge(
                array_fill(0, 2, 25),
                [60]
            ),
            'fee' => array_fill(0, 3, 0),
            'outputQty' => array_fill(0, 3, 1),
        ];

        $this->airshipPart = [
            'id' => 
                array_merge($this->dailyExchanges, [
                // 67253, // Bag of Bloodstone
                // 67251, // Bag of Dragonite Ore
                // 50027, // Bag of Empyreal Fragment
                // 73711, // Bag of Aurillium (10)
                // 74212, // Bag of Leyline (10)
            ]),
            'conversionRate' => array_fill(0, 26, 25),
            'fee' => array_fill(0, 26, 0),
            'outputQty' => array_fill(0, 26, 1),
        ];

        $this->banditCrest = [
            'id' => [66399, 67261],
            'conversionRate' => [15, 250],
            'fee' => [80, 2000],
            'outputQty' => [1, 1],
        ];

        // This is a list of currencies contained in bags that need to be defined specifically to get their values exchanged or to find their values in other bags that otherwise can't be defined by various methods such as:
        // $item->type, $item->description, etc
        //
        // Example items:
        // Bag of Aurillium, 73711
        $this->currencyBags = [
            73711, // Bag of Aurillium (10)
            74212,  // Bag of Ley-line crystals (10)
            69985, // Bandit Crest 
        ];

        $this->dragoniteOre = [
            'id' => $this->ascendedJunk['id'],
            'conversionRate' => $this->ascendedJunk['conversionRate'],
            'fee' => $this->ascendedJunk['fee'],
            'outputQty' => $this->ascendedJunk['outputQty'],
        ];

        $this->empyrealFragment = [
            'id' => $this->ascendedJunk['id'],
            'conversionRate' => $this->ascendedJunk['conversionRate'],
            'fee' => $this->ascendedJunk['fee'],
            'outputQty' => $this->ascendedJunk['outputQty'],
        ];

        // LIST OF EXCHANGEABLE IDS
        // Use this list to find if a drop contains an Exchangeable and get their values
        // Example: 
        // Bloodstone Dust
        // Rift Essences
        $this->exchangeableIDs = [
            46731, // Pile of Bloodstone Dust
            46735, // Empyreal Fragment
            46733, // Dragonite Ore
            100078, // Fine Rift Essence
            100414, // Masterwork Rift Essence
            100055, // Rare Rift Essence
        ];

        

        $this->fineAndMasterworkRiftEssences = [
            'id' => [
                101727, // Astral Fluc Mass
                73711, // Bag of Aurillum (10)
                74212, // Bag of Leyline Crystals (10)
                69985, // Bandit Crest
                101870, // Extra-Large Calcified Gasp
                101862, // Extra-Large Pinch of Stardust
                101797, // Extra-Large Static Charge
                66593, // Geode
                74249, // Large Bag of Airship Parts
                83878, // Pile of Elonian Trade Contracts
                94228, // Tyrian Defense Seal
                95692, // Writ of Dragon's End
                96561, // Writ of Echovald Wilds
                96533, // Writ of New Kaineng City
                96680, // Writ of Seitung Province
            ],
            'conversionRate' => [
                25, 
                35,
                35,
                35, 
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35
            ],
            'fee' => array_fill(0, 15, 0),
            'outputQty' => [
                1, 
                1,
                1,
                10,
                1,
                1,
                1,
                10,
                1,
                10,
                10,
                2,
                2,
                2,
                2,
            ],
        ];

        $this->geode = [
            'id' => [66399],
            'conversionRate' => [28],
            'fee' => [1024],
            'outputQty' => [1],
        ];

        $this->imperialFavor = [
            'id' => [
                // Antique Summoning Stone
                96978, 
                // Bounty of [city]
                95796, 97797, 95771, 96345
            ],
            'conversionRate' => [
                100, 
                200, 200, 200, 200
            ],
            'fee' => array_fill(0, 5, 0),
            'outputQty' => [
                1,
                1, 1, 1, 1
            ],
        ];

        $this->jadeSliver = [
            'id' => [
                // Airship Part, Bag of Aurillium, Bag of Ley Line, Bandit Crest, Geode, Tyrian Defense Seal
                74494, 73020, 73616, 69985, 66593, 94228,
                // Cloth Shipment, Leather Shipment, Metal Shipment, Wood Shipment
                85873, 86231, 85990, 86053,
                 // Season 4 Currency Box
                92311,
                // Writ of Dragon, Writ of Echovald, Writ of Kaineng, Writ of Seitung
                95692, 96561, 96533, 96680
            ],
            'conversionRate' => [
                10, 10, 20, 10, 10, 10,
                600, 1600, 600, 600,
                100,
                50, 50, 50, 50
            ],
            'fee' => array_fill(0, 15, 0),
            'outputQty' => array_fill(0, 15, 1),
        ];

        // Crafting Bags
        $this->laurel = [
            'id' => [39124, 39123, 39121, 39122, 39119],
            'conversionRate' => array_fill(0, 5, 1),
            'fee' => array_fill(0, 5, 0),
            'outputQty' => array_fill(0, 5, 1),
        ];
        // EX: LEY ENERGY MATTER CONVERTER
        // Use for: Airship Parts, Aurillium, Ley Line Crystals
        $this->leyEnergyMatter = [
            'id' => [67259, 67249, 67250, 67264, 67263, 67266, 67265, 67260, 67261, 67253, 67251, 50027, 67246, 67269, 67268, 67267, 9257, 67247, 39119, 39120, 39121, 39123, 39122, 39124],
            'conversionRate' => array_fill(0, 25, 25),
            'fee' => array_fill(0, 25, 0),
            'outputQty' => array_fill(0, 25, 1),
        ];

        $this->rareRiftEssence = [
            'id' => [
                101727, // Astral Fluc Mass
                73711, // Bag of Aurillum (10)
                74212, // Bag of Leyline Crystals (10)
                69985, // Bandit Crest
                101870, // Extra-Large Calcified Gasp
                101862, // Extra-Large Pinch of Stardust
                101797, // Extra-Large Static Charge
                66593, // Geode
                74249, // Large Bag of Airship Parts
                83878, // Pile of Elonian Trade Contracts
                94228, // Tyrian Defense Seal
                95692, // Writ of Dragon's End
                96561, // Writ of Echovald Wilds
                96533, // Writ of New Kaineng City
                96680, // Writ of Seitung Province
                92311, // Season 4 Currency Box
                86053, // Wood Shipment
                85725, // Trophy Shipment
                85873, // Cloth Shipment
                85990, // Metal Shipment
                86231, // Leather Shipment
            ],
            'conversionRate' => [
                25, 
                35,
                35,
                35, 
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                35,
                50,
                50,
                50,
                50,
                50,
                50,
            ],
            'fee' => array_merge(
                array_fill(0, 16, 0), 
                array_fill(16, 5, 10000), // Shipments
            ),
            'outputQty' => [
                1, 
                1,
                1,
                10,
                1,
                1,
                1,
                10,
                1,
                10,
                10,
                2,
                2,
                2,
                2,
                1,
                1,
                1,
                1,
                1,
                1,
            ],
        ];

        $this->pileOfBloodstoneDust = [
            'id' => $this->ascendedJunk['id'],
            'conversionRate' => $this->ascendedJunk['conversionRate'],
            'fee' => $this->ascendedJunk['fee'],
            'outputQty' => $this->ascendedJunk['outputQty'],
        ];

        // Trade Crates
        $this->tradeContract = [
            'id' => [84783, 83352, 84254, 83265, 82825, 82564, 83419, 83298, 83462, 82946, 82219, 83554, 83582, 84668, 82969],
            'conversionRate' => array_fill(0, 15, 50),
            'fee' => array_fill(0, 15, 0),
            'outputQty' => array_fill(0, 15, 1),
        ];

        $this->tyrianDefenseSeal = [
            'id' => [
                94265, // Ebon Vanguard Supply Box
                94318, // Crystal Bloom Supply Box
                94605, // Exalted Supply Box
                94741, // Tengu Supply Box
                94860, // Olmakhan Supply Box
                94710, // Skritt Supply Box
                94560, // Deldrimor Supply Box
            ],
            'conversionRate' => [
                15,
                15,
                20,
                25,
                25,
                25,
                20
            ],
            'fee' => array_fill(0, 7, 0),
            'outputQty' => array_fill(0, 7, 1),
        ];

        // Magic Warped Bundle
        // Magic Warped Bundle (Ember Bay)
        // Magic Warped Packet
        $this->unboundMagic = [
            'id' => [79186, 79186, 79114],
            'conversionRate' =>  [500,  1250, 250],
            'fee' => [10000, 4000, 5000],
            'outputQty' => array_fill(0, 3, 1),
        ];
        // Shipments
        $this->volatileMagic = [
            'id' => [85873, 86231, 85725, 86053, 85990],
            'conversionRate' => array_fill(0, 5, 250),
            'fee' => array_fill(0, 5, 10000),
            'outputQty' => array_fill(0, 5, 1),
        ];

        // Writs of [EOD City]
        $this->writs = [
            'id' => [
                97233, // Imperial Favor
                101727, // Astral Fluc Mass
            ],
            'conversionRate' => [1, 2],
            'fee' => [0, 0],
            'outputQty' => [5, 1],
        ];





        $this->homesteadWood = [
            'id' => [
                19723, // Green Wood Logs
                19726, // Soft Wood Logs
                19727, // Seasoned Wood Logs
                19724, // Hard Wood Logs
                19722, // Elder Wood Logs
                19725, // Ancient Wood Logs
            ],
            'conversionRate' => [
                5,
                3,
                1,
                1,
                1,
                1,
            ],
            'fee' => array_fill(0, 6, 0),
            'outputQty' => array_merge(
                array_fill(0, 5, 1), 
                array_fill(5, 1, 2)
            ),
        ];

        // MAP out every currency or exchangeable that could be used for calculations
        // References Controller initializations
        // USE this for functions that use any of these exchangeables to find their values thru their drop rates
        $this->exchangeableMap = [
            "Airship Part" => $this->airshipPart,
            "Bandit Crest" => $this->banditCrest,
            "Lump of Aurillium" => $this->leyEnergyMatter,
            "Ley Line Crystal" => $this->leyEnergyMatter,
            "Empyreal Fragment" => $this->empyrealFragment,
            "Dragonite Ore" => $this->dragoniteOre,
            "Fine Rift Essence" => $this->fineAndMasterworkRiftEssences,
            "Masterwork Rift Essence" => $this->fineAndMasterworkRiftEssences,
            "Geode" => $this->geode,
            "Imperial Favor" => $this->imperialFavor,
            "Jade Sliver" => $this->jadeSliver,
            "Laurel" => $this->laurel,
            "Pile of Bloodstone Dust" => $this->pileOfBloodstoneDust,
            "Rare Rift Essence" => $this->rareRiftEssence,
            "Trade Contract" => $this->tradeContract,
            "Tyrian Defense Seal" => $this->tyrianDefenseSeal,
            "Unbound Magic" => $this->unboundMagic,
            "Volatile Magic" => $this->volatileMagic,
            "Writ of Seitung Province" => $this->writs,
            "Writ of New Kaineng City" => $this->writs,
            "Writ of Echovald Wilds" => $this->writs,
            "Writ of Dragon's End" => $this->writs,
        ];
    }

    protected function duplicate_and_splice_bag($targetID, &$dropRates, $duplicatedName){
        foreach ($dropRates as $index => $targetBag){
            if ($targetBag[0]->bag_id == $targetID){
                $duplicatedBag = clone $targetBag; 
                $duplicatedBag->duplicated = true; 
                $duplicatedBag->duplicated_name = $duplicatedName; 

                array_splice($dropRates, $index + 1, 0, [$duplicatedBag]);
                return; 
            }
        }
    }

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
                    case 'Pile of Bloodstone Dust':
                    case 'Empyreal Fragment':
                        $value = $this->getExchangeableValue($item->name, $item->drop_rate, $includes, $sellOrderSetting, $tax);
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
    // *
    // * DRIZZLEWOOD COAST COMMENDATIONS
    // * EX: ASH LEGION COMMENDATION
    protected function getCommendationValue($commendationID, $commendationDropRate, $includes, $sellOrderSetting, $tax){
        $value = 0;
        return $value * $commendationDropRate;
    }
    // GET AND RETURN VALUE OF ANY EXCHANGEABLE OR CURRENCY VALUE
    // Ex: 
    // Dragonite Ore
    // Volatile Magic
    // Eyes of Kormir
    protected function getExchangeableValue($itemName, $itemDropRate, $includes, $sellOrderSetting, $tax){

        switch ($itemName){
            case 'Coin': 
                return 1 * $itemDropRate; 
        }
        
        $requestedBags = [];

        // Check if $request matches with one of the $map
        // Populate arrays
        if (isset($this->exchangeableMap[$itemName])){
            $data = $this->exchangeableMap[$itemName]; 
            $requestedBags = array_merge($requestedBags, $data['id']);
            $conversionRate = $data['conversionRate'];
            $fee = $data['fee'];
        }

        $containerTable = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
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

        //dd($containerTable, $requestedBags);

        //dd('container table: ', $containerTable);
        $orderedResults = [];
        // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
        // This is to match the conversionRates and fees
        foreach ($requestedBags as $id){
            if (isset($containerTable[$id])){
                $orderedResults[$id] = $containerTable[$id];
            }
        }

        $containerTable = array_values($orderedResults);

        $allValues = []; 

        foreach ($containerTable as $index => $group){
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
                // ASCENDED JUNK
                else if ($item->rarity == 'Ascended' && $item->type == 'CraftingMaterial' && in_array('AscendedJunk', $includes)) {
                    // There's a lot of ascended and crafteringMaterials so switch the $item->name to check for specifically the ascended junk
                    switch ($item->name){
                        case 'Dragonite Ore':
                        case 'Pile of Bloodstone Dust':
                        case 'Empyreal Fragment':
                            $value = $this->getExchangeableValue($item->name, $item->drop_rate, $includes, $sellOrderSetting, $tax);
                            break;
                    }
                }
                // Junk items
                else if ($item->rarity === 'Junk'){
                    $value += $item->vendor_value * $item->drop_rate;
                }
                // Everything else
                else {
                    //dd($item);
                    try {
                        $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                    } catch (\Exception $e){
                        dd($e, $item, $sellOrderSetting);
                    }
                    if ($item->$sellOrderSetting){
                        $value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                    } else {
                        $value += $item->vendor_value * $item->drop_rate;
                    }
                    //$value += ($item->$sellOrderSetting * $tax) * $item->drop_rate; 
                }

                
            }
            if ($item->item_name == 'Antique Summoning Stone'){
                //dd($item, $value, $fee[$index], $conversionRate[$index]);
            }
            $value = ($value - $fee[$index]) / $conversionRate[$index]; 
            array_push($allValues, $value); 
        }
            //dd($allValues);
            $currencyValue = max($allValues);
            //dd($currencyValue);
            //$currencyValue = (max($allValues) - $fee) / $conversionRate; 
        

        return $currencyValue * $itemDropRate; 

        
    }

    protected function getCurrencyValue($currencyID, $currencyDropRate, $includes, $sellOrderSetting, $tax){
        
        $containerIDs = [];

        switch ($currencyID){
            // GOLD
            case 1: 
                return 1 * $currencyDropRate;

            // Airship Parts
            case 19:
                if (!in_array('AirshipPart', $includes)){
                    return 0; 
                } else {
                    $containerIDs = array_merge($containerIDs, $this->leyEnergyMatter['id']);
                    $conversionRate = $this->leyEnergyMatter['conversionRate'];
                    $fee = $this->leyEnergyMatter['fee'];
                }
                break;

            // Ley Line Crystals
            case 20:
                if (!in_array('LeyLineCrystal', $includes)){
                    return 0; 
                } else {
                    $containerIDs = array_merge($containerIDs, $this->leyEnergyMatter['id']);
                    $conversionRate = $this->leyEnergyMatter['conversionRate'];
                    $fee = $this->leyEnergyMatter['fee'];
                }
                break;


            // Lump of Aurillium
            case 22:
                if (!in_array('LumpOfAurillium', $includes)){
                    return 0; 
                } else {
                    $containerIDs = array_merge($containerIDs, $this->leyEnergyMatter['id']);
                    $conversionRate = $this->leyEnergyMatter['conversionRate'];
                    $fee = $this->leyEnergyMatter['fee'];
                }
                break;

            // GEODE
            case 25: 
                $containerIDs = array_merge($containerIDs, $this->geode['id']);
                $conversionRate = $this->geode['conversionRate'];
                $fee = $this->geode['fee']; 
                break;

            // BANDIT CREST
            case 27:
                $containerIDs = array_merge($containerIDs, $this->banditCrest['id']);
                $conversionRate = $this->banditCrest['conversionRate'];
                $fee = $this->banditCrest['fee']; 
                break;

            //UNBOUND MAGIC
            case 32:
                if (!in_array('UnboundMagic', $includes)){
                    return 0; 
                } else {
                    $containerIDs = array_merge($containerIDs, $this->unboundMagic['id']);
                    $conversionRate = $this->unboundMagic['conversionRate']; 
                    $fee = $this->unboundMagic['fee'];
                    break;
                }
                

            // TRADE CONTRACTS
            case 34:
                if (!in_array('TradeContract', $includes)){
                    return 0;
                } else {
                    $containerIDs = array_merge($containerIDs, $this->tradeContract['id']);
                    $conversionRate = $this->tradeContract['conversionRate'];
                    $fee = $this->tradeContract['fee'];
                    break;
                }
               

            // VOLATILE MAGIC
            case 45:
                if (!in_array('VolatileMagic', $includes)){
                    return 0;
                } else {
                    $containerIDs = array_merge($containerIDs, $this->volatileMagic['id']);
                    $conversionRate = $this->volatileMagic['conversionRate']; 
                    $fee = $this->volatileMagic['fee'];
                    break;
                }
                

            // IMEPRIAL FAVORS
            case 68:
                if (!in_array('ImperialFavor', $includes)){
                    return 0; 
                } else {
                    $containerIDs = array_merge($containerIDs, $this->imperialFavor['id']);
                    $conversionRate = $this->imperialFavor['conversionRate']; 
                    $fee = $this->imperialFavor['fee'];
                    break;
                }
                

            // *
            // * COMMENDATIONS
            // *
            // ASH LEGION
            case 93525:
                //dd($currencyID);
                break;
            default: return; 
        }

        $containerTable = BagDropRate::join('bags', 'bag_drop_rates.bag_id', '=', 'bags.id')
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
        ->whereIn('bag_id', $containerIDs)
        ->get()
        ->groupBy('bag_id');

        //dd('container table: ', $containerTable);
        $orderedResults = [];
        // Since the query reorders the indexes based on smallest to largest IDs, reorder the index to match the original set
        // This is to match the conversionRates and fees
        foreach ($containerIDs as $id){
            if (isset($containerTable[$id])){
                $orderedResults[$id] = $containerTable[$id];
            }
        }

        $containerTable = array_values($orderedResults);

        $allValues = []; 

        foreach ($containerTable as $index => $group){
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
            if ($item->item_name == 'Antique Summoning Stone'){
                //dd($item, $value, $fee[$index], $conversionRate[$index]);
            }
            $value = ($value - $fee[$index]) / $conversionRate[$index]; 
            array_push($allValues, $value); 
        }
            //dd($allValues);
            $currencyValue = max($allValues);
            //dd($currencyValue);
            //$currencyValue = (max($allValues) - $fee) / $conversionRate; 
        

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
