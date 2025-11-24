<?php
// Run this script to fix existing assessment scores
// php artisan tinker
// include 'fix_assessment_scores.php'

use App\Models\QuestionResponse;
use App\Models\Question;

$incorrectAnswers = QuestionResponse::where('is_correct', false)
    ->whereHas('question', function($query) {
        $query->where('type', 'multiple_choice');
    })
    ->with('question')
    ->get();

foreach ($incorrectAnswers as $answer) {
    $question = $answer->question;
    
    // Decode the user's answer
    $userAnswers = json_decode($answer->answer, true) ?? [];
    
    // Get correct answer(s)
    $correctAnswerStr = (string) $question->correct_answer;
    if (strpos($correctAnswerStr, ',') !== false) {
        $correctAnswers = array_map('trim', explode(',', $correctAnswerStr));
    } else {
        $correctAnswers = [$correctAnswerStr];
    }
    
    $correctOptions = array_map(function($index) use ($question) {
        return $question->options[(int)$index] ?? null;
    }, $correctAnswers);
    
    $correctOptions = array_filter($correctOptions);
    
    // Check if arrays have the same values regardless of order
    sort($userAnswers);
    sort($correctOptions);
    $isCorrect = $userAnswers == $correctOptions;
    
    if ($isCorrect) {
        echo "Fixing answer ID {$answer->id}: User answered " . json_encode($userAnswers) . ", correct answer is " . json_encode($correctOptions) . "\n";
        
        $answer->update([
            'is_correct' => true,
            'score' => 1
        ]);
        
        // Recalculate assessment response score
        $response = $answer->assessmentResponse;
        $totalQuestions = $response->assessment->questions()->count();
        $correctAnswers = $response->answers()->where('is_correct', true)->count();
        $newScore = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
        
        $response->update(['score' => $newScore]);
        
        echo "Updated assessment response {$response->id} score to {$newScore}%\n";
    }
}

echo "Done!\n";