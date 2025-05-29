@extends('layouts.employee')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="container mx-auto px-4 py-6">
            <div class="max-w-3xl mx-auto bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-lg rounded-lg shadow-xl p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $assessment->title }}</h1>
                    <div class="flex justify-between items-center mt-4 bg-gray-700/50 rounded-lg p-4 backdrop-blur-sm border border-gray-600/30">
                        <p class="text-gray-300">Question {{ $response->answers->count() + 1 }} of {{ $assessment->questions->count() }}</p>
                        @if($assessment->duration)
                        <div
                            x-data="timer({{ $assessment->duration * 60 }})"
                            x-init="init()"
                            x-show="timeLeft > 0"
                            class="flex items-center space-x-2 bg-gray-800/50 px-4 py-2 rounded-lg border border-gray-500/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-300 font-medium">Time Remaining:</span>
                            <span x-text="formatTime()" class="text-blue-400 font-bold text-lg"></span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-8">
                    <div class="text-xl font-medium text-white mb-6 bg-gray-700/50 rounded-lg p-5 backdrop-blur-sm border border-gray-600/30">
                        {{ $currentQuestion->text }}
                    </div>

                    <form x-data="{
                            isLastQuestion: {{ ($response->answers->count() + 1 === $assessment->questions->count()) ? 'true' : 'false' }},
                            selectedOptions: [],
                            validateForm() {
                                const checkboxes = document.querySelectorAll('input[name=\'answer[]\']');
                                const checked = Array.from(checkboxes).filter(cb => cb.checked);
                                if ('{{ $currentQuestion->type }}' === 'multiple_choice' && checked.length === 0) {
                                    alert('Please select at least one option');
                                    return false;
                                }
                                return true;
                            }
                        }"
                        action="{{ route('employee.assessments.submit-answer', ['assessment' => $assessment->id, 'response' => $response->id]) }}"
                        method="POST"
                        @submit.prevent="
                    if (!validateForm()) return;
                    if (isLastQuestion) {
                        if (confirm('Are you sure you want to submit the assessment? This action cannot be undone.')) {
                            $event.target.submit();
                        }
                    } else {
                        $event.target.submit();
                    }
                  ">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">

                        @switch($currentQuestion->type)
                        @case('multiple_choice')
                        <div class="space-y-3">
                            @foreach($currentQuestion->options as $index => $option)
                            <label class="flex items-start space-x-3 p-4 bg-gray-700/30 border border-gray-600/30 rounded-lg hover:bg-gray-600/40 cursor-pointer transition-all duration-200">
                                <input type="checkbox"
                                    name="answer[]"
                                    value="{{ $option }}"
                                    x-model="selectedOptions"
                                    class="mt-1 text-blue-500 border-gray-600 focus:ring-blue-500">
                                <span class="text-gray-300">{{ $option }}</span>
                            </label>
                            @endforeach
                            @error('answer')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            @error('answer.*')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        @break

                        @case('single_selection')
                        <div class="space-y-3">
                            @foreach($currentQuestion->options as $index => $option)
                            <label class="flex items-start space-x-3 p-4 bg-gray-700/30 border border-gray-600/30 rounded-lg hover:bg-gray-600/40 cursor-pointer transition-all duration-200">
                                <input type="radio" name="answer" value="{{ $option }}" class="mt-1 text-blue-500 border-gray-600 focus:ring-blue-500" required>
                                <span class="text-gray-300">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                        @break

                        @case('short_answer')
                        <div class="space-y-2">
                            <textarea
                                name="answer"
                                rows="3"
                                class="w-full bg-gray-700/30 border-gray-600/30 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 focus:ring-opacity-50 text-gray-300 placeholder-gray-500"
                                required
                                @if($currentQuestion->word_limit)
                                    maxlength="{{ $currentQuestion->word_limit * 5 }}"
                                @endif
                            ></textarea>
                            @if($currentQuestion->word_limit)
                            <p class="text-sm text-gray-400">Word limit: {{ $currentQuestion->word_limit }} words</p>
                            @endif
                        </div>
                        @break

                        @case('paragraph')
                        <div class="space-y-2">
                            <textarea
                                name="answer"
                                rows="6"
                                class="w-full bg-gray-700/30 border-gray-600/30 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 focus:ring-opacity-50 text-gray-300 placeholder-gray-500"
                                required
                                @if($currentQuestion->word_limit)
                                    maxlength="{{ $currentQuestion->word_limit * 5 }}"
                                @endif
                            ></textarea>
                            @if($currentQuestion->word_limit)
                            <p class="text-sm text-gray-400">Word limit: {{ $currentQuestion->word_limit }} words</p>
                            @endif
                        </div>
                        @break
                        @endswitch

                        <div class="mt-6 flex justify-between items-center">
                            @if($response->answers->count() > 0)

                            @else
                            <div></div>
                            @endif

                            <button type="submit" name="action" value="next" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 font-medium transition-all duration-200 flex items-center">
                                <span>Next Question</span>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function timer(duration) {
        return {
            timeLeft: parseInt(sessionStorage.getItem('assessmentTimeLeft')) || duration,
            timerInterval: null,
            init() {
                this.startTimer();
                this.$watch('timeLeft', value => {
                    sessionStorage.setItem('assessmentTimeLeft', value);
                    if (value === 300) { // 5 minutes warning
                        alert('Warning: 5 minutes remaining!');
                    }
                });
            },
            startTimer() {
                this.timerInterval = setInterval(() => {
                    if (this.timeLeft <= 0) {
                        clearInterval(this.timerInterval);
                        sessionStorage.removeItem('assessmentTimeLeft');
                        alert('Time is up! Your assessment will be submitted automatically.');
                        document.querySelector('form').submit();
                        return;
                    }
                    this.timeLeft--;
                }, 1000);
            },
            formatTime() {
                const minutes = Math.floor(this.timeLeft / 60);
                const seconds = this.timeLeft % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            },
            destroy() {
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                    sessionStorage.removeItem('assessmentTimeLeft'); // Clear session storage to reset timer
                }
            }
        };
    }
</script>
@endpush
@endsection