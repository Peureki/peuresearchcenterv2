<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Fish;
use App\Models\Items;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    // *
    // * GET FISHING ACHIEVEMENTS
    // * 
    // * Requires user AUTH
    // * 
    // * Goal
    // * Return all fishing achievements and use user's api key to determine what fishes are missing 
    // * 
    public function getFishing(){

        $user = auth()->user(); 

        // Overall array to return with all the info
        $response = [];
        // Store all item IDs such as fish IDs and rewards to fetch the Items database then populate the $achievementsDB[bits]
        $itemIDs = [];
        $achievementIDs = [
            // Avid Ascalonian Fisher
            6484, 
            // Avid Desert Fisher
            6509,
            // Avid Desert Isles Fisher
            6250,
            // Avid Dragon's End Fisher
            6402,
            // Avid Echovald Wilds Fisher
            6466,
            // Avid Horn of Maguuma Fisher
            7804,
            // Avid Janthir Fisher
            8246,
            // Avid Kaineng Fisher
            6192,
            // Avid Krytan Fisher
            6263,
            // Avid Maguuma Fisher
            6475,
            // Avid Orrian Fisher
            6227,
            // Avid Ring of Fire Fisher
            6339,
            // Avid Saltwater Fisher
            6393,
            // Avid Seitung Province Fisher
            6264,
            // Avid Shiverpeaks Fisher
            6153,
            // Avid World Class Fisher
            6110,
        ];

        $achievementsDB = Achievement::whereIn('id', $achievementIDs)->get(); 

        // 1) Loop through all the achievements
        // 2) Loop through each achievement->bits
        // 3) For each bit, get that fish info and replace existing ->bits info
        foreach ($achievementsDB as &$achievement){
            $bits = $achievement->bits;
            foreach ($bits as &$fish){
                $fish = Fish::join('items', 'fishes.id', 'items.id')
                ->leftjoin('items as bait_items', 'fishes.bait_id', 'bait_items.id')
                ->select(
                    'fishes.*', 
                    'items.*',
                    'bait_items.name as bait_name',
                    'bait_items.icon as bait_icon'
                )
                ->where('fishes.id', $fish['id'])
                
                ->first(); 

                //dd($fish);
            }
            $achievement->bits = $bits; 
        }
        if ($user){
            // 1) Get user achievements
            // 2) Filter the achievements by matching $achievementIDs and get an array of fish that have been completed currently in that achievement
            // Ex: return array: [2, 3, 5, 6]
            // 3) populate $response with the newly populated $achievementsDB and $userAchievements then RETURN
            $userAchievements = array_values(array_filter($user->achievements, function($achievement) use ($achievementIDs){
                return in_array($achievement['id'], $achievementIDs);
            }));

            $response = [
                'fishIDs' => $itemIDs,
                'achievements' => $achievementsDB,
                'userAchievements' => $userAchievements,
            ];

            return response()->json($response);
        } else {
            return;
        }


    }
}
