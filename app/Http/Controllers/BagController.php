<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BagController extends Controller
{
    public function getTable($table, $sellOrderSetting, $tax){
        $returnArray = []; 

        $data = DB::table($table)
            ->join('items', "items.id", '=', "{$table}.item_id")
            ->select("{$table}.*", 'items.*')
            ->get();

        foreach ($data as $item){
            $entry = [
                'name' => $item->name,
                'icon' => $item->icon,
                'returnPriceSetting' => $item->$sellOrderSetting,
                'dropRate' => $item->drop_rate,
                'value' => ($item->$sellOrderSetting * $item->drop_rate) * $tax,
            ];
            $returnArray[] = $entry;

        }
        return response()->json($returnArray);
    }
}
