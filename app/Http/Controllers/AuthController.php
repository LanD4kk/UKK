<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        if(Auth::check()) {
            if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
                return redirect('/admin/dashboard');
            }

            return redirect('/student/dashboard');
        }

        return view('login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'identity_number' => ['required'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            if($role === 'admin' || $role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'identity_number' => 'Kredensial yang diberikan tidak sesuai dengan catatan kami, silahkan coba lagi.'
        ])->onlyInput('identity_number');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
