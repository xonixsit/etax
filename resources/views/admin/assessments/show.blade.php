@extends('layouts.admin')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">
    <!-- Main Container -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <header class="mb-8">
            <div class="mb-6">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div class="flex items-center gap-3 mb-6">
                            <!-- Icon -->
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>

                            <!-- Title -->
                            <h1 class="text-2xl font-bold text-white">{{ $assessment->title }}</h1>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <!-- Edit Assessment Button -->
                            <a href="{{ route('admin.assessments.edit', $assessment) }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-colors text-sm whitespace-nowrap">
                                Edit Assessment
                            </a>

                            <!-- Add Question Button -->
                            <a href="{{ route('admin.assessments.questions.create', $assessment) }}"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Question
                            </a>
                        </div>
                    </div>

                    <!-- Chips-style Stats -->
                    <div class="flex flex-wrap gap-3">
                        <!-- Schedule -->
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $assessment->due_date }}
                        </div>

                        <!-- Duration -->
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $assessment->duration }} min
                        </div>

                        <!-- Passing Score -->
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $assessment->passing_score }}%
                        </div>

                        <!-- Status -->
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium 
        {{ $assessment->is_published ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            <svg class="-ml-1 mr-1.5 h-2 w-2 {{ $assessment->is_published ? 'text-green-400' : 'text-yellow-400' }}" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"></circle>
                            </svg>
                            {{ $assessment->is_published ? 'Published' : 'Draft' }}
                        </div>
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-800/50 text-gray-300 group-hover:bg-gray-700 transition-colors">
                            <svg class="-ml-1 mr-1.5 h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-sm">Total Questions: {{ $assessment->questions->count() }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </header>



        <!-- Description Section -->
        <!-- <section class="mb-8">
            <h3 class="text-lg font-semibold mb-3 text-gray-300">Description</h3>
            <p class="text-gray-400 leading-relaxed">{{ $assessment->description }}</p>
        </section> -->

        <!-- Questions Section -->
        <section>
            <!-- <div class="flex justify-between items-center mb-6"> -->
            <!-- <h2 class="text-xl font-bold text-white">Questions</h2> -->
            <!-- <span class="text-sm text-gray-400">Total Questions: {{ $assessment->questions->count() }}</span>
            </div> -->

            @if($assessment->questions->count() > 0)
            <div class="space-y-6 max-h-[800px] overflow-y-auto pr-2 custom-scrollbar">
                @foreach($assessment->questions as $question)
                <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700 hover:border-gray-600 transition-all duration-200 shadow-sm hover:shadow-md">
                    <div class="flex flex-col space-y-4">
                        <!-- <div class="flex items-center gap-3"> -->
                        <!-- <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-700 text-white font-semibold shadow-inner">
                      {{ $loop->iteration }}
                    </span> -->
                        <!-- <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-medium">
                      {{ $question->points }} points
                    </span> -->
                        <!-- </div> -->

                        <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg border border-gray-700 hover:border-gray-600 transition-all duration-200">
                            <!-- Left-aligned content: Number + Question Text + Type Badge -->
                            <div class="flex items-center gap-3 overflow-hidden">
                                <!-- Question Number -->
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-700 text-white font-semibold shadow-inner flex-shrink-0">
                                    {{ $loop->iteration }}
                                </span>

                                <!-- Question Text and Type Badge -->
                                <div class="overflow-hidden">
                                    <p class="text-white font-medium text-lg truncate">{{ $question->text }}</p>
                                    <span class="mt-1 inline-block px-2 py-0.5 rounded-full text-xs font-medium 
        {{ $question->type === 'multiple_choice' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Right-aligned Actions -->
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.assessments.questions.edit', [$assessment, $question]) }}"
                                    class="flex items-center gap-1 px-3 py-1 rounded hover:bg-gray-700 transition-colors group">
                                    <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="text-sm text-blue-400 group-hover:text-blue-300">Edit</span>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.assessments.questions.destroy', [$assessment, $question]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this question?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-1 px-3 py-1 rounded hover:bg-gray-700 transition-colors group">
                                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M10 14h4"></path>
                                        </svg>
                                        <span class="text-sm text-red-400 group-hover:text-red-300">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- @if($question->type === 'multiple_choice' && $question->options) -->
                        <!-- <div class="pl-4 space-y-2">
                      @foreach($question->options as $index => $option)
                        <div class="flex items-center gap-3 p-2 rounded bg-gray-800/50 hover:bg-gray-800 transition-colors">
                          <span class="w-6 h-6 flex items-center justify-center rounded-full border border-gray-600 text-gray-400 text-sm group-hover:border-gray-500 group-hover:text-gray-300">
                            {{ chr(65 + $index) }}
                          </span>
                          <span class="text-gray-300">{{ $option }}</span>
                        </div>
                      @endforeach
                    </div> -->
                        <!-- @endif -->

                        <!-- <div class="flex justify-end space-x-2 mt-2 pt-2 border-t border-gray-700">
                    <a href="{{ route('admin.assessments.questions.edit', [$assessment, $question]) }}" class="text-blue-400 hover:text-blue-300 text-sm transition-colors">Edit</a>
                    <form action="{{ route('admin.assessments.questions.destroy', [$assessment, $question]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition-colors">Delete</button>
                    </form>
                  </div> -->
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-gray-800/30 rounded-lg border border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="mt-4 text-gray-400 text-lg">No questions added yet.</p>
                <a href="{{ route('admin.assessments.questions.create', $assessment) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 hover:scale-105">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Your First Question
                </a>
            </div>
            @endif
        </section>

    </div>
</div>
@endsection