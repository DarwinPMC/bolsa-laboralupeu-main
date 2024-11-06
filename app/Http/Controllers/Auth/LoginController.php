<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->rol === 'admin') {
                return redirect()->intended('/dashboard');
            }

            if (!$user->is_approved) {
                Auth::logout();
                return redirect()->route('approval.wait')->with('message', 'Tu cuenta está en espera de aprobación.');
            }

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Las credenciales no son correctas.']);
    }
}
