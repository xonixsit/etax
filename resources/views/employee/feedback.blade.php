@extends('layouts.employee')

@section('title', 'Employee Dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
<div class="mb-8 flex items-center gap-3">
    <!-- Icon -->
    <svg class="w-8 h-8 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
    </svg>

    <!-- Text Content -->
    <div class="flex flex-col">
        <h2 class="text-3xl font-bold text-gray-100">Employee Feedback</h2>
        <p class="text-gray-400 text-sm mt-1">Provide feedback on your performance and receive feedback from your supervisor.</p>
    </div>
</div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60"> 
            <!-- <h3 class="text-lg font-semibold text-gray-100 mb-4">Provide Feedback</h3> -->
            <form action="{{ route('employee.feedback.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="feedback" class="block text-sm font-medium text-gray-400">Feedback</label>
                    <textarea id="feedback" name="feedback" rows="4" class="mt-1 p-2 w-full border rounded-md bg-gray-700 text-gray-200 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md">Submit Feedback</button>
                </div>
            </form>
        </div>
        <!-- <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <h3 class="text-lg font-semibold text-gray-100 mb-4">View Feedback</h3>
            @if(count($feedbacks) > 0)
                @foreach($feedbacks as $feedback)
                    <div class="mb-4">
                        <p class="text-gray-400">{{ $feedback->feedback_text }}</p>
                        <p class="text-sm text-gray-400">{{ $feedback->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-400">No feedback available.</p>
            @endif
        </div> -->
    </div>
</div>
@endsection
