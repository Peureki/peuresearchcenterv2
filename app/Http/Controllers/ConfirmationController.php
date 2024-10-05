<?php

namespace App\Http\Controllers;

use App\Models\Confirmation;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function confirmItem(Request $request){
        $request->validate([
            'item_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'type' => 'nullable|string'
        ]);

        $user = auth()->user(); 

        Confirmation::create([
            'item_id' => $request->itemID,
            'user_id' => $user->id ?? null, 
            'type' => $request->type, 
        ]);
    }
}
