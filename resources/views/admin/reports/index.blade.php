@extends('layouts.admin')

@section('title', 'Assessment Reports')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Page Header with Description -->
    <div class="mb-12" aria-labelledby="reports-heading" aria-describedby="reports-description">
        <div class="flex items-center gap-3">
            <!-- Icon -->
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>

            <!-- Heading -->
            <h1 id="reports-heading" class="text-3xl font-bold text-gray-100">Assessment Reports</h1>
        </div>

        <!-- Description -->
        <p id="reports-description" class="mt-2 text-gray-400 max-w-2xl">
            View and analyze employee assessment results, filter by date range, employee, or assessment type.
        </p>
    </div>
    <!-- Filters -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/50 p-8 mb-8 transition-all duration-300 hover:bg-gray-800/60">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-semibold text-gray-200 mb-2">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                    class="block w-full rounded-lg border-2 border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 hover:border-indigo-400 transition-all duration-200 cursor-pointer px-4 py-2.5"
                    title="Select start date for filtering assessment reports">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-semibold text-gray-200 mb-2">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                    class="block w-full rounded-lg border-2 border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 hover:border-indigo-400 transition-all duration-200 cursor-pointer px-4 py-2.5"
                    title="Select end date for filtering assessment reports">
            </div>

            <div>
                <label for="user_id" class="block text-sm font-semibold text-gray-200 mb-2">Employee</label>
                <select name="user_id" id="user_id"
                    class="block w-full rounded-lg border-2 border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 hover:border-indigo-400 transition-all duration-200 cursor-pointer px-4 py-2.5"
                    title="Filter reports by employee">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('user_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="assessment_id" class="block text-sm font-semibold text-gray-200 mb-2">Assessment</label>
                <select name="assessment_id" id="assessment_id"
                    class="block w-full rounded-lg border-2 border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 hover:border-indigo-400 transition-all duration-200 cursor-pointer px-4 py-2.5"
                    title="Filter reports by assessment type">
                    <option value="">All Assessments</option>
                    @foreach($assessments as $assessment)
                    <option value="{{ $assessment->id }}" {{ request('assessment_id') == $assessment->id ? 'selected' : '' }}>
                        {{ $assessment->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-full flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-4 border-t border-gray-700">
                <button type="submit" class="inline-flex justify-center items-center gap-2 py-3 px-6 text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Apply Filters
                </button>

                <button type="button" onclick="exportReports()" class="inline-flex justify-center items-center gap-2 py-3 px-6 text-sm font-semibold rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Reports
                </button>
            </div>
        </form>
    </div>

    <!-- Results Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/50 overflow-hidden transition-all duration-300 hover:bg-gray-800/60">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700/50 backdrop-blur-sm border-b border-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Assessment</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Employee</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Score</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Submitted At</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800/30 backdrop-blur-sm divide-y divide-gray-700">
                @forelse($responses as $response)
                <tr
                    onclick="window.location.href='{{ route('admin.reports.show', ['response' => $response->id]) }}'"
                    class="cursor-pointer hover:bg-gray-700/50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $response->assessment->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $response->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $response->score }}%</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                        $statusClasses = [
                        'completed' => 'bg-green-100 text-green-800',
                        'pending_review' => 'bg-blue-100 text-blue-800',
                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                        'timed_out' => 'bg-red-100 text-red-800'
                        ][$response->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full transition-all duration-300 {{ $statusClasses }}">
                            {{ str_replace('_', ' ', ucfirst($response->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $response->created_at->format('Y-m-d H:i') }}</td>

                    <td class="text-center">
                        <form action="{{ route('admin.reports.complete', ['response' => $response->id, 'user' => $response->user->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!--only if it is not completed -->
                            <!--tool tip for button-->
                            @if($response->status != 'completed')
                            <button type="button" title="Mark as complete"  
                                class="inline-flex justify-center items-center gap-2 py-3 px-6 text-sm font-semibold rounded-lg text-white bg-green-600 cursor-default transition-all duration-300 w-full sm:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            @else
                            <div class='text-center inline-flex justify-center items-center'>    <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
</svg></div>
                            @endif
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No assessment responses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-5 bg-gray-800/50 backdrop-blur-sm border-t border-gray-700">
            {{ $responses->links() }}
        </div>
    </div>

    @endsection