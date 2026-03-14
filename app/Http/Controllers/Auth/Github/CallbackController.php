<?php

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $githubUser = User::query()
            ->updateOrCreate([
                'nickname'          => $githubUser->getNickname(),
                'email'             => $githubUser->getEmail(),
                'name'              => $githubUser->getName(),
                'password'          => \Illuminate\Support\Str::random(40),
                'email_verified_at' => \Illuminate\Support\now(),
            ]);

        Auth::login($githubUser);

        return to_route('dashboard');
    }
}
