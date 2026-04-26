<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('custom')->attempt($credentials)) {
            return redirect('/private');
        }

        return 'Invalid credentials';
    }

    public function logout()
    {
        Auth::guard('custom')->logout();

        return redirect('/public');
    }
}
