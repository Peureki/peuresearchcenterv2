<?php

namespace App\Jobs\Fetches;

use App\Models\Bag;
use App\Models\BagDropRate;
use App\Models\ChoiceChest;
use App\Models\ChoiceChestOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchBags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $this->bags(); 
        $this->choiceChests();
    }

    private function bags(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwRZ5MH8MQ80kyvPV-WoZFh0z1OzKkktF_AW_AEcpNDGXWyQ5wOksILO6OfWO6Fxvk9gQ/exec?endpoint=bags'); 
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['bags'] as $bag){
            Bag::updateOrCreate(
                [
                    'id' => $bag['id'],
                ],
                [
                    'sample_size' => $bag['sampleSize'],
                ]
            ); 

            if ($bag['itemID']){
                $items = explode(",", $bag['itemID']); 
                $itemDrs = explode(",", $bag['itemDropRate']); 
            }
            // NO ITEMS, ONLY CURRENCIES AS DROPS 
            else {
                $currencies = explode(",", $bag['currencyID']);
                $currenciesDrs = explode(",", $bag['currencyDropRate']); 

                foreach ($currencies as $key => $currency){
                    //dd($currency, $bag['id']);
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
                            'currency_id' => $currency,
                        ],
                        [
                            'drop_rate' => $currenciesDrs[$key],
                        ]
                    );
                }
                continue; 
            }
            

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                if ($id === 'Exotic'){
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
                            'item_id' => null, 
                        ],
                        [
                            'exotic' => true,
                            'drop_rate' => $itemDrs[$key],
                        ]
                    );
                } else {
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'], 
                            'item_id' => $id,
                        ],
                        [
                            'drop_rate' => $itemDrs[$key],
                        ]
                    );
                }

                
            }

            if (!empty($bag['currencyID'])){
                $currencies = explode(",", $bag['currencyID']);
                $currenciesDrs = explode(",", $bag['currencyDropRate']); 

                foreach ($currencies as $key => $currency){
                    BagDropRate::updateOrCreate(
                        [
                            'bag_id' => $bag['id'],
                            'currency_id' => $currency,
                        ],
                        [
                            'drop_rate' => $currenciesDrs[$key],
                        ]
                    );
                }
            }

            
        }
    }

    private function choiceChests(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwRZ5MH8MQ80kyvPV-WoZFh0z1OzKkktF_AW_AEcpNDGXWyQ5wOksILO6OfWO6Fxvk9gQ/exec?endpoint=choiceChests');
        $spreadsheet = $api->json(); 

        // Populate these for upsert() 
        // $ids => PK, ids of the chests
        // $options => FKs of the chests, bags, currencies, and the drop quantities
        $ids = [];
        $options = []; 
        
        foreach ($spreadsheet['choiceChests'] as $chest){
            // Populate chest IDs
            $ids[] = ['id' => $chest['id']];

            // Make arrays for all item info
            // $itemChoice will always have the full array
            // Ex: if there's a currency, $itemChoice will count that
            $itemChoice = explode(",", $chest['itemChoice']);
            $itemIDs = explode(",", $chest['itemID']);
            $itemQty = explode(",", $chest['itemQuantity']); 

            //dd($itemChoice);
            // Use $itemChoice since it represents all items and currencies
            foreach ($itemChoice as $key => $choice){
                $bag = null; 
                // Check if there's a Bag
                if (Bag::find($itemIDs[$key])){
                    $bag = $itemIDs[$key];
                }
                $options[] = [
                    'choice_chest_id' => $chest['id'],
                    'item_id' => $itemIDs[$key],
                    'bag_id' => $bag,
                    'option' => $choice, 
                    'quantity' => $itemQty[$key],
                ];
            }
        }
        // Populate databases
        ChoiceChest::upsert($ids, ['id']);
        ChoiceChestOption::upsert($options, [
            'choice_chest_id',
            'item_id',
            'bag_id',
            'option',
            'quantity'
        ]);
    }
}
