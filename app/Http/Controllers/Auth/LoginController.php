<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = (new User)->getUserByEmail($request->email);

        if($user && Auth::attempt($request->only('email', 'password'))){
            if($user && !$user->email_verified_at){
                return redirect()->route('verification.notice');
            }
            Auth::login($user);
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('status','danger')->with('message','Hatalı giriş!!!')->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('user');
        return redirect()->route('login');
    }
}
