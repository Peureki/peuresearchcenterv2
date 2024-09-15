<?php

namespace App\Jobs\Fetches;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Items;
use Illuminate\Support\Facades\Http;

class FetchPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $perPage = 200; 
        $currentPage = 0;
        
        $apiIds = Http::get('https://api.guildwars2.com/v2/commerce/prices'); 
        $idList = $apiIds->json(); 

        $totalEntries = count($idList); 
        $totalPages = ceil($totalEntries / $perPage);

        $batch = array_chunk($idList, $perPage);

        
        

        while ($currentPage < $totalPages){
            $apiBatch = Http::get('https://api.guildwars2.com/v2/commerce/prices?ids='.implode(',', $batch[$currentPage]));
            $batchList = $apiBatch->json(); 

            foreach($batchList as $item){
                Items::where('id', $item['id'])
                    ->update([
                        'buy_quantity' => $item['buys']['quantity'], 
                        'buy_price' => $item['buys']['unit_price'],
                        'sell_quantity' => $item['sells']['quantity'],
                        'sell_price' => $item['sells']['unit_price'],
                    ]);
            }
            $currentPage++;
        }
    }
}
