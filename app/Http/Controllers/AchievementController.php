<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Fish;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class AchievementController extends Controller
{
    // *
    // * GET DRIZZLEWOOD COMMENDATION-RELATED ACHIEVEMENTS
    // * 
    // * Goal
    // * Return all commendation-related achievements and user's current progress
    // * 
    public function getDrizzlewoodRewardTracks(){
        $user = auth()->user(); 

        $commendationIDs = [
            [
                'id' => 93525, // Ash Legion 
                'achievementID' => 5327,
                'repeatableAchievementID' => 5338,
            ],
            [
                'id' => 93625, // Blood Legion
                'achievementID' => 5312,
                'repeatableAchievementID' => 5278,
            ],
            [
                'id' => 93496, // Flame Legion
                'achievementID' => 5319,
                'repeatableAchievementID' => 5334,
            ],
            [
                'id' => 93624, // Iron Legion
                'achievementID' => 5298,
                'repeatableAchievementID' => 5286,
            ],
            [
                'id' => 93868, // Dominion
                'achievementID' => 5403,
                'repeatableAchievementID' => 5391,
            ],
            [
                'id' => 93899, // Frost Legion
                'achievementID' => 5364,
                'repeatableAchievementID' => 5356,
            ],
        ];

        $response = [];

        $oneTimeAchievementIDs = array_column($commendationIDs, 'achievementID');
        $repeatableAchievementIDs = array_column($commendationIDs, 'repeatableAchievementID');  

        if ($user){
            $this->updateUserAPIAchievements($user); 

            $userOneTimeAchievements = array_values(array_filter($user->achievements, function ($achievement) use ($oneTimeAchievementIDs){
                return in_array($achievement['id'], $oneTimeAchievementIDs); 
            }));

            $repeatableAchievementIDs = array_values(array_filter($user->achievements, function ($achievement) use ($repeatableAchievementIDs){
                return in_array($achievement['id'], $repeatableAchievementIDs); 
            }));


            $response = [
                'oneTimeAchievements' => $userOneTimeAchievements,
                'repeatableAchievements' => $repeatableAchievementIDs,
            ];
        }

        

        return response()->json($response); 
    }


    // *
    // * GET FISHING ACHIEVEMENTS
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

        // Specifically 'fisher' collection achievements
        $fisherAchievementDB = Achievement::whereIn('id', $achievementIDs)->get();
        // Extract a list of IDs that are prerequisites to other fisher achievements
        // ie. World Class from Avid World Class
        $prerequisiteAchievements = $fisherAchievementDB->flatMap(function ($achievement) {
            // Check if the prerequisites property exists and is a non-empty array
            return isset($achievement->prerequisites) && is_array($achievement->prerequisites)
                ? $achievement->prerequisites
                : [];
        })->unique()->values();

        // 1) Loop through all the achievements
        // 2) Loop through each achievement->bits
        // 3) For each bit, get that fish info and replace existing ->bits info
        foreach ($fisherAchievementDB as &$achievement){
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

        //dd($fisherAchievementDB->where('id', 6471)->first());

        if ($user){
            // * 
            // * REFRESH $USER->ACHIEVEMENTS
            // *
            $apiKey = Crypt::decryptString($user->api_key);

            $gw2API = Http::get('https://api.guildwars2.com/v2/account/achievements?access_token='.$apiKey);

            $user->update([
                'achievements' => $gw2API->json(),
            ]);

            // Get COD progress achievement
            $codAchievement = array_values(array_filter($user->achievements, function($achievement){
                return $achievement['id'] === 6111; 
            }));

            // 1) Get user achievements
            // 2) Filter the achievements by matching $achievementIDs and get an array of fish that have been completed currently in that achievement
            // Ex: return array: [2, 3, 5, 6]
            // 3) populate $response with the newly populated $achievementsDB and $userAchievements then RETURN
            $userAchievements = array_values(array_filter($user->achievements, function($achievement) use ($achievementIDs){
                // Make sure to only return matching user achievement IDS && if the achivement is not complete yet
                // But, if the achievement is considered 'done', but can be repeated, show that
                return in_array($achievement['id'], $achievementIDs) && (!($achievement['done'] && !array_key_exists('repeated', $achievement)));
            }));

            // $prerequisiteAchievements = $fisherAchievementDB->filter(function ($achievement) use ($achievementIDs){
            //     return in_array($achievement->prerequisites, $achievementIDs) && ; 
            // });

            // IF a player has not even started a fishing achievement, it will not show up in their $user->achievements api 
            // 1a) Check which achievements are not listed in $user->achievements
            // 1b) Check if the missing achievement is a prerequisite of an unfinished achievement. ie World Class and Avid World Class
            // 2) Filter the $fisherAchievementDB to match those missing user achievements. This is to mainly get the count of total fishes need to compelte the achievement
            // 3) Create an empty $user->achievement for that missing achievement
            foreach ($achievementIDs as $achievementID){
                if (!in_array($achievementID, array_column($user->achievements, 'id'))){
                    $filteredAchievement = $fisherAchievementDB->filter(function ($achievement) use ($achievementID) {
                        return $achievement['id'] === $achievementID;
                    })->first();

                    // Since missing IDs are IDs that haven't been done yet, check if ID is not a prerequisite
                    if (!in_array($achievementID, $prerequisiteAchievements->toArray())){
                        continue; 
                    }

                    $userAchievements[] = [
                        'current' => 0,
                        'done' => false,
                        'id' => $achievementID, 
                        'max' => $filteredAchievement ? count($filteredAchievement['bits']) : 0,
                    ];
                }
            }

            // Do the same as above, excpet now match the $achievementDB to match what the user is currently on
            // 
            // This is b/c on the frontend, to sort by index for both arrays, they need to match by ID 
            $userAchievementIDs = array_column($userAchievements, 'id');

            $achievements = $fisherAchievementDB->filter(function ($achievement) use ($userAchievementIDs) {
                return in_array($achievement->id, $userAchievementIDs);
            })->values();

            $response = [
                'achievements' => $achievements,
                'userAchievements' => $userAchievements,
                'cod' => $codAchievement,
            ];

            return response()->json($response);
        } else {
            return;
        }


    }
}
