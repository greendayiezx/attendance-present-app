<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];


        $user = User::where('email', $request->email)->first();
        if (Auth::attempt($credentials)) {
            // dd(Auth::user()->roles);
            if (Auth::user()->roles == "admin") {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/lecturer/dashboard');
            }
        }
        // // If login fails
        return back()->withErrors([
            'email' => 'Data yang diberikan tidak sama dengan yang ada di database',

        ]);
        // var_dump( $credentials['email'],$credentials["password"]);
    }
    public function showSignUpForm()
    {
        return view('sign_up');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Pastikan ada konfirmasi password
        ]);

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'dosen',
        ]);

        return redirect()->to('/')->with('success', 'Registration successful!');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
