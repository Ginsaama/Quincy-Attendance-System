<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function showLoginForm()
    {
        return view('login'); // Assuming your login page is named login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/part');
        }
        // Authentication failed
        return back()->withErrors(['username' => 'Invalid credentials']);
    }
}
