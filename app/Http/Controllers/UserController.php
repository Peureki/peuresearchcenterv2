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

    public function saveIncludes(Request $request){
        $request->validate([
            'includes' => 'required|array',
        ]);

        $user = auth()->user(); 
        if ($user){
            $user->update(['includes' => $request->includes]);
        }
    }

    public function getIncludes(Request $request){
        $user = auth()->user(); 

        if ($user){
            $includes = $user->includes; 
            return response()->json($includes);
        }
    }

    public function saveSettings(Request $request){
        $user = auth()->user(); 

        if ($user){
            $user->update([
                'settings_buy_order' => $request->settings_buy_order,
                'settings_sell_order' => $request->settings_sell_order,
                'settings_tax' => $request->settings_tax, 
                'includes' => $request->includes,
            ]);
        }
    }

    public function saveFilterResearchNotes(Request $request){
        $user = auth()->user(); 

        if ($user){
            $user->update(['filter_research_notes' => $request->filter_research_notes]);
        }
    }

    public function saveFavorites(Request $request){
        $user = auth()->user(); 

        if ($user){
            $user->update(['favorites' => $request->favorites]);
        }
    }
}
