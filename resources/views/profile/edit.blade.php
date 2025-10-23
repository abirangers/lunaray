@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-neutral-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm border border-neutral-200">
            <div class="px-6 py-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-neutral-900">Edit Profile</h1>
                    <p class="text-neutral-600 mt-1">Update your profile information and settings.</p>
                </div>

                <!-- Avatar Upload Component -->
                @include('profile.avatar-upload')

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-neutral-900">Basic Information</h3>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" 
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm bg-neutral-100 cursor-not-allowed" disabled>
                            <p class="mt-1 text-sm text-neutral-500">Email cannot be changed</p>
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-neutral-700 mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="3" 
                                      class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('bio') border-red-500 @enderror"
                                      placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-neutral-900">Contact Information</h3>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-neutral-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-neutral-700 mb-2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('location') border-red-500 @enderror"
                                   placeholder="City, Country">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-neutral-700 mb-2">Website</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}" 
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('website') border-red-500 @enderror"
                                   placeholder="https://example.com">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-neutral-900">Social Links</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="social_links_facebook" class="block text-sm font-medium text-neutral-700 mb-2">Facebook</label>
                                <input type="url" name="social_links[facebook]" id="social_links_facebook" 
                                       value="{{ old('social_links.facebook', $user->social_links['facebook'] ?? '') }}" 
                                       class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('social_links.facebook') border-red-500 @enderror"
                                       placeholder="https://facebook.com/username">
                            </div>

                            <div>
                                <label for="social_links_twitter" class="block text-sm font-medium text-neutral-700 mb-2">Twitter</label>
                                <input type="url" name="social_links[twitter]" id="social_links_twitter" 
                                       value="{{ old('social_links.twitter', $user->social_links['twitter'] ?? '') }}" 
                                       class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('social_links.twitter') border-red-500 @enderror"
                                       placeholder="https://twitter.com/username">
                            </div>

                            <div>
                                <label for="social_links_instagram" class="block text-sm font-medium text-neutral-700 mb-2">Instagram</label>
                                <input type="url" name="social_links[instagram]" id="social_links_instagram" 
                                       value="{{ old('social_links.instagram', $user->social_links['instagram'] ?? '') }}" 
                                       class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('social_links.instagram') border-red-500 @enderror"
                                       placeholder="https://instagram.com/username">
                            </div>

                            <div>
                                <label for="social_links_linkedin" class="block text-sm font-medium text-neutral-700 mb-2">LinkedIn</label>
                                <input type="url" name="social_links[linkedin]" id="social_links_linkedin" 
                                       value="{{ old('social_links.linkedin', $user->social_links['linkedin'] ?? '') }}" 
                                       class="w-full px-3 py-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('social_links.linkedin') border-red-500 @enderror"
                                       placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                        
                        @error('social_links.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-neutral-200">
                        <a href="{{ route('profile.show') }}" class="btn-modern btn-modern-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-modern-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
