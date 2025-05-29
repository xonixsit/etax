@extends('layouts.employee')

@section('title', 'Employee Dashboard')

@section('content')
<main class="flex-1 px-6 py-6 space-y-4">
    <!-- Welcome Section -->
    <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6">
        <h1 class="text-2xl font-semibold text-gray-100">Welcome back, {{ Auth::guard('employee')->user()->name }}!</h1>
        <p class="mt-2 text-gray-400">Access your assessments and view your progress.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-200">Pending Assessments</h3>
                    <p class="text-2xl font-semibold text-gray-100">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-200">Completed</h3>
                    <p class="text-2xl font-semibold text-gray-100">{{ $completedCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-200">Average Score</h3>
                    <p class="text-2xl font-semibold text-gray-100">{{ $averageScore }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Assessments -->
    <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-100">Recent Assessments</h2>
            <p class="mt-1 text-sm text-gray-400">Your latest assessment activities</p>
        </div>

        <div class="border-t border-slate-700/50 divide-y divide-slate-700/50">
            @forelse($recentAssessments as $assessment)
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-200">{{ $assessment['assessment']->title }}</h3>
                        @if($assessment['started_at'])
                            <p class="text-sm text-gray-400">Started {{ $assessment['started_at']->diffForHumans() }}</p>
                        @else
                            <p class="text-sm text-gray-400">Assigned</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($assessment['status'] === 'completed')
                            <span class="px-3 py-1 text-sm rounded-full bg-green-500/10 text-green-400">Completed</span>
                        @elseif($assessment['status'] === 'in_progress')
                            <span class="px-3 py-1 text-sm rounded-full bg-yellow-500/10 text-yellow-400">In Progress</span>
                        @else
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-500/10 text-blue-400">Not Started</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-400">
                    <p>No assessments available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</main>
@endsection