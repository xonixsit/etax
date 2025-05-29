@extends('layouts.admin')

@section('title', 'Create Assessment')

@section('content')

<!-- Main Content -->
<main class="flex-1 px-6 py-8 mx-auto w-full mx-auto">
    <!-- Page Header with Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-100 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Create New Assessment   
                </h1>
                <!-- <p class="mt-2 text-gray-400 text-lg">Define your assessment details and settings</p> -->
            </div>
            <a href="{{ route('admin.assessments.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-700 rounded-lg shadow-sm text-sm font-medium text-gray-300 bg-transparent hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Assessments
            </a>
        </div>
    </div>

    <!-- Assessment Form -->
    <div class="w-full mx-auto">
        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 divide-y divide-slate-700/50 mt-6">
            <form action="{{ route('admin.assessments.store') }}" method="POST" class="space-y-8" novalidate>
                @csrf
                <!-- Basic Information Section -->
                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                                Assessment Title
                                <span class="text-indigo-400 ml-1">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="block w-full pl-10 pr-12 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('title') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                    placeholder="e.g., JavaScript Fundamentals Assessment"
                                    value="{{ old('title') }}"
                                    required
                                    maxlength="255"
                                    pattern=".{3,}"
                                    title="Title must be at least 3 characters long">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-gray-500 text-sm" id="titleCounter">0/100</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Choose a clear and descriptive title that reflects the assessment's purpose</p>
                            @error('title')
                            <p class="mt-1 text-sm text-red-400 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Month and Year Fields -->
                        <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="month" class="block text-sm font-medium text-gray-300 mb-2">
                                    Month
                                    <span class="text-indigo-400 ml-1">*</span>
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <select 
                                        name="month"
                                        id="month"
                                        class="block w-full pl-10 pr-12 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('month') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                        required>@foreach ($months as $num => $label)
                                        <option value="{{ $num }}" {{ old('month') == $num ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('month')
                                <p class="mt-1 text-sm text-red-400 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="year" class="block text-sm font-medium text-gray-300 mb-2">
                                    Year
                                    <span class="text-indigo-400 ml-1">*</span>
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        name="year"
                                        id="year"
                                        class="block w-full pl-10 pr-12 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('year') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                        placeholder="e.g., 2024"
                                        value="{{ old('year', date('Y')) }}"
                                        min="2024"
                                        max="2100"
                                        required>
                                </div>
                                @error('year')
                                <p class="mt-1 text-sm text-red-400 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div> -->

                        <!--Due Date-->
                        <div class="form-group">
                            <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                                Due Date
                                <span class="text-indigo-400 ml-1">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    </svg>
                                </div>
                                <input
                                    type="date"
                                    name="due_date"
                                    class="block w-full pl-10 pr-12 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('year') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                    id="due_date" value="{{ old('due_date') }}" />
                            </div>
                            @error('due_date')
                            <p class="mt-1 text-sm text-red-400 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                </svg>
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                                Description
                                <span class="text-indigo-400 ml-1">*</span>
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="block w-full px-4 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 resize-none @error('description') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                    placeholder="Describe what this assessment will evaluate..."
                                    required
                                    maxlength="2000"
                                    title="Please provide a detailed description of the assessment">{{ old('description') }}</textarea>
                                <div class="absolute bottom-3 right-3">
                                    <span class="text-gray-500 text-sm" id="descriptionCounter">0/500</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Provide a detailed description of what this assessment will cover</p>
                            @error('description')
                            <p class="mt-1 text-sm text-red-400 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Time and Score Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Duration Field -->
                            <div class="form-group">
                                <label for="duration" class="block text-sm font-medium text-gray-300 mb-2">
                                    Time Limit
                                    <span class="text-indigo-400 ml-1">*</span>
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        name="duration"
                                        id="duration"
                                        min="5"
                                        max="180"
                                        class="block w-full pl-10 pr-16 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('duration') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                        placeholder="60"
                                        value="{{ old('duration', 60) }}"
                                        required
                                        title="Time limit must be between 5 and 180 minutes">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">minutes</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Set time limit (5-180 minutes)</p>
                                @error('duration')
                                <p class="mt-1 text-sm text-red-400 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Passing Score Field -->
                            <div class="form-group">
                                <label for="passing_score" class="block text-sm font-medium text-gray-300 mb-2">
                                    Passing Score
                                    <span class="text-indigo-400 ml-1">*</span>
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        name="passing_score"
                                        id="passing_score"
                                        min="0"
                                        max="100"
                                        class="block w-full pl-10 pr-12 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300 hover:border-slate-600 @error('passing_score') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                        placeholder="70"
                                        value="{{ old('passing_score', 70) }}"
                                        required
                                        title="Passing score must be between 0 and 100 percent">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Set minimum passing percentage (0-100)</p>
                                @error('passing_score')
                                <p class="mt-1 text-sm text-red-400 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-4 bg-slate-900/30 rounded-b-xl flex items-center justify-between">
                    <div class="flex items-center space-x-2 text-gray-400">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">All fields marked with <span class="text-indigo-400">*</span> are required</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            Continue to Questions
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- JavaScript for Form Handling -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const titleCounter = document.getElementById('titleCounter');
        const descriptionCounter = document.getElementById('descriptionCounter');
        const form = document.querySelector('form');

        // Character counter for title
        titleInput.addEventListener('input', function() {
            const count = this.value.length;
            titleCounter.textContent = `${count}/100`;
            titleCounter.classList.toggle('text-red-400', count > 100);
        });

        // Character counter for description
        descriptionInput.addEventListener('input', function() {
            const count = this.value.length;
            descriptionCounter.textContent = `${count}/500`;
            descriptionCounter.classList.toggle('text-red-400', count > 500);
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Validate title
            if (titleInput.value.trim() === '') {
                showError(titleInput, 'Title is required');
                isValid = false;
            } else if (titleInput.value.length > 100) {
                showError(titleInput, 'Title must be less than 100 characters');
                isValid = false;
            }

            // Validate description
            if (descriptionInput.value.trim() === '') {
                showError(descriptionInput, 'Description is required');
                isValid = false;
            } else if (descriptionInput.value.length > 500) {
                showError(descriptionInput, 'Description must be less than 500 characters');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Error handling function
        function showError(element, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-400 text-sm mt-1 flex items-center';
            errorDiv.innerHTML = `
                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    ${message}
                `;

            // Remove existing error messages
            const existingError = element.parentNode.querySelector('.text-red-400');
            if (existingError) {
                existingError.remove();
            }

            element.parentNode.appendChild(errorDiv);
            element.classList.add('border-red-500');

            // Remove error after 3 seconds
            setTimeout(() => {
                errorDiv.remove();
                element.classList.remove('border-red-500');
            }, 3000);
        }

        // Initialize counters
        titleInput.dispatchEvent(new Event('input'));
        descriptionInput.dispatchEvent(new Event('input'));
    });
</script>
@endsection