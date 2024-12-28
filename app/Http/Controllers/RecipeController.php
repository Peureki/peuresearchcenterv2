<?php

namespace App\Http\Controllers;

use App\Models\Currencies;
use App\Models\Items;
use App\Models\OtherRecipe;
use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    
    // *
    // * GET SEARCH REQUESTS
    // *
    // * When users type in a search bar, it sends a request to find recipes that contain the name/keywords 
    // * Returns => array of search results
    public function searchRecipes(Request $request){
        $query = $request->input('request');
        
        $recipes = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('items.name', 'like', '%'.$query.'%')
            ->select('recipes.id', 'items.name', 'icon', 'items.id as item_id', 'rarity')
            ->get()
            ->map(function ($recipe){
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'icon' => $recipe->icon,
                    'item_id' => $recipe->item_id,
                    'rarity' => $recipe->rarity,
                ];
            });

        $otherRecipes = OtherRecipe::join('items', 'other_recipes.output_item_id', '=', 'items.id')
            ->where('items.name', 'like', '%'.$query.'%')
            ->select('other_recipes.id', 'items.name', 'icon', 'items.id as item_id', 'rarity')
            ->get()
            ->map(function ($recipe){
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'icon' => $recipe->icon,
                    'item_id' => $recipe->item_id,
                    'rarity' => $recipe->rarity,
                ];
            });

        $mergedRecipes = $recipes->concat($otherRecipes);

        return response()->json($mergedRecipes);
    }

    // * 
    // * GET RECIPE TREE
    // * return a recipe tree
    public function getRecipeTree($id, $quantity, $skipOthersRecipe = false){
        // First check if ID is in Recipes
        $recipes = Recipes::where('output_item_id', $id)
        ->join('items', 'recipes.output_item_id', '=', 'items.id')
        ->get(); 

        // If cannot find recipe in Recipe db, check others
        if ($recipes->isEmpty()){
            $recipes = OtherRecipe::where('output_item_id', $id)
            ->join('items', 'other_recipes.output_item_id', '=', 'items.id')
            ->get(); 
        }

        // Return array
        $tree = []; 
        // Sometimes $recipes return more than 1 item
        foreach ($recipes as $recipe){
            // Check if the output item exist in Items
            $itemsIDExists = Items::where('id', $recipe['output_item_id'])->exists(); 

            if ($itemsIDExists){
                // Temp array to later plug into $tree
                $recipeTree = [];
                // Change main output depending on $quantity request

                // Makes sure that when a recipe has an output that's > 1, that the ingredients stay consistant to the recipe. Otherwise it would incorrectly multiply the ingredients 
                // ie Gossamer Patch 
                if ($recipe['output_item_count'] > 1){
                    $recipeTree = $this->createRecipeTree($recipe, 1 * $quantity, $skipOthersRecipe);
                } else {
                    $recipeTree = $this->createRecipeTree($recipe, $recipe['output_item_count'] * $quantity, $skipOthersRecipe);
                }

                $recipe['ingredients'] = $recipeTree;
                $tree[] = $recipe; 
            }
            //dd($recipeTree);
        }
        //dd($tree);

        return response()->json($tree);
    }
    // *
    // * ADD PRECURSOR TO RECIPE TREES
    // * These are checks if the user is requesting a list of legendaris that require more than 1 precursors. ie gen 2 legendaries
    private function addPrecursorsToTree($id, &$newRecipe){
        switch ($id){
            // LEGENDARY: ASTRALARIA
            // THE MECHANISM
            case 71426:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 75974,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // THE APPARATUS
            case 75974:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 70989,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: CLAW OF THE KHAN-UR
            // CLAW OF RESOLUTION
            case 87037:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 86968,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // CLAW OF RETRIBUTION
            case 86968:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 87093,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: EUREKA
            // ENDEAVOR
            case 79570:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 79537,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // FOR SCIENCE
            case 79537:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 79588,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: H.O.P.E
            // PROTOTYPE
            case 76399:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 70743,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // DEVELOPMENT
            case 70743:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 70960,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: XIUQUATL
            // TLEHCO
            case 88851:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 88885,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // ANIMA
            case 88885:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 88729,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: THE SHINING BLADE
            // SAVE THE QUEEN
            case 81812:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 81855,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // VENGENANCE
            case 81855:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 81645,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: THE BINDING OF IPOS
            // ARS GOETIA
            case 86097:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 86188,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // THE TRUE NAME
            case 86188:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 86064,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: SHOOSHADOO
            // FRIENDSHIP
            case 79836:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 79894,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // LOYALTY
            case 79894:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 79900,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: VERDARACH
            // CALL OF THE VOID
            case 87764:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 87930,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // LAMENT
            case 87930:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 87864,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: EXORDIUM
            // EXITARE
            case 90883:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 90780,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // LAMENT
            case 90780:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 90530,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: SHARUR
            // MIGHT OF ARAH
            case 81634:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 81754,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // RECLAMATION
            case 81754:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 81650,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: PHARUS
            // SPERO
            case 89886:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 89481,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // DOCTRINA
            case 89481:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 89891,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: THE HMS DIVINITY
            // MAN O' WAR
            case 80135:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 80377,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // FRIGATE
            case 80377:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 80524,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: CHUKA AND CHAMPAWAT
            // TIGRIS
            case 78425:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 78524,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // AMBUSH
            case 78524:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 78330,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;

            // LEGENDARY: NEVERMORE
            // THE RAVEN STAFF
            case 74068:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 76582,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
            // RAVENSWOOD STAFF
            case 76582:
                $newRecipeIngredients = $newRecipe->ingredients; 
                $newRecipeIngredients[] = [
                    "type" => "Item",
                    "id" => 75467,
                    "count" => 1,
                ];
                $newRecipe->ingredients = $newRecipeIngredients; 
                break;
        }
    }
    // * 
    // * CREATE A RECIPE TREE
    // * return newly created tree
    private function createRecipeTree($recipe, $parentCount, $skipOthersRecipe = false){
        // Restrict these Mystic Forge (MF) recipes because it would create an infinite loop
        // ie Mithril Ore, Obsidian Shards, etc
        $restrictedMFIDs = [19698,19702,19702,19700,19701,19726,19727,19724,19722,19725,19739,19741,19743,19748,19745,19728,19730,19731,19729,19732,19683,19687,19688,19682,19686,19684,19684,19685,19713,19714,19711,19709,19712,19740,19742,19744,19747,19746,19733,19734,19736,19735,19737,24343,24344,24345,24341,24358,24347,24348,24349,24350,24351,24273,24274,24275,24276,24277,24353,24354,24355,24356,24357,24285,24286,24287,24288,24289,24297,24298,24363,24299,24300,24279,24280,24281,24282,24283,24291,24292,24293,24294,24295,19925,46731,68063, 38024, 38023, 38014];
        //dd($recipe, $recipe['ingredients']);

        // Return array
        $newRecipeTree = []; 

        // Go through each ingredient to check what type it is
        // => insert 'name', 'icon' properties via respective databases
        foreach($recipe['ingredients'] as $index => $ingredient){
            // Set ingredients to $newRecipeTree
            $newRecipeTree[$index] = $ingredient;
            $newRecipeTree[$index]['count'] *= $parentCount; 

            if ($ingredient['type'] == 'Item'){     
                $newRecipeTree[$index]['name'] = Items::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Items::where('id', $ingredient['id'])->first()['icon'];
            } 
            if ($ingredient['type'] == 'Currency'){
                $newRecipeTree[$index]['name'] = Currencies::where('id', $ingredient['id'])->first()['name'];
                $newRecipeTree[$index]['icon'] = Currencies::where('id', $ingredient['id'])->first()['icon'];
            }
            
            
            // Check if recipe of ingredient exists
            // If yes => then there's another branch for the tree
            $newRecipe = Recipes::where('output_item_id', $ingredient['id'])->first();

            // Checks if there's additional precursors to be added to the ingredient list
            // ie Gen 2 legendaries with more than 1 precursor to craft
            $this->addPrecursorsToTree($ingredient['id'], $newRecipe);

            // OTHERWISE IF NOT IN RECIPES => check Others
            // Check if skip or not
            if (!$newRecipe && !$skipOthersRecipe && !in_array($ingredient['id'], $restrictedMFIDs)){
                $newRecipe = OtherRecipe::where('output_item_id', $ingredient['id'])->first();
            }
            //dd($newRecipe, $newRecipe['ingredients'], $ingredient);

            // If a new subrecipe has been found, repeat process until it's not possible anymore
            // Set new sub ['ingredients'] array
            if ($newRecipe){
                if ($newRecipe['output_item_count'] > 1){
                    $newRecipeTree[$index]['ingredients'] = $this->createRecipeTree($newRecipe, $ingredient['count'] / $newRecipe['output_item_count'], $skipOthersRecipe); 
                } else {
                    $newRecipeTree[$index]['ingredients'] = $this->createRecipeTree($newRecipe, $ingredient['count'] * $parentCount, $skipOthersRecipe);

                    
                }
            } 
            
                  
        }
        return $newRecipeTree;
    }

    // *
    // * GET RECIPE FAVORITES AND THEIR VALUES
    // *
    public function favoriteRecipes($buyOrderSetting, $recipes){
        $recipes = json_decode($recipes);

        //dd($recipes);

        $results = [];

        foreach ($recipes as $recipe){
            $outputItemID = $recipe[0];
            $recipeID = $recipe[1];

            $recipeDB = Recipes::join('items', 'recipes.output_item_id', 'items.id')
            ->where('recipes.output_item_id', $outputItemID)
            ->where('recipes.id', $recipeID)
            ->select(
                'recipes.*',
                'recipes.id as id',
                'recipes.output_item_id as output_item_id',
                'items.name as name',
            )
            ->first(); 

            if ($recipeDB){
                $results[] = $recipeDB; 
            } else {
                $otherRecipeDB = OtherRecipe::join('items', 'other_recipes.output_item_id', 'items.id')
                ->where('other_recipes.output_item_id', $outputItemID)
                ->where('other_recipes.id', $recipeID)
                ->select(
                    'other_recipes.*',
                    'other_recipes.id as id',
                    'other_recipes.output_item_id as output_item_id',
                    'items.name as name',
                )
                ->first();
                
                if ($otherRecipeDB){
                    $results[] = $otherRecipeDB;
                }
            }
        }

        //dd($response);

        

        // 1) Check if $recipes[0] is 

        

        

        // $recipeDB = Recipes::join('items', 'recipes.output_item_id', 'items.id')
        // ->select(
        //     'items.id as output_item_id',
        //     'items.name as name',
        //     'recipes.id as id',
        // )
        // ->whereIn('recipes.id', $recipes)
        // ->get(); 

        // foreach ($merp as $recipe){
        //     dd($recipe);
        // }

        // dd($merp);

        // dd($recipeDB);

        //$response = [];
        
        foreach ($results as $recipe){
            $recipeValue = $this->getRecipeValues($recipe->name, $recipe->output_item_id, $recipe->id,  1, false, $buyOrderSetting);

            //dd($merp->getData());

            $response[] = $recipeValue->getData();
        }

        //dd($response);
        return response()->json($response);
    }

    // * CALLED AS A REQUEST FROM THE USER VIA RECIPE FORMS
    // * OR FETCHRECIPEVALUES FOR RESEARCH NOTES
    // * Request = Name of the recipe => return recipe tree array
    public function getRecipeValues($request, $itemId, $recipeId, $quantity, $skipOthersRecipe = false, $buyOrderSetting = null){
        // Decode the $request 
        // When users type in a request, it comes out as Sigil20%of20%Blood or something 
        $requestName = urldecode($request);
        
        // Combine the Recipes db and the Items db to get more info
        $recipe = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->select(
                'recipes.*',
                'items.buy_price',
                'items.sell_price',
                'items.name',
                'items.icon',
                'items.rarity',
            )
            ->where('items.name', $requestName)
            ->where('items.id', $itemId)
            ->where('recipes.id', $recipeId)
            ->first();

        if (!$recipe){
            $recipe = OtherRecipe::join('items', 'other_recipes.output_item_id', '=', 'items.id')
            ->select(
                'other_recipes.*',
                'items.buy_price',
                'items.sell_price',
                'items.name',
                'items.icon',
                'items.rarity',
            )
            ->where('items.name', $requestName)
            ->where('items.id', $itemId)
            ->where('other_recipes.id', $recipeId)
            ->first();
        }

        //dd($recipe);

        //dd($recipe->name, $recipe['ingredients']);
        //dd($recipe['ingredients']);

        //dd($recipe['ingredients']);

        // To be returned
        // Start with index of 0 so that the output item is the first of the recipe tree displayed
        $returnArray = [
            "id" => $recipe['id'],
            'output_item_id' => $recipe['output_item_id'],
            "name" => $recipe['name'],
            "buy_price" => $recipe['buy_price'] * $recipe['output_item_count'] * $quantity,
            "sell_price" => $recipe['sell_price'] * $recipe['output_item_count'] * $quantity,
            "count" => $recipe['output_item_count'] * $quantity,
            "icon" => $recipe['icon'],
            "type" => $recipe['type'],
            "rarity" => $recipe['rarity'],
            "craftingValue" => 0,
            "preference" => 'TP',
            "recipe_materials" => null,
        ];

        //dd($returnArray);

        $returnArray['ingredients'] = $this->createRecipeTree($recipe, $quantity, $skipOthersRecipe);

        //dd($returnArray);

        $returnArray['ingredients'] = $this->addRecipeTreePrices($returnArray, $quantity);
        
        // GET UNIQUE ITEM IDS FROM RECIPE TREE
        $returnArray['recipe_materials'] = $this->getUniqueItemIds($returnArray);

        //dd($returnArray);
        
        if ($buyOrderSetting){
            $returnArray['craftingValue'] = $this->calculateCraftingValue($returnArray, $buyOrderSetting); 
            
        } else {
            $returnArray['craftingValue'] = $this->calculateCraftingValue($returnArray); 
        }

        //dd($returnArray['craftingValue'], $buyOrderSetting);
        
        //$returnArray['preference'] = $this->preferences($returnArray);
        
        if ($returnArray['craftingValue'] < $returnArray['buy_price'] && $returnArray['craftingValue'] < $returnArray['sell_price']){
            $returnArray['preference'] = 'Crafting';
        }
        if ($returnArray['buy_price'] == null && $returnArray['sell_price'] == null){
            $returnArray['preference'] = 'Crafting';
        }
        //dd($returnArray);
        
        return response()->json($returnArray);
    }
    // First ingredients of recipe
    private function addRecipeTreePrices($recipe, $quantity){

        foreach ($recipe['ingredients'] as &$ingredient){
            //dd($ingredient, $returnArray, $quantity);
            // Get ingredient info from the Items db
            $itemInfo = Items::where('id', $ingredient['id'])->first();
            //dd($itemInfo);
            //$returnArray = $ingredient;
            $ingredient['count'] *= $quantity; 
            $ingredient['buy_price'] = $itemInfo['buy_price'] * $ingredient['count'] * $quantity;
            $ingredient['sell_price'] = $itemInfo['sell_price'] * $ingredient['count'] * $quantity;
            //dd($ingredient);

            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['ingredients'] = $this->addRecipeTreePrices($ingredient, $quantity); 
            }
        }
        
        return $recipe['ingredients']; 
    }

    private function calculateCraftingValue(&$recipe, $buyOrderSetting = null){
        //dd($recipe);

        $value = 0;

        foreach ($recipe['ingredients'] as &$ingredient){
            $prevoiusCraftingValue = 0;
            //dd($ingredient);
            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['craftingValue'] = $this->calculateCraftingValue($ingredient, $buyOrderSetting); 
            } 
            if (array_key_exists('craftingValue', $ingredient)){
                $prevoiusCraftingValue = $ingredient['craftingValue'];
            } else {
                // If $buyOrderSetting exist, follow what the requested buy_order 
                if ($buyOrderSetting){
                    $prevoiusCraftingValue = $ingredient[$buyOrderSetting];
                } 
                // Otherwise get the best option
                else {
                    $prevoiusCraftingValue = min(
                        $ingredient['buy_price'],
                        $ingredient['sell_price']
                    );
                }
                
            }
            $value += $prevoiusCraftingValue;
            
        }
        //dd($value);
        return $value;
    }

    private function getUniqueItemIds($recipe, &$uniqueIds = []) {
        // Add the current item's ID to the unique IDs array
        if (isset($recipe['id'])) {
            $uniqueIds[$recipe['id']] = true;
        }
    
        // If the recipe has ingredients, recursively check them
        if (isset($recipe['ingredients']) && is_array($recipe['ingredients'])) {
            foreach ($recipe['ingredients'] as $ingredient) {
                $this->getUniqueItemIds($ingredient, $uniqueIds);
            }
        }
    
        return array_keys($uniqueIds);
    }

    private function preferences(&$recipe){
        //dd($recipe);

        $preference = 'TP';

        foreach ($recipe['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                $ingredient['preference'] = $this->preferences($ingredient);
            }

            if (array_key_exists('craftingValue', $ingredient)){
                if ($ingredient['craftingValue'] < $ingredient['buy_price'] && $ingredient['craftingValue'] < $ingredient['sell_price']) {
                    $preference = 'Crafting';
                } else {
                    $preference = 'TP';
                }
            } else {
                $preference = 'TP';
            }
        }

        return $preference; 
    }


    public function calculateCraftingValueMERP(&$returnArray){
        $tempValue = 0; 

        foreach ($returnArray['ingredients'] as &$ingredient){
            if (array_key_exists('ingredients', $ingredient)){
                $tempValue += $this->calculateCraftingValue($ingredient);
                $this->preferences($ingredient);
            } 
            else {
                if ($ingredient['buy_price'] < $ingredient['sell_price'] && $ingredient['buy_price'] != 0){
                    $tempValue += $ingredient['buy_price'];
                } 
                else if ($ingredient['buy_price'] > $ingredient['sell_price'] || ($ingredient['buy_price'] == 0 && $ingredient['sell_price'] != 0)) {
                    $tempValue += $ingredient['sell_price'];
                } 
                else {
                    $tempValue += 0;
                }
            }
        }
        return $returnArray['craftingValue'] = $tempValue;
    }
    
}
