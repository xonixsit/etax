<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResponse;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\QuestionResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // $query = AssessmentResponse::with(['assessment', 'user'])
        //      ->select('assessment_responses.*')
        //      ->join('assessments', 'assessments.id', '=', 'assessment_responses.assessment_id')
        //      ->join('employees', 'employees.id', '=', 'assessment_responses.user_id')
        //     ->where('status', '==', 'pending_review')->orWhereNull('status')->get();
            $query = AssessmentResponse::with(['assessment', 'user'])
            ->select('assessment_responses.*')
            ->join('assessments', 'assessments.id', '=', 'assessment_responses.assessment_id')
            ->join('employees', 'employees.id', '=', 'assessment_responses.user_id')
            ->whereIn('assessment_responses.status', ['completed', 'pending_review']); // Add this line
        
        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('assessment_responses.created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('assessment_responses.created_at', '<=', $request->end_date);
        }

        if ($request->filled('user_id')) {
            $query->where('assessment_responses.user_id', $request->user_id);
        }

        if ($request->filled('assessment_id')) {
            $query->where('assessment_responses.assessment_id', $request->assessment_id);
        }

        $responses = $query->orderBy('assessment_responses.created_at', 'desc')->paginate(10);
        $employees = User::all();
        $assessments = Assessment::with('responses')->get();

        return view('admin.reports.index', compact('responses', 'employees', 'assessments'));
    }

    public function export(Request $request)
    {
        $query = AssessmentResponse::with(['assessment', 'employee', 'questionResponses'])
            ->select('assessment_responses.*')
            ->join('assessments', 'assessments.id', '=', 'assessment_responses.assessment_id')
            ->join('employees', 'employees.id', '=', 'assessment_responses.user_id');

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('assessment_responses.created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('assessment_responses.created_at', '<=', $request->end_date);
        }

        if ($request->filled('user_id')) {
            $query->where('assessment_responses.user_id', $request->user_id);
        }

        if ($request->filled('assessment_id')) {
            $query->where('assessment_responses.assessment_id', $request->assessment_id);
        }

        $responses = $query->orderBy('assessment_responses.created_at', 'desc')->get();

        return response()->json([
            'data' => $responses,
            'message' => 'Reports exported successfully'
        ]);
    }

    public function reviewAnswer(Request $request, QuestionResponse $answer)
    {
        // Validate the status
        $request->validate([
            'status' => 'required|in:correct,incorrect'
        ]);

        // Update the answer's status and score
        $isCorrect = $request->status === 'correct';
        $answer->update([
            'is_correct' => $isCorrect,
            'score' => $isCorrect ? 1 : 0
        ]);

        // Recalculate the overall assessment response score
        $assessmentResponse = $answer->assessmentResponse;
        $totalQuestions = $assessmentResponse->answers()->count();
        $correctAnswers = $assessmentResponse->answers()->where('is_correct', true)->count();
        
        $finalScore = $totalQuestions > 0 
            ? round(($correctAnswers / $totalQuestions) * 100, 2)
            : 0;

        $assessmentResponse->update([
            'score' => $finalScore
        ]);

        return back()->with('success', 'Answer reviewed successfully');
    }
}