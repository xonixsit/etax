@extends('layouts.employee')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/60 backdrop-blur-md rounded-xl shadow-xl border border-gray-700/30 overflow-hidden">
            <div class="p-8">
                <!-- Assessment Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-white mb-4 flex items-center gap-3">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $assessment->title }}
                    </h1>
                    <p class="text-gray-400 text-lg">Review your assessment performance and detailed feedback</p>
                </div>

                <!-- Score Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <!-- Overall Score -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/30 hover:border-gray-500/30 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-500/10 rounded-lg">
                                <svg class="w-8 h-8 text-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-200">Overall Score</h3>
                                <p class="text-2xl font-bold text-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-400">{{ number_format($response->score, 1) }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/30 hover:border-gray-500/30 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-500/10 rounded-lg">
                                <svg class="w-8 h-8 text-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $response->score >= $assessment->passing_score ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-200">Status</h3>
                                <p class="text-2xl font-bold text-{{ $response->score >= $assessment->passing_score ? 'green' : 'red' }}-400">
                                    {{ $response->score >= $assessment->passing_score ? 'Passed' : 'Failed' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Required Score -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/30 hover:border-gray-500/30 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-500/10 rounded-lg">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-200">Required Score</h3>
                                <p class="text-2xl font-bold text-blue-400">{{ $assessment->passing_score }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Results -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Question Details
                    </h2>

                    @foreach($response->answers as $answer)
                        <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/30 hover:border-gray-500/30 transition-all duration-300">
                            <div class="mb-4">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <span class="bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-lg">Question {{ $loop->iteration }}</span>
                                </h3>
                                <p class="text-gray-300">{{ $answer->question->text }}</p>
                            </div>

                            <div class="mt-4 space-y-4">
                                <!-- Your Answer -->
                                <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-600/30">
                                    <h4 class="text-sm font-medium text-gray-400 mb-2">Your Answer:</h4>
                                    <p class="text-gray-200">{{ $answer->answer }}</p>
                                </div>

                                <!-- Feedback Section -->
                                <div class="flex items-center gap-2">
                                    @if($answer->is_correct)
                                        <div class="flex items-center gap-2 text-green-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-medium">Correct</span>
                                        </div>
                                    @else
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2 text-red-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-medium">Incorrect</span>
                                            </div>
                                            <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-600/30 mt-2">
                                                <h4 class="text-sm font-medium text-gray-400 mb-2">Correct Answer:</h4>
                                                <p class="text-green-400">{{ $answer->question->correct_answer }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('employee.assessments.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-500 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 transform transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Assessments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection