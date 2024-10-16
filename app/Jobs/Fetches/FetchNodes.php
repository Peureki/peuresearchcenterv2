<?php

namespace App\Jobs\Fetches;

use App\Http\Controllers\Controller;
use App\Models\Glyph;
use App\Models\GlyphDropRate;
use App\Models\Items;
use App\Models\Node;
use App\Models\NodeBenchmark;
use App\Models\NodeBenchmarkCombination;
use App\Models\NodeBenchmarkDropRate;
use App\Models\NodeDropRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchNodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Insert glyph names that are vaiable for a benchmark
    public $glyphNames = [
        ['name' => 'Glyph of the Scavenger', 'id' => 87442],
        ['name' => 'Glyph of the Unbound', 'id' => 87428],
        ['name' => 'Glyph of Volatility', 'id' => 87698],
        ['name' => 'Glyph of the Watchknight', 'id' => 87438],
        ['name' => 'Glyph of the Forester', 'id' => 87550],
        ['name' => 'Glyph of the Herbalist', 'id' => 88241],
        ['name' => 'Glyph of the Leatherworker', 'id' => 87473],
        ['name' => 'Glyph of the Prospector', 'id' => 87534],
        ['name' => 'Glyph of the Tailor', 'id' => 87407],
        ['name' => 'Glyph of Bounty', 'id' => 87462]
    ];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $glyphNames = $this->glyphNames; 
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->nodes(); 
        $this->glyphs();
        $this->nodeBenchmarks();
    }

    private function getGlyphCombinations(){
        $combinations = [];
        $glyphNames = $this->glyphNames; 

        foreach($glyphNames as $pick){
            foreach ($glyphNames as $axe){
                foreach ($glyphNames as $sickle){
                    $combinations[] = [$pick, $axe, $sickle]; 
                }
            }
        }   
        return $combinations; 
    }

    
    // *
    // * SET NODE BENCHMARKS AND ALL THEIR UNIQUE COMBINATIONS
    // * 
    private function nodeBenchmarks(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwyxz2aACIrIR-vyyOoI0_lPYV3V1af9G5vo0J6_pP_ez4wHQ_LXroc3A6msTlyLh4SYQ/exec?endpoint=nodeBenchmarks');
        $spreadsheet = $api->json(); 

        
        // Get all glyph combinations
        $glyphCombations = $this->getGlyphCombinations(); 
    
        foreach ($spreadsheet['nodeBenchmarks'] as $nodeBenchmarks){
            

            NodeBenchmark::updateOrCreate(
                [
                    'id' => $nodeBenchmarks['id'],
                ],
                [
                    'name' => $nodeBenchmarks['name'],
                    'type' => $nodeBenchmarks['type'],
                    'level' => $nodeBenchmarks['level'],
                    'sample_size' => $nodeBenchmarks['sampleSize'],
                    'time' => $nodeBenchmarks['time'],
                ]
            );

            foreach ($glyphCombations as $combination){
                list($pick, $axe, $sickle) = $combination; 
                // If a benchmark specifically only gathers one type of node, then the other node types are null 
                switch ($nodeBenchmarks['type']){
                    case 'Ore':
                        $axe['name'] = null;
                        $sickle['name'] = null; 
                        break;

                    case 'Log':
                        $pick['name'] = null; 
                        $sickle['name'] = null; 
                        break;

                    case 'Plant':
                        $pick['name'] = null;
                        $axe['name'] = null; 
                        break;

                    // Double combos
                    case 'Log, Plant':
                    case 'Plant, Log':
                        $pick['name'] = null; 
                        break;
                }
                
                // Check if a combination already exist in the database
                // Ex: If it's a 'plant' benchmark and the other two are null, then there should only be one entry of the [null, null, sickle] benchmark
                // This way it doesn't unnecessarily put all the combinations possible when the values would be the same for any combo that has the same sickle
                $existingCombination = NodeBenchmarkCombination::where([
                    'node_benchmark_id' => $nodeBenchmarks['id'],
                    'pick' => $pick['name'],
                    'axe' => $axe['name'],
                    'sickle' => $sickle['name'],
                ])->first();
                // If combo already exists, next iteration
                if ($existingCombination){
                    continue;
                } else {
                    NodeBenchmarkCombination::updateOrCreate(
                        [
                            'node_benchmark_id' => $nodeBenchmarks['id'],
                            'pick_id' => $pick['id'],
                            'axe_id' => $axe['id'],
                            'sickle_id' => $sickle['id'],
                            'pick' => $pick['name'],
                            'axe' => $axe['name'],
                            'sickle' => $sickle['name'],
                        ],
                        [
    
                        ]
                    );
                }

                
            }
            
            if ($nodeBenchmarks['itemID']){
                $items = explode(',', $nodeBenchmarks['itemID']);
                $itemsDR = explode(',', $nodeBenchmarks['itemDR']);
                $itemsLevel = explode(',', $nodeBenchmarks['level']);
            }

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                NodeBenchmarkDropRate::updateOrCreate(
                    [
                        'node_benchmark_id' => $nodeBenchmarks['id'],
                        'node_id' => $id,
                        'level' => $itemsLevel[$key],
                    ],
                    [
                        'drop_rate' => $itemsDR[$key],
                    ]
                );
            }
        }
    }

    private function glyphs(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwyxz2aACIrIR-vyyOoI0_lPYV3V1af9G5vo0J6_pP_ez4wHQ_LXroc3A6msTlyLh4SYQ/exec?endpoint=glyphs');
        $spreadsheet = $api->json(); 

        foreach ($spreadsheet['glyphs'] as $index => $glyph){
            Glyph::updateOrCreate(
                [
                    'id' => $glyph['id'],
                    'item_id' => $glyph['itemID'],
                ],
                [
                    'level' => $glyph['level'],
                    'name' => $glyph['name'],
                    'type' => $glyph['type'],
                    'sample_size' => $glyph['sampleSize'],
                ]
            );

            if (!empty($glyph['dropID'])){
                $items = explode(',', $glyph['dropID']);
                $itemsDR = explode(',', $glyph['dropDR']);
    
                foreach ($items as $key => $item){
                    // In the spreadsheet, there may be blank entries
                    // Trim them and skip if there is any
                    $id = trim($item); 
                    if (empty($item)){
                        continue; 
                    }
    
                    GlyphDropRate::updateOrCreate(
                        [
                            'glyph_id' => $glyph['id'],
                            'item_id' => $id
                        ],
                        [
                            'drop_rate' => $itemsDR[$key],
                        ]
                    );
                }
            }
            
            if (!empty($glyph['currencyID'])){
                $currencies = explode(',', $glyph['currencyID']);
                $currenciesDR = explode(',', $glyph['currencyDR']); 

                foreach ($currencies as $key => $currency){
                    GlyphDropRate::updateOrCreate(
                        [
                            'glyph_id' => $glyph['id'],
                            'currency_id' => $currency
                        ],
                        [
                            'drop_rate' => $currenciesDR[$key],
                        ]
                    );
                }
            }
        }
    }

    private function nodes(){
        $api = Http::get('https://script.google.com/macros/s/AKfycbwyxz2aACIrIR-vyyOoI0_lPYV3V1af9G5vo0J6_pP_ez4wHQ_LXroc3A6msTlyLh4SYQ/exec?endpoint=nodes');
        $spreadsheet = $api->json(); 

        foreach($spreadsheet['nodes'] as $node){
            //dd($spreadsheet['nodes'], $node);
            Node::updateOrCreate(
                [
                    'id' => $node['id'],
                ],
                [
                    'name' => $node['name'],
                    'type' => $node['type'],
                    'sample_size' => $node['sampleSize'],
                ]
            );

            if ($node['itemID']){
                $items = explode(',', $node['itemID']);
                $itemsDR = explode(',', $node['itemDR']);
            }

            foreach ($items as $key => $item){
                // In the spreadsheet, there may be blank entries
                // Trim them and skip if there is any
                $id = trim($item); 
                if (empty($item)){
                    continue; 
                }

                NodeDropRate::updateOrCreate(
                    [
                        'node_id' => $node['id'],
                        'item_id' => $id,
                    ],
                    [
                        'drop_rate' => $itemsDR[$key]
                    ]
                );
            }

            if (!empty($node['currencyID'])){
                $currencies = explode(',', $node['currencyID']);
                $currenciesDR = explode(',', $node['currencyDR']); 

                foreach ($currencies as $key => $currency){
                    NodeDropRate::updateOrCreate(
                        [
                            'node_id' => $node['id'],
                            'currency_id' => $currency
                        ],
                        [
                            'drop_rate' => $currenciesDR[$key],
                        ]
                    );
                }
            }
        }
    }
}
