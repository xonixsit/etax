@extends('layouts.employee')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/60 backdrop-blur-md rounded-xl shadow-xl border border-gray-700/30 overflow-hidden">
            <div class="p-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-white mb-4 flex items-center gap-3">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Assessment Results
                    </h1>
                    <p class="text-gray-400 text-lg">View all your completed assessment results</p>
                </div>

                <!-- Results List -->
                <div class="space-y-6">
                    @forelse($responses as $response)
                        <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/30 hover:border-gray-500/30 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-white mb-2">{{ $response->assessment->title }}</h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Completed: {{ $response->completed_at->format('M d, Y h:i A') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold {{ $response->score >= $response->assessment->passing_score ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($response->score, 1) }}%
                                    </div>
                                    <span class="text-sm {{ $response->score >= $response->assessment->passing_score ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $response->score >= $response->assessment->passing_score ? 'Passed' : 'Failed' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('employee.assessments.results', $response->assessment) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition-colors duration-200">
                                    View Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-400">No completed assessments</h3>
                            <p class="mt-1 text-sm text-gray-500">You haven't completed any assessments yet.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($responses->hasPages())
                        <div class="mt-6">
                            {{ $responses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection