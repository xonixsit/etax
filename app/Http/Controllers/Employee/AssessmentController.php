<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResponse;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $assessments = Assessment::withCount('questions')
            ->with(['responses' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->where('is_published', true)   
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add status information for each assessment
        $assessments->getCollection()->transform(function ($assessment) use ($user) {
            $response = $assessment->responses->first();
            $assessment->status = $response ? $response->status : null;
            return $assessment;
        });

        return view('employee.assessments.index', compact('assessments'));
    }

    public function show(Assessment $assessment)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        //if assesment due date false         show message
        
        // if ($assessment->getIsExpiredAttribute()) {
        //     return redirect()->route('employee.assessments.index')
        //         ->with('error', 'This assessment is no longer available.');
        // }
        
        // Get the latest response for this assessment
        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->latest()
            ->first();

            //get no of questions in it
            $questionCount = $assessment->questions->count();
            Log::info('Question Count: ' . $questionCount);
            Log::info('response: '. $response);
            //validate if assessment not pulished
            if (!$assessment->is_published) {
                return redirect()->route('employee.assessments.index')
                    ->with('error', 'This assessment is not published.');
            }
            
        return view('employee.assessments.show', compact('assessment', 'response'));
    }

    public function showConfirmation()
    {
        return view('employee.assessment-confirmation');
    }

    public function results(Assessment $assessment)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->with(['answers.question'])
            ->latest()
            ->firstOrFail();

        return view('employee.assessments.results', compact('assessment', 'response'));
    }

    public function allResults()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $responses = AssessmentResponse::where('user_id', $user->id)
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->with(['assessment', 'answers.question'])
            ->latest()
            ->paginate(10);

        return view('employee.assessments.all-results', compact('responses'));
    }

    public function take(Assessment $assessment)
    {
         if (!$assessment->is_published) {
             abort(404);
         }

         if ($assessment->getIsExpiredAttribute()) {
            return redirect()->route('employee.assessments.index')
                ->with('error', 'This assessment is no longer available.');
        }

        // Check if user has already completed this assessment
         $completedResponse = AssessmentResponse::where('user_id', Auth::id())
             ->where('assessment_id', $assessment->id)
             ->where('status', AssessmentResponse::STATUS_COMPLETED)
             ->exists();

         if ($completedResponse) {
             return redirect()->route('employee.assessments.show', $assessment)
                 ->with('error', 'You have already completed this assessment.');
         }

        // // Check if user has an existing in-progress attempt
         $existingResponse = AssessmentResponse::where('user_id', Auth::id())
             ->where('assessment_id', $assessment->id)
             ->where('status', AssessmentResponse::STATUS_IN_PROGRESS)
             ->first();

         if ($existingResponse) {
             return redirect()->route('employee.assessments.question', [
                 'assessment' => $assessment->id,
                 'response' => $existingResponse->id
             ]);
         }

        // // Create new assessment response
         $response = AssessmentResponse::create([
            'user_id'   => Auth::user()->id, // or Auth::user()->id() if using default guard
            'assessment_id' => $assessment->id,
            'started_at'    => now(),        
             'status' => AssessmentResponse::STATUS_IN_PROGRESS
         ]);
           
        return redirect()->route('employee.assessments.question', [
            'assessment' => $assessment->id,
            'response' => $response->id,
            'action' => 'next'
        ]);
    }

    public function question(Assessment $assessment, AssessmentResponse $response, Request $request)
    {
        if ($response->user_id !== Auth::id()) {
            abort(403);
        }

        if ($response->status !== AssessmentResponse::STATUS_IN_PROGRESS) {
            return redirect()->route('employee.assessments.show', $assessment);
        }

        // Initialize question history in session if not exists
        if (!$request->session()->has('question_history')) {
            $request->session()->put('question_history', []);
        }
        
        $questionHistory = $request->session()->get('question_history');
        
        // Handle previous question request
        if ($request->has('action') && $request->action === 'previous' && !empty($questionHistory)) {
            $previousQuestionId = array_pop($questionHistory);
            $request->session()->put('question_history', $questionHistory);
            $currentQuestion = Question::find($previousQuestionId);
        } else {
            // Get current question or first unanswered question
            $answeredQuestionIds = $response->answers()->pluck('question_id');
            $currentQuestion = $assessment->questions()
                ->whereNotIn('id', $answeredQuestionIds)
                ->first();
                
            // Store current question in history
            if ($currentQuestion) {
                $questionHistory[] = $currentQuestion->id;
                $request->session()->put('question_history', $questionHistory);
            }
        }

        if (!$currentQuestion) {
            // Get total questions and correct answers
            $totalQuestions = $assessment->questions()->count();
            $answers = $response->answers()->with('question')->get();
            $correctAnswers = $answers->where('is_correct', true)->count();
            
            // Calculate percentage score
            $finalScore = $totalQuestions > 0 
                ? round(($correctAnswers / $totalQuestions) * 100, 2)
                : 0;

            Log::info('Assessment completion details', [
                'assessment_id' => $assessment->id,
                'response_id' => $response->id,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'final_score' => $finalScore,
                'answers' => $answers->map(function($answer) {
                    return [
                        'question_id' => $answer->question_id,
                        'answer' => $answer->answer,
                        'is_correct' => $answer->is_correct,
                        'score' => $answer->score
                    ];
                })
            ]);

            // Check if there are any paragraph answers that need review
            $hasParagraphAnswers = $answers->contains(function($answer) {
                return $answer->question->type === 'paragraph';
            });

            // Complete the assessment
            $response->update([
                'status' => $hasParagraphAnswers ? AssessmentResponse::STATUS_PENDING_REVIEW : AssessmentResponse::STATUS_COMPLETED,
                'completed_at' => now(),
                'score' => $finalScore
            ]);

            // Clear question history from session
            $request->session()->forget('question_history');

            return redirect()->route('employee.assessment.confirmation')->with('success', 'Assessment completed successfully!');
        }

        return view('employee.assessments.question', compact('assessment', 'response', 'currentQuestion'));
    }

    public function previousQuestion(Assessment $assessment, AssessmentResponse $response)
    {
        if ($response->user_id !== Auth::id()) {
            abort(403);
        }

        if ($response->status !== AssessmentResponse::STATUS_IN_PROGRESS) {
            return redirect()->route('employee.assessments.show', $assessment);
        }

        return redirect()->route('employee.assessments.question', [
            'assessment' => $assessment->id,
            'response' => $response->id,
            'action' => 'previous'
        ]);
    }

    public function submitAnswer(Request $request, Assessment $assessment, AssessmentResponse $response)
    {
        if ($response->user_id !== Auth::id()) {
            abort(403);
        }

        if ($response->status !== AssessmentResponse::STATUS_IN_PROGRESS) {
            return redirect()->route('employee.assessments.show', $assessment);
        }

        // Find the question first
        $question = Question::findOrFail($request->question_id);

        // Basic validation based on question type
        $validationRules = [
            'question_id' => 'required|exists:questions,id'
        ];

        // Add specific validation rules based on question type
        if ($question->type === 'multiple_choice') {
            $validationRules['answer'] = 'required|array';
            $validationRules['answer.*'] = 'required|string';
        } else {
            $validationRules['answer'] = 'required';
        }

        $request->validate($validationRules);
        $isCorrect = null;
        $score = null;

        // Handle different question types
        if ($question->type === 'paragraph') {
            $isCorrect = null; // Pending admin review
            $score = null;
        }
        // Auto-grade multiple choice and single selection questions
        else if (in_array($question->type, ['multiple_choice', 'single_selection'])) {
            $userAnswer = $question->type === 'multiple_choice' ? $request->answer : [$request->answer];
            
            // Validate that all answers are valid options
            foreach ($userAnswer as $answer) {
                if (!in_array($answer, $question->options)) {
                    return redirect()->back()->withErrors(['answer' => 'Invalid answer option selected.']);
                }
            }

            // For single selection
            if ($question->type === 'single_selection') {
                $correctAnswerValue = $question->options[$question->correct_answer] ?? null;
                $isCorrect = $request->answer === $correctAnswerValue;
            }
            // For multiple choice
            else {
                $correctAnswers = array_map('trim', explode(',', $question->correct_answer));
                $correctOptions = array_map(function($index) use ($question) {
                    return $question->options[$index] ?? null;
                }, $correctAnswers);
                
                // Check if arrays have the same values regardless of order
                sort($userAnswer);
                sort($correctOptions);
                $isCorrect = $userAnswer == $correctOptions;
            }
            
            $score = $isCorrect ? 1 : 0;

            
            Log::info('Answer details', [
                'question_id' => $question->id,
                'question_type' => $question->type,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'correct_options' => $question->type === 'multiple_choice' ? $correctOptions : $correctAnswerValue,
                'is_correct' => $isCorrect,
                'options' => $question->options
            ]);
        }

        // Store the answer
        $response->answers()->create([
            'question_id' => $question->id,
            'answer' => $question->type === 'multiple_choice' ? json_encode($request->answer) : $request->answer,
            'is_correct' => $isCorrect,
            'score' => $score
        ]);

        return redirect()->route('employee.assessments.question', [
            'assessment' => $assessment->id,
            'response' => $response->id,
            'action' => 'next'
        ]);
    }
}