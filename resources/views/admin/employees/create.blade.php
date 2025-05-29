@extends('layouts.admin')

@section('title', 'Create Assessment')

@section('content')

<main class="flex-1 max-w-4xl px-4 py-6 mx-auto w-full">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-100">Add New Employee</h1>
                    <p class="text-sm text-gray-400">Fill in the information below to create a new employee account</p>
                </div>
            </div>
            <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-3 py-2 text-sm border border-slate-700 rounded-lg text-gray-300 bg-transparent hover:bg-slate-800 focus:ring focus:ring-slate-500/20 transition-all duration-300">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </a>
        </div>
    </div>
    <div class="w-full mx-auto">
        <div class="bg-slate-800/60 backdrop-blur-md rounded-lg shadow-lg border border-slate-700/50 overflow-hidden">
            <form method="POST" action="{{ route('admin.employees.store') }}" novalidate class="space-y-6" aria-labelledby="form-title">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Please correct the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h2 class="text-lg font-medium text-gray-100">Personal Information</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">
                                Full Name <span class="text-indigo-400">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('name') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="e.g., John Doe" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">
                                Email Address <span class="text-indigo-400">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="e.g., john.doe@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="department" class="block text-sm font-medium text-gray-300 mb-1.5">
                                Department <span class="text-indigo-400">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <input type="text" name="department" id="department" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('department') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="e.g., Sales" value="{{ old('department') }}" required>
                                @error('department')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position" class="block text-sm font-medium text-gray-300 mb-1.5">
                                Position <span class="text-indigo-400">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="text" name="position" id="position" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('position') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="e.g., Manager" value="{{ old('position') }}" required>
                                @error('position')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="block text-sm font-medium text-gray-300 mb-1.5">
                                Status <span class="text-indigo-400">*</span>
                            </label>
                            <div class="relative">
                                <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('status') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" required>
                                    <option value="active" {{ old('status', $employee->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $employee->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="form-group">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">
                            Password <span class="text-indigo-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('password') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="Enter password" required>
                            @error('password')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">
                            Confirm Password <span class="text-indigo-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150 @error('password_confirmation') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="Confirm password" required>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 px-6 py-4 bg-slate-900/30 border-t border-slate-700/50">
                    <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-gray-300 transition-colors duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-150">
                        Create Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection
