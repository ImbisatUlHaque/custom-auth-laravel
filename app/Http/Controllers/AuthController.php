<?php

namespace App\Http\Controllers;

// use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            return redirect('home');
        }

        return back()->withError('Invalid email or password.');
    }

    public function register_view()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Way - 1
        $userData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
        ]);

        // Way - 2
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|unique:users|email',
        //     'password' => 'required|confirmed'
        // ]);
        // Hash Password
        $userData['password']  = Hash::make($userData['password']);

        // Save in DB
        // Way - 1
        User::create($userData);
        
        // Way - 2
        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);


        if (Auth::attempt($request->only('email','password'))) {
            return redirect('home');
        }

        return redirect('auth.register')->withErrors('Error');
    }

    public function home(){
        return view('home');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('');
    }

}
