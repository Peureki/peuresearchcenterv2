<?php

namespace App\Jobs\Fetches;

use App\Models\Items;
use App\Models\Recipes;
use App\Models\ResearchNotes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchResearchNotes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $salvageableItemCategories = [
            ["Draconic", 5.5],
            ["Tempered Scale", 6],
            ["Barbaric", 5.5],
            ["Splint", 5],
            ["Major Sigil", 1],
            ["Superior Sigil", 1],
            ["Nadijeh's", 275],
            ["Zehtuka's", 213],
            ["Wupwup", 275],
            ["Powerful Potion", 1],
            ["Potent Potion", 1],
            ["Strong Potion", 1],
            ["Minor Potion", 1],
            ["Soro's", 245],
            ["Grizzlemouth's", 245],
            ["Zintl", 240],
            ["Pearl", 45],
            ["Bottle of Batwing Brew", 1],
            ["Tuning Crystal", 1],
            ["Green Wood Scepter", 1],
            ["Irradiated Focus", 1],
            ["Harpy Totem", 1],
            ["Togo's", 240],
            ["Tengu Echo", 50],
            ["Astral", 50],
            ["Peppermint Oil", 1.03],
            ["Restored Boreal", 40],
            ["Mordant", 45],
            ["Elder Wood Warhorn", 5.83],
            ["Quality Maintenance Oil", 1.1],
            ["Hard Wood Warhorn", 6],
            ["Artisan Maintenance Oil", 1],
            ["Seasoned Wood Warhorn", 5],
            ["Soft Wood Short Bow", 3.14],
            ["Journeyman Maintenance Oil", 1.04],
            ["Bronze Rifle", 1],
            ["Orichalcum Earring", 83.33],
            ["Mithril Earring", 5],
            ["Mithril Amulet", 4],
            ["Mithril Ring", 5],
            ["Platinum Amulet", 3],
            ["Platinum Earring", 4],
            ["Platinum Ring", 4],
            ["Gold Band", 5],
            ["Gold Earring", 3.29],
            ["Gold Amulet", 3],
            ["Gold Ring", 3],
            ["Silver Earring", 2.17],
            ["Silver Ring", 3],
            ["Silver Pendant", 3],
            ["Silver Stud", 2.22],
            ["Copper Stud", 1],
            ["Copper Earring", 1],
            ["Copper Amulet", 1],
            ["Copper Ring", 1],
            ["The Twins'", 467],
            ["Togo's", 450],
            ["Ferratus's", 475],
            ["Emblazoned", 75],
            ["Lunatic Noble", 75],
            ["Prowler", 5],
            ["Noble", 5.36],
            ["Outlaw Mask", 3.2],
            ["Outlaw Shoulders", 3.2],
            ["Outlaw Coat", 3.2],
            ["Outlaw Gloves", 3.2],
            ["Outlaw Pants", 3.2],
            ["Outlaw Boots", 3.2],
            ["Seeker Shoulders", 1],
            ["Seeker Coat", 1],
            ["Seeker Gloves", 1],
            ["Seeker Pants", 1],
            ["Seeker Boots", 1],
            ["Jade Tech Masque", 75],
            ["Jade Tech Shoulderpads", 75],
            ["Jade Tech Vest", 75],
            ["Jade Tech Gloves", 75],
            ["Jade Tech Skirt", 75],
            ["Jade Tech Boots", 75],
            ["Exalted Masque", 75],
            ["Exalted Mantle", 75],
            ["Exalted Coat", 75],
            ["Exalted Gloves", 75],
            ["Exalted Pants", 75],
            ["Exalted Boots", 75],
            ["Stellar", 245],
            ["Zojja's", 345],
            ["Mathilde's", 250],
            ["Sharpening Skull", 1.12],
            ["Krait Slayer", 6],
            ["Krait Pilum", 5.12],
            ["Darksteel Dagger", 6.14],
            ["Darksteel Axe", 6.26],
            ["Beaded", 7],
            ["Dredge Spear", 4.98],
            ["Bronze Axe", 1],
            ["Bronze Sword", 1],
            ["Bronze Mace", 1],
            ["Bronze Spear", 1],
            // ["Adventurer's Mantle", 6],
            // // ["Ahamid's", 275],
            // ["Amnemoi's Robe", 6],
            // CHEF
            ["Tuning Icicle", 1.08],
            ["Lump of Crystallized Nougat", 1],
            ["Bowl of", 1.3],
            ["Cup of", 1.3],
            ["Saffron Stuffed Mushroom", 1.27],
            ["Flatbread", 1.38],
            ["Loaf of", 1.3],
            ["Chocolate Raspberry Cream", 1.13],
            ["Roasted Parsnip", 1.05],
            ["Spicier Flank Steak", 1.1],
            ["Griffon Egg Omelet", 1],
            ["Roasted Rutabaga", 1],
            ["Plate of", 1],
            ["Sushi", 1.37],
            ["Eztlitl Stuffed Mushroom", 1],
            ["Filet of", 1],
            ["Piece of Candy Corn Almond Brittle", 1],
            ["Grape Pie", 1],
            ["Stuffed Zucchini", 1],
            ["Cherry Pie", 1],
            ["Triktiki Omelet", 1],
            ["Yam Fritter", 1],
            ["Spinach Burger", 1],
            ["Zephyrite Fish Jerky", 1],
            ["Feathered", 5.5],
            ["Block of Tofu", 1.1],
        ];

        $restrictedItems = [
            "Recipe:",
            "Bowl of Red Meat Stock",
            "Bowl of Salsa",
            "Bowl of Vegetable Stock",
            "Cup of Potato Fries",
            "Hamburger",
            "Cheeseburger",
            "Dragon's Breath Bun",
            "Dragonfish Candy",
            "Dragonfly Cupcake",
            "Koi Cake",
            "Kralkachocolate Bar",
            "Fried Golden Dumpling",
            "Steamed Red Dumpling",
            "Spring Roll",
            "Sweet Bean Bun",
            "Bowl of Carne Khan Chili",
            "Bowl of Firebreather Chili",
            "Bowl of Green Chili Ice Cream",
            "Cup of Light-Roasted Coffee",
            "Omnomberry Compote",
            "Plate of Beef Rendang",
            "Bowl of Poultry Satay",
            "Quiche of Darkness Vegetable Mix",
            "Side of Charred Meat",
            "Trickster's Cream Pie",
            "Avocado Smoothie",
            "Loaf of Raspberry Peach Bread",
            "Loaf of Tarragon Bread",
            "Raspberry Peach Compote",
            "Raspberry Passion Fruit Compote",
            "Loaf of Rosemary Bread",
            "Longevity Noodles",
            "Unidentified Purple Dye",
            "White Cake",
            "Bowl of Strawberry Apple Compote",
            "Fried Banana Chips",
            "Ball of Cookie Dough",
            "Bowl of Blueberry Pie Filling",
            "Bowl of Candy Corn Custard",
            "Bowl of Chocolate Chip Ice Cream",
            "Bowl of Simple Poultry Soup",
            "Bowl ofSimple Stirfry",
            "Bowl of Staple Soup Vegetables",
            "Candied Apple",
            "Caramel Apple",
            "Chili Pepper Popper",
            "Drottot's Poached Egg",
            "Loaf of Bread",
            "Pasta Noodles",
            "Roasted Meaty Sandwich",
            "Spicy Meat Kabob",
            "Bowl of Sage Stuffing",
            "Bowl of Blackberry Pie Filling",
            "Bowl of Tangy Sautee Mix",
            "Bowl of Strawberry Pie Filling",
            "Bowl of Chocolate Raspberry Frosting",
            "Bowl of Winter Vegetable Mix",
            "Bowl of Pesto",
            "Bowl of Chocolate Cherry Frosting",
            "Bowl of Mango Pie Filling",
            "Bowl of Cherry Pie Filling",
            "Bowl of Orange Coconut Frosting",
            "Bowl of Chocolate Omnomberry Frosting",
            "Bowl of Grape Pie Filling",
            "Bowl of Simple Salad",
            "Bowl of Dolyak Stew",
            "Bowl of Simple Vegetable Soup",
            "Bowl of Green Bean Stew",
            "Bowl of Blueberry apple Compote",
            "Bowl of Simple Meat Chili",
            "Bowl of Sauteed Carrots",
            "Bowl of Simple Meat Stew",
            "Bowl of Poultry Noodle Soup",
            "Bowl of Simple Stirfry",
            "Bowl of Basic Vegetable Soup",
            "Bowl of Baker's Dry Ingredients",
            "Bowl of White Frosting",
            "Bowl of Omnomberry Pie Filling",
            "Bowl of Watery Mushroom Soup",
            "Bowl of Chocolate Frosting",
            "Bowl of Eztlitl Stuffing",
            "Bowl of Gelatinous Ooze Custard",
            "Bowl of Stirfry Base",
            "Bowl of Blackberry Pear Compote",
            "Bowl of Basic Poultry Soup",
            "Feast of Yam Fritters",
        ];

        $salvageableItemNames = array_column($salvageableItemCategories, 0); 
        $salvageableMap = array_column($salvageableItemCategories, 1, 0);
        $researchNotesResponse = [];

        Items::where(function ($goodItemQuery) use ($salvageableItemNames){
            foreach ($salvageableItemNames as $name){
                $goodItemQuery->orWhere('name', 'like', '%'.$name.'%');
            }
        })
        ->where('level', '!=', 0)
        ->where('vendor_value', '!=', 0)
        ->where('type', '!=', 'CraftingMaterial')
        ->where(function ($badItemQuery) use ($restrictedItems){
            foreach ($restrictedItems as $restricted){
                $badItemQuery->where('name', 'not like', $restricted);
            }
        })
        ->chunk(100, function ($salvageableItems) use ($salvageableMap){
            foreach ($salvageableItems as $item){
                $recipe = Recipes::where('output_item_id', $item->id)->first();

                // Check if recipe is !null
                if ($recipe) {
                    // Reset avgOutput
                    $avgOutput = null; 
                    // Go through salvageableMap with the categories and their avgOutput
                    foreach ($salvageableMap as $category => $value){
                        // If the item name string matches one of the words in the $category
                        // Or if item name matches the $category exactly
                        if (strpos($item->name, $category) != false || $item->name == $category){
                            $avgOutput = $value; 
                            break;
                        }
                    }
                    if ($avgOutput){
                        ResearchNotes::updateOrCreate(
                            [
                                'recipe_id' => $recipe->id,
                                'item_id' => $item->id,
                            ],
                            [
                                'avg_output' => $avgOutput, // Use avg_output from map
                                'ingredients' => $recipe->ingredients,
                            ]  
                        );
                    }
                    
                }
            }
        });
    }
}
