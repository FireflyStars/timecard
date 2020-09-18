<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * Show Login Form
     */

    public function showLoginForm(){
        // if(Auth::check() && Auth::user()->role == "Admin")
        //     return redirect()->route('dashboard');
        // else
        // if(Auth::check() && Auth::id() !=1 ){
        //     return redirect()->route('timecard');;
        // }
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if(Auth::user()->role == "Admin")
                return redirect()->route('dashboard');
            else
                return redirect()->route('timecard');
        }else{
            return redirect()->back()->withErrors(['password'=> 'credential is incorrect']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('show.login.form');
    }
}
