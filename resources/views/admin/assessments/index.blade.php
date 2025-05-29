@extends('layouts.admin')

@section('title', 'Assessments')

@section('content')

<!-- Main Content -->
<main class="flex-1 px-6 py-6 space-y-4">
    @if (session('success'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-400">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="mb-4">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-100 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Assessments
                </h1>
                <p class="mt-2 text-gray-400 text-lg">Manage and monitor all assessments</p>
            </div>
            <a href="{{ route('admin.assessments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Assessment
            </a>
        </div>
    </div>

    <!-- Assessments Table -->
    <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 overflow-hidden">
        @if($assessments->isEmpty())
        <div class="p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-300">No assessments found</h3>
            <p class="mt-2 text-sm text-gray-400">Get started by creating a new assessment.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead>
                    <tr class="bg-slate-900/30">
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Duration</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Questions</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Passing Score</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($assessments as $assessment)
                    <tr class="hover:bg-slate-700/10 transition-colors duration-200">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-200">{{ $assessment->title }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $assessment->duration }} minutes</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $assessment->questions_count }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $assessment->passing_score }}%</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $assessment->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $assessment->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">
                            <!--add expired--if crossed due date is past from today-->
                            <span class="px-2.5 py-0.5 inline-flex text-md leading-5 font-semibold rounded-full {{ $assessment->getIsExpiredAttribute()? 'bg-red-100 text-red-800' : '' }}">
                                {{ $assessment->getIsExpiredAttribute() ? 'Expired' : $assessment->due_date }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300 text-right space-x-3">
                            <div class="flex space-x-2 items-center">

                                <a href="{{ route('admin.assessments.show', $assessment) }}" class="text-indigo-400 hover:text-indigo-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-blue-500 hover:text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                </a>
                                <a href="{{ route('admin.assessments.questions.create', $assessment) }}" class="text-green-400 hover:text-green-500 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.78 9.78 0 01-4-.835L3 20l1.5-3.5A8.98 8.98 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>

                                </a>
                                <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-blue-400 hover:text-blue-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-yellow-500 hover:text-yellow-700" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5h6a2 2 0 012 2v6m-1.5-4.5L7 20H4v-3L16.5 6.5z" />
                                    </svg>

                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3.5 border-t border-slate-700/50">
            {{ $assessments->links() }}
        </div>
        @endif
    </div>
</main>
@endsection