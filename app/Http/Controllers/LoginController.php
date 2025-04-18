<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'user' => Auth::user()
                ]);
            }
            return redirect()->intended('/');
        }
    
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['The provided credentials are incorrect.']]
            ], 422);
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return $request->wantsJson()
            ? response()->json(['success' => true])
            : redirect('/');
    }
}
