<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResponse;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment;

class EmployeeDashboardController extends Controller
{
    /**
     * Display the employee dashboard with assessment statistics.
     */
    public function index()

    {

     /** @var \App\Models\User $user */

        $user = Auth::user();

        // Get assigned assessments that haven't been started
        $assignedAssessments = $user->assessments()
            ->where('is_published', true)
            ->whereDoesntHave('responses', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['responses' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        // Get assessment responses
        $responses = $user->assessmentResponses()
            ->with('assessment')
            ->get();

        // Calculate counts
        $pendingCount = $assignedAssessments->count() + 
            $responses->where('status', AssessmentResponse::STATUS_IN_PROGRESS)->count();

        $completedCount = $responses
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->count();

        // Calculate average score
        $averageScore = $responses
            ->where('status', AssessmentResponse::STATUS_COMPLETED)
            ->avg('score') ?? 0;

        // Combine recent assessments
        $recentAssessments = collect();
        
        // Add assigned assessments
        $assignedAssessments->each(function ($assessment) use ($recentAssessments) {
            $recentAssessments->push([
                'assessment' => $assessment,
                'status' => 'assigned',
                'due_date' => $assessment->pivot->due_date,
                'started_at' => null
            ]);
        });
        
        // Add assessments with responses
        $responses->each(function ($response) use ($recentAssessments) {
            $recentAssessments->push([
                'assessment' => $response->assessment,
                'status' => $response->status,
                'started_at' => $response->created_at
            ]);
        });
        
        // Sort by most recent and take 5
        $recentAssessments = $recentAssessments
            ->sortByDesc(function ($item) {
                return $item['started_at'] ?? $item['due_date'] ?? now();
            })
            ->take(5);

        return view('employee.dashboard', [
            'pendingCount' => 100,
            'completedCount' => $completedCount,
            'averageScore' => round($averageScore, 1),
            'recentAssessments' => $recentAssessments
        ]);
    }

    public function show(Assessment $assessment)
    {
        if (!$assessment->is_published || 
            ($assessment->start_date > now()) || 
            ($assessment->end_date && $assessment->end_date < now())) {
            abort(404);
        }

        return view('employee.assessments.show', compact('assessment'));
    }
}