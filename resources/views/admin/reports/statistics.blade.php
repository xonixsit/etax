@extends('layouts.admin')
@section('title', 'Assessment Statistics')
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-100 mb-2">Assessment Statistics</h2>
        <p class="text-gray-400">Analyze assessment performance metrics and trends</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Assessments -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-400">Total Assessments</h3>
                    <p class="text-2xl font-bold text-gray-100 mt-2" id="total-assessments">{{ $stats['total_assessments'] }}</p>
                </div>
                <div class="p-3 bg-indigo-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Responses -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-400">Total Responses</h3>
                    <p class="text-2xl font-bold text-gray-100 mt-2" id="total-responses">{{ $stats['total_responses'] }}</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Score -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-400">Average Score</h3>
                    <p class="text-2xl font-bold text-gray-100 mt-2" id="average-score">{{ round($stats['average_score']) }}%</p>
                </div>
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pass Rate -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-400">Pass Rate</h3>
                    <p class="text-2xl font-bold text-gray-100 mt-2" id="pass-rate">{{ round($stats['pass_rate']) }}%</p>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Completion Trends Chart -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <h3 class="text-lg font-semibold text-gray-100 mb-4">Assessment Completion Trends</h3>
            <div class="h-80">
                <canvas id="completion-trends"></canvas>
            </div>
        </div>

        <!-- Score Distribution Chart -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 transition-all duration-300 hover:bg-gray-800/60">
            <h3 class="text-lg font-semibold text-gray-100 mb-4">Average Score Trends</h3>
            <div class="h-80">
                <canvas id="score-trends"></canvas>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const stats = JSON.parse('<?php echo json_encode($stats); ?>');
    const trends = <?php echo json_encode($trends); ?>;
    console.log('tserting');
    updateStatistics(stats);
    createCompletionTrendChart(trends);
    createScoreTrendChart(trends);

    function updateStatistics(stats) {
        document.getElementById('total-assessments').textContent = stats.total_assessments;
        document.getElementById('total-responses').textContent = stats.total_responses;
        document.getElementById('average-score').textContent = `${Math.round(stats.average_score)}%`;
        document.getElementById('pass-rate').textContent = `${Math.round(stats.pass_rate)}%`;
    }

    function createCompletionTrendChart(trends) {
        const ctx = document.getElementById('completion-trends').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trends.map(t => new Date(t.date).toLocaleDateString()),
                datasets: [{
                    label: 'Completions',
                    data: trends.map(t => t.total),
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        },
                        ticks: {
                            color: 'rgb(156, 163, 175)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        },
                        ticks: {
                            color: 'rgb(156, 163, 175)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgb(156, 163, 175)'
                        }
                    }
                }
            }
        });
    }

    function createScoreTrendChart(trends) {
        const ctx = document.getElementById('score-trends').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trends.map(t => new Date(t.date).toLocaleDateString()),
                datasets: [{
                    label: 'Average Score',
                    data: trends.map(t => t.average_score),
                    borderColor: 'rgb(245, 158, 11)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        },
                        ticks: {
                            color: 'rgb(156, 163, 175)',
                            callback: value => `${value}%`
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        },
                        ticks: {
                            color: 'rgb(156, 163, 175)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgb(156, 163, 175)'
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection