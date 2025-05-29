<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all assessments assigned to the user
        $allAssessments = Assessment::all();

        // Get latest assessment response for each assessment
        $responses = AssessmentResponse::where('user_id', $user->id)
            ->with('assessment')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('assessment_id');

        // Calculate completed assessments
        $completedCount = $responses->where('status', AssessmentResponse::STATUS_COMPLETED)->count();

        // Calculate in-progress assessments
        $inProgressCount = $responses->where('status', AssessmentResponse::STATUS_IN_PROGRESS)->count();
        
        // Calculate pending assessments
        $pendingCount = $allAssessments->count() - $completedCount;

        // Calculate average score
        $completedResponses = $responses->where('status', AssessmentResponse::STATUS_COMPLETED);
        $averageScore = $completedResponses->isEmpty() 
            ? 0 
            : round($completedResponses->avg('score'));

        // Get recent assessments with latest status
        $recentAssessments = $responses
            ->sortByDesc('created_at')
            ->take(5)
            ->map(function ($response) {
                // Only show completed status if the assessment is completed
                $status = $response->status === AssessmentResponse::STATUS_COMPLETED
                    ? AssessmentResponse::STATUS_COMPLETED
                    : AssessmentResponse::STATUS_IN_PROGRESS;
                
                return [
                    'assessment' => $response->assessment,
                    'status' => $status,
                    'started_at' => $response->started_at,
                    'completed_at' => $response->completed_at
                ];
            });

        return view('employee.dashboard', compact(
            'pendingCount',
            'completedCount',
            'averageScore',
            'recentAssessments'
        ));
    }
}