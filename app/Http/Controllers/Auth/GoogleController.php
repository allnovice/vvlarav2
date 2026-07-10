<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

public function callback()
{
    $googleUser = Socialite::driver('google')->user();

    $user = \App\Models\User::firstOrCreate(
        [
            'email' => $googleUser->getEmail(),
        ],
        [
            'name' => $googleUser->getName(),
            'role' => 'employee',
            'email_verified_at' => now(),
            'password' => bcrypt(\Illuminate\Support\Str::random(32)),
        ]
    );
    $user->update([
        'avatar' => $googleUser->getAvatar(),
    ]);
    auth()->login($user, true);

    return redirect()->route('dashboard');
}



}
