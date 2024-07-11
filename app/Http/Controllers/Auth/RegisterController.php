<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Rules\MultipleWords;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegisterPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
            return redirect()->route('register')->withErrors($e->validator->errors())->withInput();
        }
        $user = $this->create($request->all());
        Cart::create([
            'user_id' => $user->id
        ]);
        Auth::login($user);
        $user->sendEmailVerificationNotification();
        return redirect()->route('verification.notice');
    }

    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:4', new MultipleWords()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
