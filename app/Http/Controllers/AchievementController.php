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
        $achievementIDs = [
            // Aquatic Trash Collector
            6439,
            // Aquatic Treasure Collector
            6505,
            // Ascalonian Fisher
            6330,
            // Desert Fisher
            6317,
            // Desert Isles
            6106,
            // Dragon's End Fisher
            6506,
            // Echovald Wilds Fisher
            6258,
            // Horn of Maguuma Fisher
            7114,
            // Janthir Fisher
            8168, 
            // Kaineng Fisher
            6342, 
            // Krytan Fisher
            6068, 
            // Maguuma Fisher
            6344, 
            // Orrian Fisher
            6363, 
            // Ring of Fire Fisher
            6489, 
            // Saltwater Fisher
            6471, 
            // Seitung Province Fisher
            6336, 
            // Shiverpeaks Fisher
            6179, 
            // World Class Fisher
            6224,
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
                // Make sure to only return matching user achievement IDS && if the achivement is not complete yet
                // But, if the achievement is considered 'done', but can be repeated, show that
                return in_array($achievement['id'], $achievementIDs) && (!($achievement['done'] && !array_key_exists('repeated', $achievement)));
            }));

            // Do the same as above, excpet now match the $achievementDB to match what the user is currently on
            // 
            // This is b/c on the frontend, to sort by index for both arrays, they need to match by ID 
            $userAchievementIDs = array_column($userAchievements, 'id');

            $achievements = $achievementsDB->filter(function ($achievement) use ($userAchievementIDs) {
                return in_array($achievement->id, $userAchievementIDs);
            })->values();

            $response = [
                'achievements' => $achievements,
                'userAchievements' => $userAchievements,
            ];

            return response()->json($response);
        } else {
            return;
        }


    }
}
