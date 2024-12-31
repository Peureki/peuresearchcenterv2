<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
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
            6509
        ];

        

        $achievementsDB = Achievement::whereIn('id', $achievementIDs)->get(); 

        foreach ($achievementsDB as $achievement){
            //dd($achievement);
            // $achivement['bits] has a list of fish IDs 
            // 1) Check if the fish ID is already in $itemIDs
            // 2) Yes => add, else => next
            foreach ($achievement['bits'] as $fish){
                if (!in_array($fish['id'], $itemIDs)){
                    $itemIDs[] = $fish['id'];
                }
            }
        }

        dd($itemIDs);

        if ($user){
            // 1) Get user achievements
            // 2) Filter the achievements by matching $achievementIDs and get an array of fish that have been completed currently in that achievement
            // Ex: return array: [2, 3, 5, 6]
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
