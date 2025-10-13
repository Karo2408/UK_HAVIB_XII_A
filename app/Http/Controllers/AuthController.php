<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\UserModel;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'Password' => 'required',
        ]);

        $user = UserModel::where('Email', $request->Email)->first();

        // dd($user);

        if($user && Hash::check($request->Password, $user->Password)){
            // dd($user && Hash::check($request->Password, $user->Password));
            Auth::login($user);
            return redirect()->route('dashboard.index')->with('sruccess','Behasil login!');
        }

        return back()->withErrors(['Email'=>'Email atau password salah']);
    }

    public function showRegister()
    {
        abort(404); // Nonaktifkan tampilan register
    }

    public function register(Request $request)
    {
        abort(404); // Nonaktifkan pembuatan akun
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','Berhasil logout!');
    }
}
