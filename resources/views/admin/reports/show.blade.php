@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Page Header with Back Button -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700/50 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">Assessment Report Details</h1>
        </div>
    </div>

    <!-- Assessment and Employee Info -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/50 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-300 mb-4">Assessment Information</h3>
                <div class="space-y-3">
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Title:</span> {{ $response->assessment->title }}</p>
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Duration:</span> {{ $response->assessment->duration }} minutes</p>
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Passing Score:</span> {{ $response->assessment->passing_score }}%</p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-300 mb-4">Employee Information</h3>
                <div class="space-y-3">
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Name:</span> {{ $response->user->name }}</p>
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Email:</span> {{ $response->user->email }}</p>
                    <p class="text-gray-300"><span class="font-medium text-gray-200">Department:</span> {{ $response->user->department }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Score Summary -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/50 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-300 mb-4">Assessment Results</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-700/50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-400 mb-1">Final Score</p>
                <p class="text-2xl font-bold {{ $response->score >= $response->assessment->passing_score ? 'text-green-400' : 'text-red-400' }}">
                    {{ $response->score }}%
                </p>
            </div>
            <div class="bg-gray-700/50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-400 mb-1">Status</p>
                <p class="text-2xl font-bold {{ $response->score >= $response->assessment->passing_score ? 'text-green-400' : 'text-red-400' }}">
                    {{ $response->score >= $response->assessment->passing_score ? 'Passed' : 'Failed' }}
                </p>
            </div>
            <div class="bg-gray-700/50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-400 mb-1">Completion Time</p>
                <p class="text-2xl font-bold text-blue-400">
                    @if($response->completed_at)
                        {{ $response->completed_at->diffForHumans($response->started_at, true) }}
                    @else
                        Not completed
                    @endif
                </p>
            </div>
            <div class="bg-gray-700/50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-400 mb-1">Submitted At</p>
                <p class="text-2xl font-bold text-gray-300">
                    {{ $response->completed_at ? $response->completed_at->format('Y-m-d H:i') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Questions and Answers -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/50 p-6">
        <h3 class="text-lg font-semibold text-gray-300 mb-6">Questions & Answers</h3>
        <div class="space-y-6">
            @foreach($response->answers as $answer)
                <div class="bg-gray-700/50 rounded-lg p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 text-white font-semibold">{{ $loop->iteration }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $answer->question->type === 'multiple_choice' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                                    {{ ucfirst(str_replace('_', ' ', $answer->question->type)) }}
                                </span>
                            </div>
                            <p class="text-gray-200 text-lg mb-4">{{ $answer->question->text }}</p>
                            
                            @if($answer->question->type === 'multiple_choice')
                                <div class="space-y-2 pl-4">
                                    @php
                                        $userAnswers = json_decode($answer->answer, true) ?? [];
                                        $correctIndices = array_map('intval', explode(',', $answer->question->correct_answer));
                                    @endphp
                                    @foreach($answer->question->options as $index => $option)
                                        <div class="flex items-center gap-3 p-2 rounded-lg {{ in_array($option, $userAnswers) ? 'bg-gray-600/50' : 'bg-gray-700/30' }}">
                                            <span class="w-6 h-6 flex items-center justify-center rounded-full border {{ in_array($index, $correctIndices) ? 'border-green-500 text-green-500' : 'border-gray-500 text-gray-500' }}">{{ chr(65 + $index) }}</span>
                                            <span class="{{ in_array($index, $correctIndices) ? 'text-green-400' : 'text-gray-400' }}">{{ $option }}</span>
                                            @if(in_array($option, $userAnswers))
                                                <!-- <span class="ml-auto text-sm {{ $answer->is_correct ? 'text-green-400' : 'text-red-400' }}">
                                                    Selected
                                                </span> -->
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($answer->question->type === 'single_selection')
                                <div class="space-y-2 pl-4">
                                    @foreach($answer->question->options as $index => $option)
                                        <div class="flex items-center gap-3 p-2 rounded-lg {{ $option == $answer->answer ? 'bg-gray-600/50' : 'bg-gray-700/30' }}">
                                            <span class="w-6 h-6 flex items-center justify-center rounded-full border {{ $index == $answer->question->correct_answer ? 'border-green-500 text-green-500' : 'border-gray-500 text-gray-500' }}">{{ chr(65 + $index) }}</span>
                                            <span class="{{ $index == $answer->question->correct_answer ? 'text-green-400' : 'text-gray-400' }}">{{ $option }}</span>
                                            @if($option == $answer->answer)
                                                <span class="ml-auto text-sm {{ $answer->is_correct ? 'text-green-400' : 'text-red-400' }}">
                                                    Selected
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="pl-4 mt-2">
                                    <p class="text-gray-400">Answer:</p>
                                    <p class="text-gray-300 mt-2">{{ $answer->answer }}</p>
                                    @if($answer->question->type === 'paragraph')
                                        <div class="mt-4 flex items-center gap-4">
                                            <p class="text-gray-400">Review Status:</p>
                                            @if($answer->is_correct === null)
                                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">Pending Review</span>
                                                <form action="{{ route('admin.reports.review-answer', $answer->id) }}" method="POST" class="inline-flex gap-2">
                                                    @csrf
                                                    <button type="submit" name="status" value="correct" class="px-3 py-1 rounded-lg text-sm font-medium bg-green-500/20 text-green-400 hover:bg-green-500/30 transition-colors duration-200">
                                                        Mark as Correct
                                                    </button>
                                                    <button type="submit" name="status" value="incorrect" class="px-3 py-1 rounded-lg text-sm font-medium bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors duration-200">
                                                        Mark as Incorrect
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $answer->is_correct ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                                    {{ $answer->is_correct ? 'Marked Correct' : 'Marked Incorrect' }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 rounded-full
                            @if($answer->is_correct === true) bg-green-500/20 text-green-500
                            @elseif($answer->is_correct === false) bg-red-500/20 text-red-500
                            @else bg-yellow-500/20 text-yellow-500 @endif">
                            @if($answer->is_correct === true)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif($answer->is_correct === false)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection