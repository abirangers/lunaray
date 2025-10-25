<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(20);

        $userStats = [
            'total_users' => User::count(),
            'google_users' => User::whereNotNull('google_id')->count(),
            'staff_users' => User::whereNull('google_id')->count(),
            'admin_users' => User::role('admin')->count(),
            'content_managers' => User::role('content_manager')->count(),
            'public_users' => User::role('user')->count(),
        ];

        return view('admin.users', compact('users', 'userStats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,content_manager,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:user,content_manager,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of the last admin
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('admin.users')
                ->with('error', 'Cannot delete the last admin user.');
        }

        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request, User $user)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Clear existing avatar
        $user->clearMediaCollection('avatar');
        
        // Add new avatar
        $user->addMediaFromRequest('avatar')
            ->toMediaCollection('avatar');

        return redirect()->back()
            ->with('success', 'Avatar updated successfully!');
    }

    /**
     * Delete user avatar.
     */
    public function deleteAvatar(User $user)
    {
        $user->clearMediaCollection('avatar');

        return redirect()->back()
            ->with('success', 'Avatar removed successfully!');
    }
}
