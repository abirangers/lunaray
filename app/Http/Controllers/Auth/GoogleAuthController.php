<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                // Update existing user's Google tokens
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                // Check if user exists with same email
                $existingUser = User::where('email', $googleUser->email)->first();
                
                if ($existingUser) {
                    // Link Google account to existing user
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                    $user = $existingUser;
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                }
            }

            // Assign default 'user' role if not already assigned
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }

            // Log the user in
            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
