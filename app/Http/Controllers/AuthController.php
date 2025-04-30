<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
    public function showregister(){
        return view('auth.register');
    }

    public function register(Request $request){
        $validated = $request->validate([
            'nis' => 'required|unique:users',
            'name' => 'required',
            'kelas' => 'required',
            'username' => 'required|unique:users',
            'jurusan' => 'required',
            'password' => 'required|min:6',
            'role'=>'required|in:admin,member',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = ($validated['role'] === 'admin') ? 'admin':'member';

        User::create($validated);

        return redirect()->route('login')->with('success', 'Anda berhasil mendaftar');
    }


    public function logout(){
        Auth::logout();
        return redirect('');
    }


    public function showlogin(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('member.dashboard');
        }

        return back()->withErrors(['username'. 'Password atau username salah']);
    }
}
