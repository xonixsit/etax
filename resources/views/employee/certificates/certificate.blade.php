@extends('layouts.employee')

@section('title', 'Assessment Completed')

@section('content')

<div class="bg-gradient-to-br from-gray-900 via-indigo-900 to-gray-800 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.01]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-purple-800 text-white py-6 px-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">ETax Planner</h1>
                <p class="text-sm opacity-90">Professional Certification Program</p>
            </div>
            <div class="h-16 w-16 rounded-full bg-white text-blue-700 flex items-center justify-center font-bold text-lg">
                ETP
            </div>
        </div>

        <!-- Body -->
        <div class="p-10 space-y-8">
            <!-- Title -->
            <div class="text-center">
                <div class="mb-4">
                    <span class="inline-block bg-green-100 text-green-800 px-6 py-2 rounded-full text-lg font-semibold">
                        🎉 CONGRATULATIONS! 🎉
                    </span>
                </div>
                <h2 class="text-2xl font-semibold uppercase tracking-wide text-gray-800">Certificate of Achievement</h2>
                <p class="text-gray-500 mt-2 italic">This certifies that</p>
            </div>

            <!-- Recipient Name -->
            <div class="text-center">
                <h3 class="text-4xl font-extrabold text-gray-900">{{ $employeeName ?? 'John Doe' }}</h3>
                <p class="mt-2 text-gray-600">has successfully passed and is</p>
                <div class="my-3">
                    <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-lg font-bold text-xl">
                        QUALIFIED
                    </span>
                </div>
                <p class="text-gray-600">in the</p>
                <p class="font-medium text-lg text-gray-800">{{ $assessmentTitle ?? 'Human-Centered Design Assessment' }}</p>
            </div>

            <!-- Score -->
            @if(isset($score))
            <div class="text-center">
                <div class="inline-block bg-gradient-to-r from-green-400 to-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
                    <span class="font-bold text-lg">Achieved Score: {{ $score }}%</span>
                    <div class="text-sm opacity-90">Passing Score Required: {{ $assessment->passing_score ?? 70 }}%</div>
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="text-center max-w-2xl mx-auto">
                <p class="text-gray-700 leading-relaxed">
                    This certification confirms that the individual has successfully demonstrated proficiency and competency in tax planning principles and practices, meeting all ETax Planner professional standards and qualifying criteria.
                </p>
                <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                    <p class="text-yellow-800 font-medium">
                        ✓ Assessment Completed Successfully<br>
                        ✓ Minimum Passing Score Achieved<br>
                        ✓ Qualified for ETax Planner Professional Recognition
                    </p>
                </div>
            </div>

            <!-- Signature Section -->
            <div class="flex flex-wrap justify-between items-start mt-6 text-sm text-gray-700">
                <div class="space-y-1">
                    <p class="font-semibold">Date Issued</p>
                    <p>{{ $dateIssued ?? now()->format('F j, Y') }}</p>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Assessment ID</p>
                    <p>{{ $assessmentId ?? 'EAP-2025-001' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Signature</p>
                    <p>_________________________</p>
                    <p class="text-xs text-gray-500">Authorized Signatory</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t border-gray-200 text-center text-xs text-gray-500 mt-8">
                &copy; {{ date('Y') }} ETax Planner. All rights reserved.
                <p class="mt-1">Authorized by ETax Planner Professional Development Program</p>
            </div>
        </div>
    </div>

    <!-- Optional Print Button -->
    <div class="mt-8 no-print text-center">
        <button onclick="window.print()" class="px-6 py-2 bg-white text-blue-700 rounded-md shadow hover:shadow-lg transition">
            Print Certificate
        </button>
    </div>
</div>

@endsection