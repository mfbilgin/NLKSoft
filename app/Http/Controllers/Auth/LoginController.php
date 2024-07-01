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
        if(Auth::attempt($request->only('email', 'password'))){
            $user = (new User)->getUserByEmail($request->email);
            $request->session()->put('user', $user);

            return redirect()->route('home');
        }else{
            return redirect()->back()->with('error', 'Invalid login details')->withInput();
        }
    }
}
