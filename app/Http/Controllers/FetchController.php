<?php

namespace App\Http\Controllers;

use App\Jobs\Fetches\FetchItems;
use App\Jobs\Fetches\FetchPrices;
use App\Models\Bags\TrophyShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FetchController extends Controller
{
    public function fetchItems(){
        dispatch(new FetchItems());
        return response()->json(['message' => 'Fetching items job has been queued']);
    }

    public function fetchPrices(){
        dispatch(new FetchPrices());
        return response()->json(['message' => 'Fetching prices job has been queued']);
    }

    public function fetchSS(){
        $apiURL = Http::get('https://script.googleusercontent.com/macros/echo?user_content_key=-KdN_0qwJNbCaeEm1Mnbu-utS9px03V_sVM5Q-lLMwkT6_R8XMwsiffdHML5HZtwy8de5STTPK3RN_9b0lmmFcFiOdnEUUbPm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnEjCbF3LOPO5ivsrxnZcw7bxLo79wERq_NR62uXjsrJ7Iz9TMSz8gTnUzA-UIH_EjmUxpYwMab6rr0fHkE1UH7Oy6wMvf8qts9z9Jw9Md8uu&lib=MCmsgulCw7MibBJ49mubmOUo-J35B6SJ_');

        $api = $apiURL->json(); 

        dd($api);
    }

    public function fetchTrophyShipments(){
        $merp = TrophyShipment::find(1);
        $parent = $merp->items['sell_price'];
        dd($merp);
    }
}
