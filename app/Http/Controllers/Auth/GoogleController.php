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
        'password' => bcrypt(\Illuminate\Support\Str::random(32)),
        'email_verified_at' => now(),
    ]
);



    $user->update([
        'avatar' => $googleUser->getAvatar(),
    ]);

if ($user->email_verified_at === null) {
    $user->forceFill([
        'email_verified_at' => now(),
    ])->save();
}

if (! $user->is_active) {
    return redirect()
    ->route('login')
    ->with('error', 'Your account has been deactivated.');
}

auth()->login($user, true);

return redirect()->route('dashboard');

}



}
