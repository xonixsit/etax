<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Http\Requests\Admin\CreateAssessmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::withCount('questions')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.assessments.index', compact('assessments'));
    }

    public function create()
    {
        $months =  $this->getAvailableMonths();

        return view('admin.assessments.create',compact('months'));
    }

    public function store(CreateAssessmentRequest $request)
    {
        Log::info('Starting assessment creation process', ['request_data' => $request->all()]);
        $validated = $request->validated();
        unset($validated['month']);
        unset($validated['year']);

        //get month from due_date
        $validated['month'] = date('m', strtotime($validated['due_date']));
        $validated['year'] = date('Y', strtotime($validated['due_date']));
        Log::info('Validated assessment data', ['validated_data' => $validated]);
        //do not validate month and year
       Log::info('Due date', ['due_date' => $request->due_date]);
        //validate due_date is not in the past
        if ($request->due_date < now()) {
            Log::info('Due date', ['due_date' => $request->due_date]);

            return back()
                ->withInput()
                ->with('error', 'Due date cannot be in the past.');
        }   
        try {
            // Create the assessment
            $assessment = Assessment::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'month' => $validated['month'],
                'year' => $validated['year'],
                'due_date' => $validated['due_date'],
                'passing_score' => $validated['passing_score'],
                'is_published' => false // Default to draft state
            ]);
            // Log::info('Created assessment:', $assessment->toArray());

            Log::info('Assessment created successfully', ['assessment_id' => $assessment->id]);

            session()->flash('success', 'Assessment created successfully! You can now add questions.');

            return redirect()->route('admin.assessments.questions.create', $assessment);

        } catch (\Exception $e) {
            Log::error('Failed to create assessment', ['error' => $e->getMessage(), 'error_code' => $e->getCode(), 'trace' => $e->getTraceAsString()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create assessment. Please try again.');
        }
    }

    public function show(Assessment $assessment)
    {
        return view('admin.assessments.show', compact('assessment'));
    }

    public function edit($id)
    {
        $assessment = Assessment::findOrFail($id);
        return view('admin.assessments.edit', compact('assessment'));
    }

    private function getAvailableMonths()
    {
        $currentMonth = now()->month;
        $allMonths = [
            1 => 'January', 2 => 'February', 3 => 'March',
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];
    
        return array_filter($allMonths, fn($k) => $k >= $currentMonth, ARRAY_FILTER_USE_KEY);
    }
    

    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:5|max:180',
            'passing_score' => 'required|integer|min:0|max:100',
            'due_date' => 'required|date',
            'is_published' => 'required|boolean'
        ]);

        try {
            $assessment->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'passing_score' => $validated['passing_score'],
                'due_date' => $validated['due_date'],
                'is_published' => $validated['is_published']
            ]);

            session()->flash('success', 'Assessment updated successfully!');
            return redirect()->route('admin.assessments.show', $assessment);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update assessment. Please try again.');
        }
    }
    public function destroy($id)
    {
        try {
            $assessment = Assessment::findOrFail($id);

            // Delete the assessment and its related questions
            $assessment->questions()->delete();
            $assessment->delete();

            session()->flash('success', 'Assessment deleted successfully!');
            return redirect()->route('admin.assessments.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete assessment. Please try again.');
        }
    }

    public function createQuestion(Assessment $assessment)
    {
        return view('admin.assessments.questions.create', compact('assessment'));
    }

    public function storeQuestion(Request $request, Assessment $assessment)
    {
        Log::info('Starting question creation process for assessment', [
            'assessment_id' => $assessment->id,
            'request_data' => $request->except(['_token'])
        ]);

        $validated = $request->validate([
            'type' => 'required|in:multiple_choice,single_selection,short_answer,paragraph',
            'text' => 'required|string',
            'options' => 'required_if:type,multiple_choice,single_selection|array|min:2|nullable',
            'options.*' => 'required_if:type,multiple_choice,single_selection|string|distinct|max:255',
            'correct_answer' => 'required_if:type,multiple_choice,single_selection|integer|min:0|nullable',
            'word_limit' => 'nullable|integer|min:1'
        ]);

        try {
            Log::info('Validated assessment data', ['validated_data' => $validated]);

            // Process options and correct answer based on question type
            $questionData = [
                'type' => $validated['type'],
                'text' => $validated['text']
            ];

            if (in_array($validated['type'], ['multiple_choice', 'single_selection'])) {
                $questionData['options'] = array_values($validated['options']);
                $questionData['correct_answer'] = (string) $validated['correct_answer'];
                $questionData['word_limit'] = null;
            } else {
                $questionData['options'] = null;
                $questionData['correct_answer'] = null;
                $questionData['word_limit'] = $request->filled('word_limit') ? $validated['word_limit'] : null;
            }
            // //save single selection options
            // if ($validated['type'] === 'single_selection') {
            //     $questionData['options'] = array_values($validated['options']);
            // }
            // Remove duplicate question creation
            $assessment->questions()->create($questionData);

            Log::info('questionData created successfully', ['assessment_id' => $assessment->id]);

            session()->flash('success', 'Question added successfully!');
            return redirect()->route('admin.assessments.questions.create', $assessment);
        } catch (\Exception $e) {
            Log::error('Failed to create assessment', ['error' => $e->getMessage(), 'error_code' => $e->getCode(), 'trace' => $e->getTraceAsString()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to add question. Please try again.');
        }
    }
}
