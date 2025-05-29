@extends('layouts.employee')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-400">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-lg rounded-xl shadow-xl overflow-hidden border border-gray-700/30">
            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold mb-3 text-white">{{ $assessment->title }}</h2>
                    <p class="text-gray-300 text-lg">{{ $assessment->description }}</p>
                </div>

                <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl p-6 mb-8 border border-gray-600/30 transform transition-all duration-300 hover:border-gray-500/30">
                    <h3 class="text-xl font-semibold mb-6 text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Assessment Details
                                <span class="px-2.5 py-0.5 inline-flex text-md leading-5 font-semibold rounded-full {{ $assessment->getIsExpiredAttribute()? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                     {{ $assessment->getIsExpiredAttribute() ? 'Expired' : 'Active' }}
                                </span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <p class="text-gray-300"><span class="font-medium text-gray-200">Duration:</span> {{ $assessment->duration }} minutes</p>
                            <p class="text-gray-300"><span class="font-medium text-gray-200">Total Questions:</span> {{ $assessment->questions->count() }}</p>
                            @if($assessment->passing_score)
                                <p class="text-gray-300"><span class="font-medium text-gray-200">Passing Score:</span> {{ $assessment->passing_score }}%</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-900/30 backdrop-blur-sm rounded-xl p-6 mb-8 border border-indigo-500/20 transform transition-all duration-300 hover:border-indigo-400/30">
                    <h3 class="text-xl font-semibold mb-6 text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Important Instructions
                    </h3>
                    <ul class="list-none space-y-4 text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Please ensure you have a stable internet connection before starting the assessment.
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Once started, the timer cannot be paused.
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Answer all questions to the best of your ability.
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            You can review and change your answers before final submission.
                        </li>
                        @if($assessment->passing_score)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                You need to score at least {{ $assessment->passing_score }}% to pass this assessment.
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="flex justify-end gap-4">
                    @if($response && $response->status === 'completed')
                        <a href="{{ route('employee.assessments.results', $assessment) }}"
                           class="group relative inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium text-sm rounded-xl overflow-hidden transition-all duration-300 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-gray-800">
                            <span class="absolute inset-0 w-full h-full transition-all duration-300 transform translate-x-0 group-hover:translate-x-full bg-gradient-to-r from-green-600/20 to-emerald-600/20"></span>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            View Results
                        </a>
                    @else

                    <!-- {{$assessment->getIsExpiredAttribute()}} -->
                            @if(!$assessment->getIsExpiredAttribute())
                            
                            <button type="button" 
                                    id="start-assessment-btn"
                                    class="group relative inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium text-sm rounded-xl overflow-hidden transition-all duration-300 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-800">
                                <span class="absolute inset-0 w-full h-full transition-all duration-300 transform translate-x-0 group-hover:translate-x-full bg-gradient-to-r from-blue-600/20 to-indigo-600/20"></span>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Start Assessment
                            </button>
                            @else
                                <span class="px-2.5 py-0.5 inline-flex text-md leading-5 font-semibold rounded-full {{ $assessment->getIsExpiredAttribute()? 'bg-red-100 text-red-800' : '' }}">
                                {{ $assessment->getIsExpiredAttribute() ? 'Expired' : '' }}
                                </span>
                            @endif
                        

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startButton = document.getElementById('start-assessment-btn');
    console.log("startButton")
    if (startButton) {
        startButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to start this assessment? Once started, the timer cannot be paused.')) {
                window.location.href = '{{ route("employee.assessments.take", $assessment) }}';
            }
        });
    }
});
</script>
@endpush
@endsection