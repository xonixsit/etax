@extends('layouts.admin')

@section('content')
    
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-500/10 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-100">Edit Question</h1>
                        <p class="text-sm text-gray-400">Update the question details below</p>
                    </div>
                </div>
                <a href="{{ route('admin.assessments.show', $assessment) }}" class="inline-flex items-center px-3 py-2 text-sm border border-slate-700 rounded-lg text-gray-300 bg-transparent hover:bg-slate-800 focus:ring focus:ring-slate-500/20 transition-all duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>
        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 rounded-lg p-4 mb-6" role="alert" aria-label="Form Errors">
                <ul class="list-disc list-inside text-sm text-red-400">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.assessments.questions.update', ['assessment' => $assessment->id, 'question' => $question->id]) }}" 
              method="POST" 
              class="space-y-6"
              aria-label="Question Edit Form">
            @csrf
            @method('PUT')

            <!-- Question Type Section -->
            <div class="space-y-2">
                <label for="type" class="block text-sm font-medium text-gray-300">Question Type</label>
                <div class="relative">
                    <select name="type" aria-readonly="true"
                            id="type" 
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                            aria-required="true">
                        <option value="multiple_choice" {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                        <option value="single_selection" {{ $question->type == 'single_selection' ? 'selected' : '' }}>Single Selection</option>
                        <option value="short_answer" {{ $question->type == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                        <option value="paragraph" {{ $question->type == 'paragraph' ? 'selected' : '' }}>Paragraph</option>
                    </select>
                </div>
            </div>

            <!-- Question Text Section -->
            <div class="space-y-2">
                <label for="text" class="block text-sm font-medium text-gray-300">Question Text</label>
                <div class="relative">
                    <textarea name="text" 
                              id="text" 
                              class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                              rows="3"
                              aria-required="true"
                              placeholder="Enter your question here">{{ old('text', $question->text) }}</textarea>
                </div>
            </div>

            <!-- Options Section -->
            <div id="options-container" 
                 class="space-y-4 {{ in_array($question->type, ['multiple_choice', 'single_selection']) ? '' : 'hidden' }}">
                <div class="space-y-2">
                    <label for="options" class="block text-sm font-medium text-gray-300">Answer Options</label>
                    <div id="options" class="space-y-3">
                        @if(is_array($question->options) || is_object($question->options))
                            @foreach($question->options as $index => $option)
                                <div class="relative flex items-center">
                                    <input type="text" 
                                           name="options[]" 
                                           class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                                           value="{{ old('options.' . $index, $option) }}"
                                           placeholder="Option {{ $index + 1 }}"
                                           aria-label="Option {{ $index + 1 }}">
                                </div>
                            @endforeach
                        @endif
                          
                    </div>
                </div>

                <!-- Correct Answer Section -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Correct Answers</label>
                    <div class="space-y-3">
                        @if(is_array($question->options) || is_object($question->options))
                            @foreach($question->options as $index => $option)
                                <div class="relative flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                                    <div class="relative flex items-center justify-center w-6 h-6">
                                        <input type="{{ $question->type === 'single_selection' ? 'radio' : 'checkbox' }}" 
                                               name="{{ $question->type === 'single_selection' ? 'correct_answer' : 'correct_answers[]' }}" 
                                               value="{{ $index }}" 
                                               {{ $question->type === 'single_selection' ? 
                                                   ($question->correct_answer == $index ? 'checked' : '') : 
                                                   (in_array($index, explode(',', $question->correct_answer)) ? 'checked' : '') }}
                                               class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600"
                                               aria-label="Mark as correct answer">
                                    </div>
                                    <span class="text-gray-300">{{ $option }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Character Limit Section -->
            <div class="space-y-2 {{ in_array($question->type, ['multiple_choice', 'single_selection']) ? 'hidden' : '' }}">
                <label for="word_limit" class="block text-sm font-medium text-gray-300">Character Limit</label>
                <div class="relative">
                    <input type="number" 
                           name="word_limit" 
                           id="word_limit" 
                           class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                           value="{{ old('word_limit', $question->word_limit) }}"
                           min="0"
                           aria-label="Maximum character limit for answers">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end pt-6">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                        aria-label="Save question changes">
                    Save Changes
                </button>
            </div>
        </form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const optionsContainer = document.getElementById('options-container');
        const wordLimitInput = document.getElementById('word_limit');

        function updateFormFields() {
            const selectedType = typeSelect.value;
            const isChoiceType = ['multiple_choice', 'single_selection'].includes(selectedType);
            const isTextType = ['short_answer', 'paragraph'].includes(selectedType);

            // Toggle options container visibility
            optionsContainer.classList.toggle('hidden', !isChoiceType);
            
            // Toggle required attributes based on question type
            const optionInputs = optionsContainer.querySelectorAll('input[name="options[]"]');
            const correctAnswerInputs = optionsContainer.querySelectorAll('input[name="correct_answers[]"]');
            
            // Handle choice-type questions
            if (isChoiceType) {
                optionInputs.forEach(input => {
                    input.required = true;
                    input.disabled = false;
                });
                correctAnswerInputs.forEach(input => {
                    input.disabled = false;
                });
                // Ensure at least one correct answer is selected for multiple choice
                if (selectedType === 'multiple_choice') {
                    const hasSelectedAnswer = Array.from(correctAnswerInputs).some(inp => inp.checked);
                    if (!hasSelectedAnswer) {
                        correctAnswerInputs[0].required = true;
                    }
                }
            } else {
                // For non-choice questions (paragraph, short answer)
                optionInputs.forEach(input => {
                    input.required = false;
                    input.disabled = true;
                    input.value = ''; // Clear options
                });
                correctAnswerInputs.forEach(input => {
                    input.required = false;
                    input.disabled = true;
                    input.checked = false; // Uncheck all answers
                });
            }

            // Handle word limit field
            if (wordLimitInput) {
                wordLimitInput.disabled = !isTextType;
                if (isTextType) {
                    wordLimitInput.required = true;
                } else {
                    wordLimitInput.required = false;
                    wordLimitInput.value = '';
                }
            }
        }

        // Initial setup
        updateFormFields();

        // Handle changes
        typeSelect.addEventListener('change', updateFormFields);
    });
</script>
@endpush
@endsection