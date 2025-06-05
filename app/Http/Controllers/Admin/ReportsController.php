<?php

namespace App\Http\Controllers\Admin;
use Maatwebsite\Excel\Facades\Excel; // If using Laravel Excel
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResponse;
use App\Models\QuestionResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
// No need for direct PhpSpreadsheet imports unless customizing
class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = AssessmentResponse::with(['assessment', 'employee'])
    ->whereIn('status', ['pending_review', 'completed', 'in_progress']);

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('assessment_id')) {
            $query->where('assessment_id', $request->assessment_id);
        }

        // Get paginated results
        $responses = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get all employees and assessments for filters
        $employees = User::role('employee')->orderBy('name')->get();
        $assessments = Assessment::orderBy('title')->get();

        return view('admin.reports.index', compact('responses', 'employees', 'assessments'));
    }

    public function export(Request $request)
{
    $query = AssessmentResponse::with([
        'assessment',
        'employee',
        'answers.question' // Load answers and their questions
    ])->where('status', 'completed');

    // Apply filters
    if ($request->filled('start_date')) {
        $query->whereDate('completed_at', '>=', $request->start_date); // Use completed_at
    }

    if ($request->filled('end_date')) {
        $query->whereDate('completed_at', '<=', $request->end_date);
    }

    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->filled('assessment_id')) {
        $query->where('assessment_id', $request->assessment_id);
    }

    $responses = $query->orderBy('completed_at', 'desc')->get();

    // Log details safely
    Log::info('Exporting reports', [
        'count' => $responses->count(),
        'first_item' => $responses->isNotEmpty() ? $responses->first()->only(['id', 'employee_id', 'assessment_id', 'score', 'status']) : null
    ]);

        $headers = [
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename="assessment_reports.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($responses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Employee', 'Assessment', 'Score', 'Completed At']);

            foreach ($responses as $response) {
                fputcsv($file, [
                    $response->user?->name ?? 'N/A',
                    $response->assessment?->title ?? 'N/A',
                    $response->score ?? 'N/A',
                    $response->completed_at?->format('Y-m-d H:i:s') ?? 'N/A'
                ]);
            }

            fclose($file);
        };


        return Response::stream($callback, 200, $headers);
}

    public function show(AssessmentResponse $response)
    {
        // Load the assessment response with related data
        $response->load([
            'assessment',
            'user',
            'answers.question'
        ]);

        return view('admin.reports.show', compact('response'));
    }

    public function statistics()
    {
        // Get overall statistics
        $stats = [
            'total_assessments' => Assessment::count(),
            'total_responses' => AssessmentResponse::where('status', 'completed')->count(),
            'average_score' => AssessmentResponse::where('status', 'completed')
                ->avg('score'),
            'pass_rate' => $this->calculatePassRate()
        ];

        // Get assessment completion trends
        $trends = AssessmentResponse::where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(score) as average_score')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
            
        return view('admin.reports.statistics', [
                'stats' => $stats,
                'trends' => $trends
            ]);
        // return response()->json([
        //     'success' => true,
        //     'stats' => $stats,
        //     'trends' => $trends
        // ]);
    }

    private function calculatePassRate()
    {
        $total = AssessmentResponse::where('status', 'completed')->count();
        if (!$total) return 0;

        $passed = AssessmentResponse::where('status', 'completed')
            ->whereHas('assessment', function ($query) {
                $query->whereColumn('assessment_responses.score', '>=', 'assessments.passing_score');
            })
            ->count();

        return ($passed / $total) * 100;
    }

    public function reviewAnswer(Request $request, $answerId)
    {
        $answer = QuestionResponse::findOrFail($answerId);
        
        // Verify this is a paragraph answer
        if ($answer->question->type !== 'paragraph') {
            return back()->with('error', 'Only paragraph answers can be reviewed.');
        }

        // Update the answer status based on admin review
        $answer->update([
            'is_correct' => $request->status === 'correct',
            'score' => $request->status === 'correct' ? 100 : 0
        ]);

        //check all paragraph questions are reviewed means not 
        $assessmentResponse = $answer->assessmentResponse;
        $unreviewedQuestions = $assessmentResponse->answers()
            ->where('question_id', '!=', $answer->question_id)
            ->whereNull('is_correct')
            ->count();

        // Recalculate the overall assessment response score
        $response = $answer->assessmentResponse;
        $totalQuestions = $response->assessment->questions()->count();
        $correctAnswers = $response->answers()->where('is_correct', true)->count();
        $newScore = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
        
        $response->update(['score' => $newScore]);

        return back()->with('success', 'Answer review status updated successfully.');
    }

    //write a function to check all paragraph questions are reviewed or not
    public function isAllReviewed($assessmentResponseId)
    {
        $response = AssessmentResponse::findOrFail($assessmentResponseId);
        $unreviewedQuestions = $response->answers()
            ->whereNull('is_correct')
            ->count();

        return $unreviewedQuestions === 0;
    }

    //write employee assessment completed status
    public function complete($assessmentResponseId)
    {
    Log::info('Assessment completed: ' . $assessmentResponseId); // Log the inf

        $response = AssessmentResponse::findOrFail($assessmentResponseId);
        $response->update(['status' => 'completed']);
        Log::info('Assessment completed: ' . $response->id); // Log the inf
        return back()->with('success', 'Assessment completed successfully.');
    }
}