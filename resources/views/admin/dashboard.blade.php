@extends('layouts.admin')

@section('content')
<!-- Welcome Section -->
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-100">Welcome back, {{ Auth::user()->name }}!</h1>
    <p class="mt-1 text-sm text-gray-400">Here's what's happening with your assessments today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 mb-6 xl:grid-cols-4">
    <!-- Total Assessments -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 hover:scale-[1.02] cursor-pointer border border-slate-700/50 group">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-200 group-hover:text-blue-700 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="flex-1 ml-4">
                <p class="text-sm font-medium text-gray-300 truncate">Total Assessments</p>
                <p class="mt-1 text-xl font-semibold text-gray-100">{{ $totalAssessments ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Active Employees -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 hover:scale-[1.02] cursor-pointer border border-slate-700/50 group">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 rounded-full bg-green-100 text-green-600 group-hover:bg-green-200 group-hover:text-green-700 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="flex-1 ml-4">
                <p class="text-sm font-medium text-gray-300 truncate">Active Employees</p>
                <p class="mt-1 text-xl font-semibold text-gray-100">{{ $activeEmployees ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Reviews -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 hover:scale-[1.02] cursor-pointer border border-slate-700/50 group">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 rounded-full bg-yellow-100 text-yellow-600 group-hover:bg-yellow-200 group-hover:text-yellow-700 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1 ml-4">
                <p class="text-sm font-medium text-gray-300 truncate">Pending Reviews</p>
                <p class="mt-1 text-xl font-semibold text-gray-100">{{ $pendingReviews ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Completion Rate -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 hover:scale-[1.02] cursor-pointer border border-slate-700/50 group">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-200 group-hover:text-indigo-700 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="flex-1 ml-4">
                <p class="text-sm font-medium text-gray-300 truncate">Completion Rate</p>
                <p class="mt-1 text-xl font-semibold text-gray-100">{{ $completionRate ?? '0%' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
    <!-- Recent Activity -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 border border-slate-700/50">
    <h2 class="text-lg font-medium text-gray-100 mb-4 flex items-center space-x-2">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span>Recent Activity</span>
</h2>
        <div class="flow-root">
        <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 hover:scale-[1.02] cursor-pointer border border-slate-700/50 group max-w-xl mx-auto">
    <ul>
        @forelse ($recentActivities as $activity)
            <li class="mb-3">
                <div class="p-3 bg-slate-900 rounded-lg border border-slate-700 group-hover:border-slate-500 transition-colors duration-300">
                    <div class="text-slate-200 font-semibold">
                        {{ $activity->user->name }}
                        <span class="text-slate-400 italic">submitted</span>
                        <span class="text-sky-400">“{{ $activity->assessment->title }}”</span>
                    </div>
                    <div class="text-slate-400 text-sm mt-1">
                        {{ $activity->created_at->format('M d, Y • h:i A') }}
                    </div>
                </div>
            </li>
        @empty
            <li class="text-slate-400 italic">No recent activities.</li>
        @endforelse
    </ul>
</div>


        </div>
    </div>

    <!-- Quick Actions -->
    <div class="p-4 bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-xl transition-all duration-300 border border-slate-700/50">
    <h2 class="text-lg font-medium text-gray-100 mb-4 flex items-center space-x-2">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
  </svg>
  <span>Quick Actions</span>
</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.assessments.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] hover:ring-2 hover:ring-indigo-500/50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Assessment
            </a>
            <a href="{{ route('admin.employees.create') }}"  class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-green-600 hover:bg-green-500 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] hover:ring-2 hover:ring-green-500/50 focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Add Employee
            </a>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] hover:ring-2 hover:ring-blue-500/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                View Reports
            </a>
            <a href="{{ route('admin.profile.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-purple-600 hover:bg-purple-500 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] hover:ring-2 hover:ring-purple-500/50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </div>
    </div>
</div>
@endsection