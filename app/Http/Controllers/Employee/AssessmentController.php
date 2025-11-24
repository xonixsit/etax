<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Mail\AssessmentCompleted;
use App\Models\Assessment;
use App\Models\AssessmentResponse;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;
use PDF;

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
        
        if ($assessment->getIsExpiredAttribute()) {
            return redirect()->route('employee.assessments.index')
                ->with('error', 'This assessment is no longer available.');
        }
        // Get the latest response for this assessment
        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->latest()
            ->first();
            Log::info('Assessment: '. $assessment);
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

    public function confirmation(Assessment $assessment, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->latest()
            ->first();

        if ($response && $request->has('timed_out') && $request->timed_out == 'true') {
            $response->update([
                'status' => AssessmentResponse::STATUS_PENDING_REVIEW,
                'completed_at' => now(),
            ]);
            return view('employee.assessments.confirmation', compact('assessment', 'response'))->with('success', 'Assessment submitted due to timeout and is pending review.');
        }

        return view('employee.assessments.confirmation', compact('assessment', 'response'));
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

        Log::info('submitAnswer method called.');
        $isTimedOut = (bool) $request->get('timed_out');
        Log::info('Request has timed_out parameter (via get): ' . ($request->has('timed_out') ? 'true' : 'false'));
        Log::info('Value of timed_out parameter (via get): ' . $request->get('timed_out'));
        Log::info('Type of timed_out parameter (via get): ' . gettype($request->get('timed_out')));
        Log::info('isTimedOut boolean value: ' . ($isTimedOut ? 'true' : 'false'));

        // Check if the submission is due to a timeout
        if ($isTimedOut) {
            $response->update([
                'status' => AssessmentResponse::STATUS_PENDING_REVIEW,
                'completed_at' => now(),
            ]);
            Log::info('Redirecting to confirmation page after timeout.');
            return redirect()->route('employee.assessments.confirmation', $assessment)->with('success', 'Assessment submitted due to timeout and is pending review.');
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

           // After assessment completion:
            $mail = new AssessmentCompleted(Auth::user()->id, $assessment, $finalScore);
            Mail::to('xonixsitsolutions@gmail.com')->send($mail);

            return redirect()->route('employee.assessment.confirmation')->with('success', 'Assessment completed successfully!');
        }

        Log::info('Assessment duration in question method: ' . $assessment->duration);
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

        Log::info('submitAnswer method called.');
        Log::info('Request has timeout parameter: ' . ($request->has('timeout') ? 'true' : 'false'));
        Log::info('Value of timeout parameter: ' . $request->input('timeout'));
        Log::info('Type of timeout parameter: ' . gettype($request->input('timeout')));

        // Check if the submission is due to a timeout
        if ($request->has('timeout') && $request->timeout === 'true') {
            $response->update([
                'status' => AssessmentResponse::STATUS_PENDING_REVIEW,
                'completed_at' => now(),
            ]);
            return redirect()->route('employee.assessment.confirmation')->with('success', 'Assessment submitted due to timeout and is pending review.');
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
                // Convert correct_answer to string for consistent handling
                $correctAnswerStr = (string) $question->correct_answer;
                
                // Handle both single index and comma-separated indices
                if (strpos($correctAnswerStr, ',') !== false) {
                    // Multiple correct answers (comma-separated indices)
                    $correctAnswers = array_map('trim', explode(',', $correctAnswerStr));
                } else {
                    // Single correct answer (single index)
                    $correctAnswers = [$correctAnswerStr];
                }
                
                $correctOptions = array_map(function($index) use ($question) {
                    return $question->options[(int)$index] ?? null;
                }, $correctAnswers);
                
                // Remove any null values
                $correctOptions = array_filter($correctOptions);
                
                // Check if arrays have the same values regardless of order
                sort($userAnswer);
                sort($correctOptions);
                $isCorrect = $userAnswer == $correctOptions;
            }
            
            $score = $isCorrect ? 1 : 0;

            
            Log::info('Answer details', [
                'question_id' => $question->id,
                'question_type' => $question->type,
                'raw_request_answer' => $request->answer,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'correct_answer_str' => $correctAnswerStr ?? null,
                'correct_answers_array' => $correctAnswers ?? null,
                'correct_options' => $question->type === 'multiple_choice' ? $correctOptions : $correctAnswerValue,
                'is_correct' => $isCorrect,
                'options' => $question->options
            ]);
        }

        // Store the answer
        $storedAnswer = $question->type === 'multiple_choice' ? json_encode($request->answer) : $request->answer;
        
        Log::info('Storing answer', [
            'question_id' => $question->id,
            'stored_answer' => $storedAnswer,
            'is_correct' => $isCorrect,
            'score' => $score
        ]);
        
        $response->answers()->create([
            'question_id' => $question->id,
            'answer' => $storedAnswer,
            'is_correct' => $isCorrect,
            'score' => $score
        ]);

        return redirect()->route('employee.assessments.question', [
            'assessment' => $assessment->id,
            'response' => $response->id,
            'action' => 'next'
        ]);
    }

    /*write function to pass values in certificate for completion assessment selected by employee*/
    public function viewCertificate($assessmentId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        /*get assessment title from assessment id*/
        $assessment = Assessment::findOrFail($assessmentId);
        
        // Check if user has completed this assessment
        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->first();
            
        if (!$response) {
            return redirect()->route('employee.assessments.index')
                ->with('error', 'You must complete this assessment before viewing the certificate.');
        }
        
        return view('employee.certificates.certificate', [
            'employeeName' => $user->name,
            'assessmentTitle' => $assessment->title,
            'assessmentId' => $assessment->id,
            'dateIssued' => $response->completed_at,
            'score' => $response->score
        ]);    
    }


    public function downloadCertificateAsImage($assessmentId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $assessment = Assessment::findOrFail($assessmentId);
        
        // Check if user has completed this assessment
        $response = AssessmentResponse::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->first();
            
        if (!$response) {
            return redirect()->route('employee.assessments.index')
                ->with('error', 'You must complete this assessment before downloading the certificate.');
        }

        /*get user name from auth*/
        $userName = $user->name;

        $url = route('employee.certificates.certificate', ['assessmentId' => $assessment->id]);
        $filePath = storage_path('app/public/certificates/HFI_Certificate_' . $userName . '.png');
        
        // Ensure the certificates directory exists
        $certificatesDir = storage_path('app/public/certificates');
        if (!file_exists($certificatesDir)) {
            mkdir($certificatesDir, 0755, true);
        }
    
        try {
            Browsershot::url($url)
                ->noSandbox()
                ->timeout(60) // seconds
                ->setDelay(1000) // 1 second delay to let the page fully render
                ->windowSize(1200, 800)
                ->save($filePath);
                
            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Certificate generation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate certificate. Please try again.');
        }
    }
    
}