@extends('layouts.admin')

@section('title', 'Edit Assessment')

@section('content')
        @if (session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-400">There were errors with your submission</h3>
                    <div class="mt-2 text-sm text-red-400">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-100 flex items-center gap-3">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Assessment
                    </h1>
                    <p class="mt-2 text-gray-400 text-lg">Update assessment details and settings</p>
                </div>
                <a href="{{ route('admin.assessments.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Back to Assessments
                </a>
            </div>
        </div>

        <!-- Edit Assessment Form -->
        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6">
            <form action="{{ route('admin.assessments.update', $assessment) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-8">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-200">Assessment Title <span class="text-red-400">*</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="title" id="title" 
                                value="{{ old('title', $assessment->title) }}" 
                                class="peer block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('title') border-red-500/50 focus:ring-red-500 @enderror" 
                                placeholder="Enter assessment title"
                                required
                                maxlength="255">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-gray-400 text-sm" x-data="{ count: $el.previousElementSibling.value.length }" x-text="count + '/255'" x-on:input.window="count = $event.target.value.length"></span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Give your assessment a clear, descriptive title</p>
                        @error('title')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-200">Description</label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="4" 
                                class="peer block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('description') border-red-500/50 focus:ring-red-500 @enderror" 
                                placeholder="Enter assessment description">{{ old('description', $assessment->description) }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-gray-400 text-sm" x-data="{ count: $el.previousElementSibling.value.length }" x-text="count + '/1000'" x-on:input.window="count = $event.target.value.length"></span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Provide detailed information about the assessment's purpose and content</p>
                        @error('description')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

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
                                    id="due_date" value="{{ old('due_date',$assessment->due_date) }}" />
                            </div>
                            @error('due_date')
                            <p class="mt-1 text-sm text-red-400 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                </svg>
                            </p>
                            @enderror
                        </div>
                    <!-- Duration -->
                    <div class="space-y-2">
                        <label for="duration" class="block text-sm font-medium text-gray-200">Duration (minutes) <span class="text-red-400">*</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" name="duration" id="duration" 
                                value="{{ old('duration', $assessment->duration) }}" 
                                class="block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('duration') border-red-500/50 focus:ring-red-500 @enderror" 
                                min="1" max="480"
                                placeholder="Enter duration in minutes"
                                required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400">min</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Set the time limit for completing the assessment (1-480 minutes)</p>
                        @error('duration')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Passing Score -->
                    <div class="space-y-2">
                        <label for="passing_score" class="block text-sm font-medium text-gray-200">Passing Score (%) <span class="text-red-400">*</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" name="passing_score" id="passing_score" 
                                value="{{ old('passing_score', $assessment->passing_score) }}" 
                                class="block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('passing_score') border-red-500/50 focus:ring-red-500 @enderror" 
                                min="0" max="100"
                                placeholder="Enter passing score percentage"
                                required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400">%</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Set the minimum percentage required to pass the assessment</p>
                        @error('passing_score')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Month -->
                    <!-- <div class="space-y-2">
                        <label for="month" class="block text-sm font-medium text-gray-200">Month <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="month" id="month" 
                                class="block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('month') border-red-500/50 focus:ring-red-500 @enderror appearance-none">
                                <option value="">Select Month</option>
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ old('month', $assessment->month) == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Select the month for the assessment</p>
                        @error('month')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div> -->

                    <!-- Year -->
                    <!-- <div class="space-y-2">
                        <label for="year" class="block text-sm font-medium text-gray-200">Year <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="year" id="year" 
                                class="block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('year') border-red-500/50 focus:ring-red-500 @enderror appearance-none">
                                <option value="">Select Year</option>
                                @foreach(range(date('Y'), date('Y') + 5) as $year)
                                    <option value="{{ $year }}" {{ old('year', $assessment->year) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Select the year for the assessment</p>
                        @error('year')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div> -->

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="is_published" class="block text-sm font-medium text-gray-200">Status <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="is_published" id="is_published" 
                                class="block w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-lg px-4 py-3 text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('is_published') border-red-500/50 focus:ring-red-500 @enderror appearance-none">
                                <option value="0" {{ old('is_published', $assessment->is_published) ? '' : 'selected' }}>Draft</option>
                                <option value="1" {{ old('is_published', $assessment->is_published) ? 'selected' : '' }}>Published</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-400">Set whether the assessment is ready to be taken by employees</p>
                        @error('is_published')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <button type="button" onclick="history.back()" class="inline-flex items-center px-4 py-2 border-2 border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-300 bg-transparent hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-slate-600 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
@endsection