<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ApiRefresh implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->getAchievements(); 
    }

    private function getAchievements(){
        $users = User::get(); 

        foreach ($users as $user){
            if ($user->api_key){
                $api = Http::get('https://api.guildwars2.com/v2/account/achievements?access_token='.$user->api_key);
                
                User::where('id', $user->id)
                ->update(['achievements' => $api->json()]); 
            }
        } 
    }
}
