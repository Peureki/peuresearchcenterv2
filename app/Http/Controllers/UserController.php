<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function enterAPIKey(Request $request){
        $user = auth()->user();
        $user->update(['api_key' => $request->apiKey]);
    }

    public function saveChecklist(Request $request){
        $request->validate([
            'checklist' => 'required|array',
        ]);

        $user = auth()->user(); 
        
        if ($user){
            $user->update(['checklist' => $request->checklist]);
            // $user->checklist = json_encode($request->checklist);
            // $user->save();
        }
    }

    public function getChecklist(Request $request){
        $user = auth()->user(); 

        if ($user){
            $checklist = $user->checklist; 
            return response()->json($checklist);
        }
    }
}
