<?php

namespace App\Jobs\Fetches;

use App\Http\Controllers\Controller;
use App\Models\NodeBenchmarkCombination;
use App\Models\NodeBenchmarkDropRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchNodeCombinations implements ShouldQueue
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
        $this->setCombinationValues();
    }

    private function setCombinationValues(){
        // Initialize controller to get values of benchmarks 
        $controller = new Controller(); 
        
        // Get node benchmark drop rates
        // Use this to get the values of the combinations
        $nodeBenchmarkDropRates = NodeBenchmarkDropRate::join('node_benchmarks', 'node_benchmark_id', '=', 'node_benchmarks.id')
        ->join('nodes', 'node_id', '=', 'nodes.id')
        ->select(
            'node_benchmark_drop_rates.*',
            'node_benchmarks.*',
            'nodes.*',
            'node_benchmarks.name as map_name',
            'node_benchmarks.sample_size as sample_size'
        )
        ->get()
        ->groupBy('node_benchmark_id'); 

        // Get all glyph combinations
        $combinationDropRates = NodeBenchmarkCombination::get()->groupBy('node_benchmark_id');

        //dd($combinationDropRates);

        // Time it takes to move gathering tools, switch characters, and go to the first wp of the route
        $switchCharacterTime = 28; 

        foreach ($nodeBenchmarkDropRates as $id => $benchmark){
            foreach ($combinationDropRates[$id] as $combination){
                //dd($combination);

                $benchmarkData = null; 
                $benchmarkValue = 0;
                $mostValuedItemID = 0; 
                $gph = 0;

                $pick = $combination->pick ?? null;
                $axe = $combination->axe ?? null;
                $sickle = $combination->sickle ?? null;

                // Insert every combination of glyphs
                foreach ($benchmark as $node){
                    // Set $includes param to VM and UM b/c of the glyphs
                    // Set $sellOrderSetting and $tax to 'sell_price', 0.85 to standardize
                    $benchmarkData = $controller->getNodeValue($pick, $axe, $sickle, $node->level, $node->node_id, $node->drop_rate, ["Volatile Magic", "Unbound Magic"], "sell_price", 0.85);
                    // Accumulate benchmark value
                    $benchmarkValue += $benchmarkData['value']; 
                }
                // Set most valued item ID
                $mostValuedItemID = $benchmarkData['mostValuedItemID'];
                // Set GPH of given benchmark
                $gph = (3600 / ($benchmark[0]->time + $switchCharacterTime)) * $benchmarkValue; 
            

                NodeBenchmarkCombination::where(
                [
                    'node_benchmark_id' => $id,
                    'pick' => $pick,
                    'axe' => $axe,
                    'sickle' => $sickle,
                ])->update([
                    'most_valued_item_id' => $mostValuedItemID,
                    'value' => $gph,
                ]);
            }
            
        }

        //dd($nodeBenchmarkDropRates);
    }
}
