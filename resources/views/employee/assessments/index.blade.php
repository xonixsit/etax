@extends('layouts.employee')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-lg rounded-lg shadow-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Available Assessments
            </h1>
        </div>

        @if($assessments->isEmpty())
        <p class="text-gray-400">No assessments are currently available.</p>
        @else
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Questions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Passing Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($assessments as $assessment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $assessment->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $assessment->duration }} minutes</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $assessment->questions_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $assessment->passing_score }}%</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">

                        @if($assessment->status === 'completed')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Completed
                        </span>
                        @elseif($assessment->status === 'in_progress')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            In Progress
                        </span>@elseif($assessment->status === 'pending_review')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Pending Review
                        </span>
                        @elseif($assessment->status === 'timed_out')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Timed Out
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Not Started
                        </span>
                        @endif

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex flex-col">
                            <span class="text-gray-300">{{ \Carbon\Carbon::parse($assessment->due_date)->format('M d, Y') }}</span>

                            @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($assessment->due_date)))
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Expired
                            </span>
                            @else
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Active
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($assessment->status === 'completed')
                        <a title="Results" href="{{ route('employee.assessments.results', $assessment) }}" class="text-blue-400 hover:text-blue-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-6a1 1 0 00-2 0v6a1 1 0 002 0zm4 0v-4a1 1 0 00-2 0v4a1 1 0 002 0zm4 0v-10a1 1 0 00-2 0v10a1 1 0 002 0zM5 20h14" />
                            </svg>

                        </a>
                        @elseif($assessment->status === 'in_progress')
                            @if(!$assessment->getIsExpiredAttribute())
                                 <a href="{{ route('employee.assessments.show', $assessment) }}" class="text-blue-400 hover:text-blue-500">
                                    Resume
                                 </a>
                            @else
                            <span title="Due date expired" class="text-gray-500 cursor-not-allowed group">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11a1 1 0 100-2 1 1 0 000 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.083 10.5H13.917A1.417 1.417 0 0115.333 12v4.167A1.417 1.417 0 0113.917 17.583H10.083A1.417 1.417 0 018.667 16.167V12a1.417 1.417 0 011.416-1.417z" />
                            </svg>
                        </span>
                        @endif
                                
                        @elseif($assessment->status === 'pending_review')
                        <!-- <a href="{{ route('employee.assessments.show', $assessment) }}" class="text-blue-400 hover:text-blue-500">Review</a> -->
                        @else
                        @if(!$assessment->getIsExpiredAttribute())
                        <!-- Start Assessment -->
                        <a title="Start Assessment" href="{{ route('employee.assessments.show', $assessment) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Start
                            <svg class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                <path d="M6.5 5.5v9l7-4.5-7-4.5z" />
                            </svg>
                        </a>
                        @else
                        <!-- Due Date Expired -->
                        <span title="Due date expired" class="text-gray-500 cursor-not-allowed group">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11a1 1 0 100-2 1 1 0 000 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.083 10.5H13.917A1.417 1.417 0 0115.333 12v4.167A1.417 1.417 0 0113.917 17.583H10.083A1.417 1.417 0 018.667 16.167V12a1.417 1.417 0 011.416-1.417z" />
                            </svg>
                        </span>
                        @endif
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection