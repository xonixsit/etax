@extends('layouts.admin')
@section('content')
<div class="w-full bg-gray-800 rounded-lg shadow-md p-6 mb-8" role="region" aria-labelledby="feedback-heading">

<!--Feed back by user--filter--search-->

    <h2 id="feedback-heading" class="text-2xl font-bold text-white mb-6">Feedback</h2>
    <!-- Success Status -->
    @if (session('status'))
        <div class="bg-green-500/20 text-green-400 p-3 mb-6 rounded-md border border-green-500/30" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Feedback List -->
    @if ($feedback->count() > 0)
        <ul class="space-y-4">
            @foreach ($feedback as $item)
                <li class="bg-gray-700/50 rounded-lg p-4 border border-gray-600 hover:border-gray-500 transition-all duration-200">
                    <div class="flex items-start gap-3">
                        <!-- User Avatar or Icon (optional) -->
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 8a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a4 4 0 10-8 0 4 4 0 008 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- Feedback Content -->
                        <div class="flex-1">
                            <strong class="text-blue-400">{{ $item->user->name }}</strong>
                            <p class="mt-1 text-gray-300">{{ $item->feedback_text }}</p>
                            <!-- Feedback Date -->
                            <div class="mt-2 text-sm text-gray-500">
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $feedback->links() }}
        </div>
    @else
        <div class="text-center py-10">
            <svg class="mx-auto h-10 w-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h.01M12 12h.01M15 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-2 text-gray-400">No feedback available yet.</p>
        </div>
    @endif
</div>
@endsection