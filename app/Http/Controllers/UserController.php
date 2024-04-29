<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function enterAPIKey(Request $request){
        $user = auth()->user();
        $user->update(['api_key' => $request->apiKey]);
    }
}
