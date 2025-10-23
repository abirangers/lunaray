<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $activities = $user->activities()->latest()->limit(10)->get();
        $stats = $this->calculateProfileStats($user);
        
        return view('profile.show', compact('user', 'activities', 'stats'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url|max:255',
        ]);

        $data = $request->only(['name', 'bio', 'phone', 'location', 'website', 'social_links']);
        
        // Clean up social links - remove empty values
        if (isset($data['social_links'])) {
            $data['social_links'] = array_filter($data['social_links'], function($link) {
                return !empty($link);
            });
        }

        $user->update($data);

        // Log activity
        $this->logActivity($user, 'profile_updated', 'Profile information updated');

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store and process new avatar
        $file = $request->file('avatar');
        $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Resize and save image using Intervention Image v3
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image->resize(150, 150);
        
        // Get the file extension and encode accordingly
        $extension = $file->getClientOriginalExtension();
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $encodedImage = $image->toJpeg(90);
        } elseif ($extension === 'png') {
            $encodedImage = $image->toPng();
        } elseif ($extension === 'webp') {
            $encodedImage = $image->toWebp(90);
        } else {
            $encodedImage = $image->toJpeg(90); // Default to JPEG
        }
        
        Storage::disk('public')->put($filename, $encodedImage);
        
        $user->update(['avatar' => $filename]);

        // Log activity
        $this->logActivity($user, 'avatar_changed', 'Profile avatar updated');

        return redirect()->route('profile.show')
            ->with('success', 'Avatar updated successfully!');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $user->update(['avatar' => null]);

        // Log activity
        $this->logActivity($user, 'avatar_deleted', 'Profile avatar removed');

        return redirect()->route('profile.show')
            ->with('success', 'Avatar removed successfully!');
    }

    /**
     * Show password change form.
     */
    public function showPasswordForm()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => bcrypt($request->password)]);

        // Log activity
        $this->logActivity($user, 'password_changed', 'Password updated');

        return redirect()->route('profile.show')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Calculate profile statistics based on user role.
     */
    private function calculateProfileStats(User $user)
    {
        $stats = [
            'account_age' => $user->created_at->diffForHumans(),
            'last_login' => $user->updated_at->diffForHumans(),
        ];

        if ($user->hasRole('content_manager') || $user->hasRole('admin')) {
            $stats = array_merge($stats, [
                'articles_created' => $user->articles()->count(),
                'articles_published' => $user->articles()->published()->count(),
                'total_views' => $user->articles()->sum('view_count'),
                'recent_articles' => $user->articles()->latest()->limit(5)->get(),
            ]);
        }

        if ($user->hasRole('admin')) {
            $stats = array_merge($stats, [
                'total_users' => User::count(),
                'total_articles' => \App\Models\Article::count(),
                'system_stats' => $this->getSystemStats(),
            ]);
        }

        return $stats;
    }

    /**
     * Get system statistics for admin users.
     */
    private function getSystemStats()
    {
        return [
            'total_users' => User::count(),
            'google_users' => User::whereNotNull('google_id')->count(),
            'staff_users' => User::whereNull('google_id')->count(),
            'admin_users' => User::role('admin')->count(),
            'content_managers' => User::role('content_manager')->count(),
            'public_users' => User::role('user')->count(),
        ];
    }

    /**
     * Log user activity.
     */
    private function logActivity(User $user, string $action, string $description, array $metadata = [])
    {
        UserActivity::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}