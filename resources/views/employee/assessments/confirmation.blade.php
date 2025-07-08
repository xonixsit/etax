@extends('layouts.employee')

@section('content')
<div class="container mx-auto px-4 py-12 md:py-16 lg:py-20 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-xl">
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-8 text-center">Assessment Confirmation</h1>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg relative mb-6 shadow-sm" role="alert">
            <span class="block sm:inline text-lg font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 md:p-10 border border-gray-200 dark:border-gray-700">
        <p class="text-xl text-gray-800 dark:text-gray-200 mb-6 leading-relaxed">Thank you for completing the assessment, <strong class="text-blue-600 dark:text-blue-400">{{ Auth::user()->name }}</strong>!</p>

        @if ($response->status === \App\Models\AssessmentResponse::STATUS_PENDING_REVIEW)
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">Your assessment for <strong class="text-indigo-600 dark:text-indigo-400">{{ $assessment->title }}</strong> has been submitted and is currently <strong class="text-yellow-600 dark:text-yellow-400">pending review</strong>.</p>
            <p class="text-lg text-gray-700 dark:text-gray-300">You will be notified once the results are available.</p>
        @elseif ($response->status === \App\Models\AssessmentResponse::STATUS_COMPLETED)
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">Your assessment for <strong class="text-indigo-600 dark:text-indigo-400">{{ $assessment->title }}</strong> has been successfully <strong class="text-green-600 dark:text-green-400">completed</strong>.</p>
            <p class="text-lg text-gray-700 dark:text-gray-300">You can view your results <a href="{{ route('employee.assessments.results', $assessment->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">here</a>.</p>
        @else
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">Your assessment for <strong class="text-indigo-600 dark:text-indigo-400">{{ $assessment->title }}</strong> has been submitted.</p>
            <p class="text-lg text-gray-700 dark:text-gray-300">We will process your submission shortly.</p>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('employee.assessments.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Back to Assessments
            </a>
        </div>
    </div>
</div>
@endsection