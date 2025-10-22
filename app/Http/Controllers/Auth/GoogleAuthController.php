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
    public function callback(Request $request)
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
                    // For security: do NOT link Google to staff accounts
                    if (!is_null($existingUser->password) || $existingUser->hasAnyRole(['content_manager', 'admin'])) {
                        return redirect('/login')->with('error', 'Staff accounts must sign in with email/password.');
                    }

                    // Safe to link Google account to public user
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
                        'email_verified_at' => now(),
                    ]);
                }
            }

            // Assign default 'user' role if not already assigned
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }

            // Log the user in and prevent session fixation
            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/dashboard');

        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
