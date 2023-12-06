<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function getRecipeValues($request, $buyOrderSetting, $sellOrderSetting, $tax){
        $requestName = urldecode($request);

        $returnArray = []; 

        $recipe = Recipes::join('items', 'recipes.output_item_id', '=', 'items.id')
            ->where('items.name', $requestName)
            ->first(); 

        

        
        dd($recipe['ingredients']);
        
        return response()->json($recipe);
    }
}
