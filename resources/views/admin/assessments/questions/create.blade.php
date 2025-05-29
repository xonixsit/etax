@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-x-hidden pt-16 lg:ml-64 transition-all duration-300">
        <main class="flex-1 px-4 pt-6 pb-8">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-100">Add Questions to Assessment</h1>
                        <p class="mt-1 text-sm text-gray-400">{{ $assessment->title }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.assessments.show', $assessment) }}" class="inline-flex items-center px-4 py-2 border border-slate-700 rounded-md shadow-sm text-sm font-medium text-gray-300 bg-transparent hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-300">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Assessment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Question Form -->
            <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl p-8 border border-slate-700/50">
                <form action="{{ route('admin.assessments.questions.store', $assessment) }}" method="POST" class="space-y-8" id="questionForm">
                    @if($errors->any())
                        <div class="bg-red-500/10 border border-red-500/50 rounded-lg p-4 mb-6">
                            <ul class="list-disc list-inside text-sm text-red-400">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf

                    <!-- Question Type Selection -->
                    <div class="space-y-8 bg-slate-900/30 rounded-xl p-8 border border-slate-700/30 shadow-lg">
                        <div class="relative group">
                            <label for="type" class="inline-flex items-center text-base font-medium text-gray-200 group-hover:text-indigo-400 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                                Question Type <span class="text-indigo-400 ml-1">*</span>
                            </label>
                            <span class="text-sm text-gray-400 mt-1.5 block group-hover:text-gray-300 transition-colors duration-200">Select the type of question you want to create</span>
                            <div class="mt-3 relative">
                                <select name="type" id="type" class="block w-full rounded-lg bg-slate-800/80 border-2 border-slate-700/50 text-gray-200 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 focus:ring-opacity-50 shadow-sm text-base transition-all duration-200 hover:border-slate-600 appearance-none" required>
                                    <option value="multiple_choice">Multiple Choice</option>
                                    <option value="single_selection">Single Selection</option>
                                    <option value="paragraph">Paragraph</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="relative group mt-6">
                            <label for="text" class="inline-flex items-center text-base font-medium text-gray-200 group-hover:text-indigo-400 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Question Text <span class="text-indigo-400 ml-1">*</span>
                            </label>
                            <span class="text-sm text-gray-400 mt-1.5 block group-hover:text-gray-300 transition-colors duration-200">Write your question clearly and concisely</span>
                            <div class="mt-3 relative">
                                <textarea name="text" id="text" rows="3" class="block w-full rounded-lg bg-slate-800/80 border-2 border-slate-700/50 text-gray-200 p-4 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 focus:ring-opacity-50 shadow-sm text-base transition-all duration-200 hover:border-slate-600" placeholder="e.g., What is the primary purpose of JavaScript's 'const' keyword?" required></textarea>
                                <div class="absolute bottom-3 right-3 text-gray-400 text-sm pointer-events-none opacity-70">
                                    <span id="charCount">0</span> characters
                                </div>
                            </div>
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="multipleChoiceOptions" class="space-y-6">
                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center text-base font-medium text-gray-200">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Options <span class="text-indigo-400 ml-1">*</span>
                                </label>
                                <button type="button" id="addOption" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/20 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Option
                                </button>
                            </div>
                            <span class="text-sm text-gray-400 block">Add multiple choice options and select the correct answer</span>
                            
                            <div class="space-y-3" id="optionsContainer" role="group" aria-labelledby="options-label">
                                <div class="group flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                                    <div class="relative flex items-center justify-center w-6 h-6">
                                        <input type="checkbox" id="option_0" name="correct_answers[]" value="0" class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600" required aria-label="Mark as correct answer">
                                    </div>
                                    <input type="text" id="option_text_0" name="options[]"  class="flex-1 bg-transparent border-0 text-gray-200 placeholder-gray-500 focus:ring-0 text-base" placeholder="Enter option text..." required aria-label="Option text">
                                </div>
                                <div class="group flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                                    <div class="relative flex items-center justify-center w-6 h-6">
                                        <input type="checkbox" id="option_1" name="correct_answers[]" value="1" class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600" aria-label="Mark as correct answer">
                                    </div>
                                    <input type="text" id="option_text_1" name="options[]" class="flex-1 bg-transparent border-0 text-gray-200 placeholder-gray-500 focus:ring-0 text-base" placeholder="Enter option text..." required aria-label="Option text">
                                </div>
                            </div>
                        </div>

                        <!-- Short Answer/Paragraph Settings -->
                        <div id="textAnswerSettings" class="space-y-6 hidden">
                            <div class="relative group">
                                <label for="word_limit" class="inline-flex items-center text-base font-medium text-gray-200 group-hover:text-indigo-400 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    Character Limit
                                </label>
                                <span class="text-sm text-gray-400 mt-1.5 block group-hover:text-gray-300 transition-colors duration-200">Maximum number of words allowed (leave empty for no limit)</span>
                                <div class="mt-3 relative">
                                    <input type="number" name="word_limit" id="word_limit" class="block w-full rounded-lg bg-slate-800/80 border-2 border-slate-700/50 text-gray-200 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 focus:ring-opacity-50 shadow-sm text-base transition-all duration-200 hover:border-slate-600" placeholder="e.g., 100">
                    <span class="text-sm text-gray-400 mt-2 block" id="wordLimitHelp"></span>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-8 mt-8 border-t border-slate-700/50">
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">All fields marked with <span class="text-indigo-400">*</span> are required</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 active:bg-indigo-700 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Question
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 transform transition-all duration-300 translate-x-full opacity-0">
        <div class="flex items-center p-4 mb-4 rounded-lg shadow-lg bg-slate-800/90 backdrop-blur-sm border border-slate-700/50 text-sm">
            <div id="toast-icon" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg me-3"></div>
            <div id="toast-message" class="ms-3 font-medium"></div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 text-gray-400 hover:text-gray-100" onclick="hideToast()">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- JavaScript for Dynamic Form Handling -->
    <script>
        // Form elements
        // Toast notification functions
        function showToast(type, message) {
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toast-icon');
            const toastMessage = document.getElementById('toast-message');
            
            // Set icon and colors based on type
            if (type === 'error') {
                toastIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                toast.classList.add('bg-red-500/10', 'border-red-500/50');
                toastMessage.classList.add('text-red-400');
            }
            
            // Set message and show toast
            toastMessage.textContent = message;
            toast.classList.remove('translate-x-full', 'opacity-0');
            
            // Hide toast after 3 seconds
            setTimeout(hideToast, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-x-full', 'opacity-0');
            
            // Reset classes after animation
            setTimeout(() => {
                toast.classList.remove('bg-red-500/10', 'border-red-500/50');
                document.getElementById('toast-message').classList.remove('text-red-400');
            }, 300);
        }

        // Initialize form elements and event listeners
        let questionForm = document.getElementById('questionForm');
        const questionText = document.getElementById('text');
        const typeSelect = document.getElementById('type');
        const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
        const textAnswerSettings = document.getElementById('textAnswerSettings');
        const optionsContainer = document.getElementById('optionsContainer');
        const wordLimitInput = document.getElementById('word_limit');
        const addOptionButton = document.getElementById('addOption');
        
        // Function to create a new option element
        function addNewOption(selectedType, index) {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'group flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200';
            
            const inputWrapper = document.createElement('div');
            inputWrapper.className = 'relative flex items-center justify-center w-6 h-6';
            
            const input = document.createElement('input');
            input.type = selectedType === 'multiple_choice' ? 'checkbox' : 'radio';
            input.id = `option_${index}`;
            input.name = selectedType === 'multiple_choice' ? `correct_answers[]` : 'correct_answer';
            input.value = index.toString();
            input.className = 'w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600';
            input.setAttribute('aria-label', 'Mark as correct answer');
            
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.id = `option_text_${index}`;
            textInput.name = 'options[]';
            textInput.className = 'flex-1 bg-transparent border-0 text-gray-200 placeholder-gray-500 focus:ring-0 text-base';
            textInput.placeholder = 'Enter option text...';
            textInput.required = true;
            textInput.setAttribute('aria-label', 'Option text');
            
            textInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
            
            inputWrapper.appendChild(input);
            optionDiv.appendChild(inputWrapper);
            optionDiv.appendChild(textInput);
            
            return optionDiv;
        }

        // Handle question type changes
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            
            // Show/hide relevant sections based on question type
            if (selectedType === 'multiple_choice' || selectedType === 'single_selection') {
                multipleChoiceOptions.classList.remove('hidden');
                textAnswerSettings.classList.add('hidden');
                wordLimitInput.value = ''; // Clear word limit
                addOptionButton.classList.remove('hidden');
                
                // Clear existing options and add initial ones
                optionsContainer.innerHTML = '';
                for (let i = 0; i < 2; i++) {
                    optionsContainer.appendChild(addNewOption(selectedType, i));
                }
                
                // Enable required attribute for options
                optionsContainer.querySelectorAll('input[name="options[]"]').forEach(input => {
                    input.required = true;
                });
                
                // Add validation for correct answers
                const correctAnswerInputs = optionsContainer.querySelectorAll('input[type="checkbox"], input[type="radio"]');
                correctAnswerInputs.forEach(input => {
                    input.addEventListener('change', () => {
                        const hasSelectedAnswer = Array.from(correctAnswerInputs).some(inp => inp.checked);
                        if (!hasSelectedAnswer) {
                            showToast('error', 'Please select at least one correct answer');
                        }
                    });
                });
            } else {
                multipleChoiceOptions.classList.add('hidden');
                textAnswerSettings.classList.remove('hidden');
                addOptionButton.classList.add('hidden');
                
                // Disable required attribute for options when not using them
                optionsContainer.querySelectorAll('input[name="options[]"]').forEach(input => {
                    input.required = false;
                });
                
                // Clear any existing options
                optionsContainer.innerHTML = '';
            }
        });

        // Add new option button handler
        addOptionButton.addEventListener('click', function() {
            const selectedType = typeSelect.value;
            const currentOptions = optionsContainer.children.length;
            optionsContainer.appendChild(addNewOption(selectedType, currentOptions));
        });

        // Real-time character count
        questionText.addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
        });

        // Form validation function
        function validateForm() {
            const selectedType = typeSelect.value;
            const errors = [];
            
            // Validate question text
            if (!questionText.value.trim()) {
                errors.push('Question text is required');
                questionText.classList.add('border-red-500');
            } else {
                questionText.classList.remove('border-red-500');
            }
            
            // Validate options for multiple choice/single selection
            if (selectedType === 'multiple_choice' || selectedType === 'single_selection') {
                const options = document.querySelectorAll('input[name="options[]"]');
                const correctAnswers = document.querySelectorAll(
                    selectedType === 'multiple_choice' ? 
                    'input[name="correct_answers[]"]:checked' : 
                    'input[name="correct_answer"]:checked'
                );
                
                // Check for minimum options
                if (options.length < 2) {
                    errors.push('At least two options are required');
                }
                
                // Check for empty options and collect valid options
                let validOptions = 0;
                options.forEach((option, index) => {
                    if (!option.value.trim()) {
                        errors.push(`Option ${index + 1} cannot be empty`);
                        option.classList.add('border-red-500');
                    } else {
                        validOptions++;
                        option.classList.remove('border-red-500');
                    }
                });
                
                // Check for correct answer selection
                if (correctAnswers.length === 0) {
                    errors.push('Please select at least one correct answer');
                }
                
                // For multiple choice, validate that selected correct answers exist
                if (selectedType === 'multiple_choice') {
                    correctAnswers.forEach(answer => {
                        const optionIndex = parseInt(answer.value);
                        const correspondingOption = document.querySelector(`#option_text_${optionIndex}`);
                        if (!correspondingOption || !correspondingOption.value.trim()) {
                            errors.push('Selected correct answer must have corresponding option text');
                        }
                    });
                }
            }
            
            // Validate word limit for text questions
            if (selectedType === 'paragraph' && wordLimitInput.value) {
                const limit = parseInt(wordLimitInput.value);
                if (isNaN(limit) || limit <= 0) {
                    errors.push('Word limit must be a positive number');
                    wordLimitInput.classList.add('border-red-500');
                } else {
                    wordLimitInput.classList.remove('border-red-500');
                }
            }
            
            return { isValid: errors.length === 0, errors };
        }

        // Form submission handling
        questionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const errors = validateForm();
            
            if (errors.length > 0) {
                errors.forEach(error => showToast('error', error));
                return;
            }
            
            const selectedType = typeSelect.value;
            
            // For multiple choice questions, ensure correct answers are properly collected
            if (selectedType === 'multiple_choice') {
                const correctAnswers = Array.from(document.querySelectorAll('input[name="correct_answers[]"]:checked'))
                    .map(input => input.value);
                
                if (correctAnswers.length === 0) {
                    showToast('error', 'Please select at least one correct answer');
                    return;
                }
                
                // Verify each correct answer corresponds to a valid option
                const validSubmission = correctAnswers.every(answer => {
                    const optionInput = document.querySelector(`#option_text_${answer}`);
                    return optionInput && optionInput.value.trim() !== '';
                });
                
                if (!validSubmission) {
                    showToast('error', 'All selected correct answers must have valid option text');
                    return;
                }
            }
            
            // If all validations pass, submit the form
            this.submit();
        });

        // Trigger initial state
        typeSelect.dispatchEvent(new Event('change'));

        // Real-time validation
        function validateForm() {
            let isValid = true;
            const errors = [];
            const selectedType = typeSelect.value;

            // Validate question text
            if (questionText.value.trim() === '') {
                // Ensure form submission is not triggered multiple times
                questionText.classList.add('border-red-500');
                errors.push('Question text is required');
                isValid = false;
            } else {
                questionText.classList.remove('border-red-500');
            }

            // Validate multiple choice options only if type is multiple_choice
            if (selectedType === 'multiple_choice' && !multipleChoiceOptions.classList.contains('hidden')) {
                const options = document.querySelectorAll('input[name="options[]"]');
                const validOptions = Array.from(options).filter(opt => opt.value.trim() !== '').length;
                const correctAnswer = document.querySelector('input[name="correct_answer"]:checked');

                if (validOptions < 2) {
                    optionsContainer.classList.add('border-red-500');
                    errors.push('At least two options are required');
                    isValid = false;
                } else {
                    optionsContainer.classList.remove('border-red-500');
                }

                const correctAnswers = document.querySelectorAll('input[name="correct_answers[]"]:checked, input[name="correct_answer"]:checked');
                if (correctAnswers.length === 0) {
                    errors.push('Please select at least one correct answer');
                    isValid = false;
                }

                // Validate each option
                options.forEach((option, index) => {
                    if (!option.value.trim()) {
                        option.classList.add('border-red-500', 'bg-red-500/10');
                    } else {
                        option.classList.remove('border-red-500', 'bg-red-500/10');
                    }
                });
            }

            // Validate word limit only for text-based questions
            if (['short_answer', 'paragraph'].includes(selectedType) && !textAnswerSettings.classList.contains('hidden')) {
                if (wordLimitInput.value) {
                    const limit = parseInt(wordLimitInput.value);
                    if (isNaN(limit) || limit <= 0) {
                        wordLimitInput.classList.add('border-red-500');
                        errors.push('Word limit must be a positive number');
                        isValid = false;
                    } else {
                        wordLimitInput.classList.remove('border-red-500');
                    }
                }
            }
            return { isValid, errors };
        }

        // Form submission handling
        // Form submission handling
        questionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const { isValid, errors } = validateForm();
        
            // Check CSRF token
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token || !token.content) {
                showToast('error', 'CSRF token is missing. Please refresh the page.');
                return;
            }
        
            // If validation passes, submit the form
            this.submit();
        });

        // Real-time validation on input
        questionText.addEventListener('input', () => validateForm());
        typeSelect.addEventListener('change', () => validateForm());
        if (wordLimitInput) {
            wordLimitInput.addEventListener('input', () => validateForm());
        }

        // Validate options when added or modified
        optionsContainer.addEventListener('input', function(e) {
            if (e.target.matches('input[name="options[]"]')) {
                validateForm();
            }
        });

        // Original script content starts here
        // Toast notification functions with improved animations and feedback
        let toastTimeout;
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            
            // Clear any existing timeout
            if (toastTimeout) {
                clearTimeout(toastTimeout);
                toast.classList.add('translate-x-full', 'opacity-0');
            }
            
            // Set message
            toastMessage.textContent = message;
            console.log(message);
            
            // Set icon and colors based on type
            if (type === 'success') {
                toastIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                toastMessage.classList.remove('text-red-500');
                toastMessage.classList.add('text-green-500');
                toast.classList.remove('bg-red-900/10', 'border-red-500/50');
                toast.classList.add('bg-green-900/10', 'border-green-500/50');
            } else {
                toastIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                toastMessage.classList.remove('text-green-500');
                toastMessage.classList.add('text-red-500');
                toast.classList.remove('bg-green-900/10', 'border-green-500/50');
                toast.classList.add('bg-red-900/10', 'border-red-500/50');
            }
            
            // Show toast with animation
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            });
            
            // Auto hide after 5 seconds
            toastTimeout = setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
            }, 5000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-x-full', 'opacity-0');
            if (toastTimeout) {
                clearTimeout(toastTimeout);
            }
        e.classList.remove('text-green-500');
            
            // Show toast
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
            
            // Auto hide after 5 seconds
            setTimeout(hideToast, 5000);
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
            const textAnswerSettings = document.getElementById('textAnswerSettings');
            const addOptionButton = document.getElementById('addOption');
            const optionsContainer = document.getElementById('optionsContainer');
            const questionText = document.getElementById('text');
            const charCount = document.getElementById('charCount');
            const form = document.querySelector('form');
            let optionCount = 2;

            

            // Show error helper function
            function showError(element, message) {
                // Remove any existing error messages
                const existingError = element.parentElement.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                // Add error class to the element
                element.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');

                // Create and insert error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-sm text-red-500 mt-10';
                errorDiv.textContent = message;
                element.parentElement.appendChild(errorDiv);

                // Remove error state after user starts typing
                element.addEventListener('input', function() {
                    element.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                    const errorMessage = element.parentElement.querySelector('.error-message');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }, { once: true });
                
                showError(optionsContainer, 'Please select a correct answer');
                        isValid = false;
                    }
                

                // Validate word limit for text answers based on question type
                if (type === 'short_answer' || type === 'paragraph') {
                    const wordLimit = document.getElementById('word_limit');
                    const minLimit = type === 'short_answer' ? 1 : 50;
                    const maxLimit = type === 'short_answer' ? 100 : 1000;
                    const wordLimitValue = parseInt(wordLimit.value);

                    if (!wordLimit.value) {
                        showError(wordLimit, `Please specify a word limit between ${minLimit} and ${maxLimit} words`);
                        isValid = false;
                    } else if (wordLimitValue < minLimit || wordLimitValue > maxLimit) {
                        showError(wordLimit, `Word limit must be between ${minLimit} and ${maxLimit} words for ${type.replace('_', ' ')} questions`);
                        isValid = false;
                    }
                }

            // Error handling function

            // Character count for question text with max length
            const MAX_QUESTION_LENGTH = 500;
            questionText.setAttribute('maxlength', MAX_QUESTION_LENGTH);
            
            questionText.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length >= MAX_QUESTION_LENGTH) {
                    charCount.classList.add('text-red-500');
                } else {
                    charCount.classList.remove('text-red-500');
                }
            });

            // Add new option with enhanced styling and validation
            addOptionButton.addEventListener('click', function() {
                const optionDiv = document.createElement('div');
                if (optionCount >= 4) {
                    showError(addOptionButton, 'Maximum 6 options allowed');
                    return;
                }
                const selectedType = typeSelect.value;
                if(typeSelect.value ==='multiple_choice') 
                {
                optionDiv.className = 'group flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200';
                optionDiv.style.opacity = '0';
                optionDiv.style.transform = 'translateY(10px)';
                optionDiv.innerHTML = `
                    <div class="relative flex items-center justify-center w-6 h-6">
                        <input type="${selectedType === 'multiple_choice' ? 'checkbox' : 'radio'}" 
                               name="${selectedType === 'multiple_choice' ? 'correct_answers[]' : 'correct_answer'}" 
                               value="${optionCount}" 
                               class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600">
                    </div>
                    <input type="text" name="options[]" class="flex-1 bg-transparent border-0 text-gray-200 placeholder-gray-500 focus:ring-0 text-base" placeholder="Enter option text..." required maxlength="200">
                    <button type="button" class="text-gray-400 hover:text-red-400 transition-colors duration-200 delete-option p-1 rounded-full hover:bg-red-500/10">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                }
                else if(typeSelect.value ==='single_selection') {     
                      
                        optionDiv.className = 'group flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50 border-2 border-slate-700/50 hover:border-slate-600 transition-all duration-200';
                        optionDiv.style.opacity = '0';
                        optionDiv.style.transform = 'translateY(10px)';
                        optionDiv.innerHTML = `
                            <div class="relative flex items-center justify-center w-6 h-6">
                                <input type="radio" name="correct_answer" value="${optionCount}" class="w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 bg-slate-700 border-slate-600">
                            </div>
                            <input type="text" name="options[]" class="flex-1 bg-transparent border-0 text-gray-200 placeholder-gray-500 focus:ring-0 text-base" placeholder="Enter option text..." required maxlength="200">
                            <button type="button" class="text-gray-400 hover:text-red-400 transition-colors duration-200 delete-option p-1 rounded-full hover:bg-red-500/10">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        `;
                }
                        optionsContainer.appendChild(optionDiv);
                        optionCount++;
              
                // Animate the new option
                requestAnimationFrame(() => {
                    optionDiv.style.opacity = '1';
                    optionDiv.style.transform = 'translateY(0)';
                });

                // Add delete event listener with animation
                const deleteButton = optionDiv.querySelector('.delete-option');
                deleteButton.addEventListener('click', function() {
                    optionDiv.style.opacity = '0';
                    optionDiv.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        optionDiv.remove();
                        optionCount--;
                        // Update remaining radio button values
                        document.querySelectorAll('input[name="correct_answer"]').forEach((radio, index) => {
                            radio.value = index;
                        });
                    }, 200);
                });

                // Focus the new input field
                optionDiv.querySelector('input[type="text"]').focus();
           
            });

            // Add transition styles
            const style = document.createElement('style');
            style.textContent = `
                #multipleChoiceOptions, #textAnswerSettings {
                    transition: opacity 0.2s ease-in-out;
                }
                .group {
                    transition: all 0.2s ease-in-out;
                }
                .group:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }
            `;
            document.head.appendChild(style);
        });
    </script>
    
</body>
</html>