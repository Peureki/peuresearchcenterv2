<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt (logging in).
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
        // Initialize and fill remember_token in user database 
        $remember = $request->filled('remember');
 
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); 
            return response()->json(Auth::user(), 200);
        }

        return response()->json(['error' => 'The provided credentials do not match our records'], 401);
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Get current URL
        $currentURL = url()->previous(); 

        return redirect($currentURL);
    }

    public function register(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
