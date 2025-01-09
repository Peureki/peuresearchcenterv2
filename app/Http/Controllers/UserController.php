<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function enterAPIKey(Request $request){
        $user = auth()->user();
        $user->update(['api_key' => $request->apiKey]);
    }

    public function saveChecklist(Request $request){
        $request->validate([
            'checklist' => 'nullable|array',
        ]);

        $user = auth()->user(); 
        
        if ($user){
            // If checklist is null, input an empty array
            $user->update(['checklist' => $request->checklist ?? []]);
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

    public function saveFilters(Request $request){
        $request->validate([
            'filters' => 'nullable|array',
        ]);

        $user = auth()->user(); 
        
        if ($user){
            // If checklist is null, input an empty array
            $user->update(['filters' => $request->filters ?? []]);
        }
    }

    public function getFilters(Request $request){
        $user = auth()->user(); 

        if ($user){
            $filters = $user->filters; 
            return response()->json($filters);
        }
    }

    public function saveTheme(Request $request){
        $request->validate([
            'theme' => 'nullable|string'
        ]);

        $user = auth()->user(); 

        if ($user){
            $user->update(['theme' => $request->theme]); 
        }
    }

    public function apiSubmission(Request $request){
        $request->validate([
            'apiKey' => 'nullable|string'
        ]);

        $user = auth()->user(); 

        if ($user){
            $gw2API = Http::get('https://api.guildwars2.com/v2/account/achievements?access_token='.$request->apiKey);

            $user->update([
                'achievements' => $gw2API->json(),
                'api_key' => Crypt::encryptString($request->apiKey),
            ]);

            
        }
    }
}
