@extends('layouts.employee')

@section('title', 'Profile Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6" role="main" aria-labelledby="profile-settings-title">
        <!-- Header -->
        <div class="mb-6">
            <h1 id="profile-settings-title" class="text-2xl font-semibold text-gray-100">Profile Settings</h1>
            <p class="mt-1 text-sm text-gray-400" id="profile-settings-description">Manage your account information and preferences</p>
        </div>

        <!-- Profile Form -->
        <form action="{{ route('employee.profile.update', auth()->user()->id) }}" method="POST" class="space-y-6" aria-labelledby="profile-form-title">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="space-y-4">

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2" role="group" aria-labelledby="personal-info-title">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                        <div class="relative">
                            <input type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                required
                                aria-required="true"
                                aria-describedby="name-error"
                                placeholder="Enter your full name"
                                autocomplete="name">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('name')
                        <p class="mt-1 text-sm text-red-400" id="name-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <div class="relative">
                            <input readonly type="email" name="email" id="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                required
                                aria-required="true"
                                aria-describedby="email-error"
                                placeholder="Enter your email address"
                                autocomplete="email">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email')
                        <p class="mt-1 text-sm text-red-400" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2" role="group" aria-labelledby="personal-info-title">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Position</label>
                        <div class="relative">
                            <input readonly type="text" name="position" id="position"
                                value="{{ old('position', auth()->user()->position) }}"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                required
                                aria-required="true"
                                aria-describedby="position-error"
                                placeholder="Your Position"
                                autocomplete="position">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">

                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2h3a1 1 0 011 1v2H5V7a1 1 0 011-1h3zm0 0h6m-9 4h12v10a1 1 0 01-1 1H6a1 1 0 01-1-1V10z"
                                    />
                                </svg>
                            </div>
                        </div>
                        @error('postion')
                        <p class="mt-1 text-sm text-red-400" id="name-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Department</label>
                        <div class="relative">
                            <input type="text" readonly name="department" id="department"
                                value="{{ old('department', auth()->user()->department) }}"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                required
                                aria-required="true"
                                aria-describedby="department-error"
                                placeholder="Your Department"
                                autocomplete="department">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 21V7a1 1 0 011-1h3V3h8v3h3a1 1 0 011 1v14M9 21v-6h6v6"></path>
                                </svg>
                            </div>
                        </div>
                        @error('department')
                        <p class="mt-1 text-sm text-red-400" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="space-y-4 pt-6">
                <h2 id="password-section-title" class="text-lg font-medium text-gray-100 border-b border-gray-700 pb-2">Change Password</h2>
                <p class="text-sm text-gray-400">Leave password fields empty if you don't want to change it</p>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2" role="group" aria-labelledby="password-section-title">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                aria-describedby="current-password-error current-password-help"
                                placeholder="Enter your current password"
                                autocomplete="current-password">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <p id="current-password-help" class="mt-1 text-xs text-gray-400">Required only if changing password</p>
                        </div>
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-400" id="current-password-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                aria-describedby="password-error password-requirements"
                                placeholder="Enter your new password"
                                autocomplete="new-password"
                                minlength="8">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <p id="password-requirements" class="mt-1 text-xs text-gray-400">Minimum 8 characters</p>
                        </div>
                        @error('password')
                        <p class="mt-1 text-sm text-red-400" id="password-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-1 block w-full px-4 py-3 rounded-lg border-2 border-gray-600 bg-slate-800/60 shadow-sm hover:border-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-base text-gray-100 transition-all duration-200 placeholder-gray-400"
                                aria-describedby="password-confirmation-help"
                                placeholder="Confirm your new password"
                                autocomplete="new-password">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <p id="password-confirmation-help" class="mt-1 text-xs text-gray-400">Re-enter your new password</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit"
                    class="inline-flex items-center justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300"
                    aria-label="Save profile changes">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection