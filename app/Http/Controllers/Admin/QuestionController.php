<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function destroy(Assessment $assessment, Question $question)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Question deletion started', [
                'assessment_id' => $assessment->id,
                'question_id' => $question->id
            ]);

            $question->delete();

            \Illuminate\Support\Facades\Log::info('Question deleted successfully', [
                'assessment_id' => $assessment->id,
                'question_id' => $question->id
            ]);

            return redirect()
                ->route('admin.assessments.show', $assessment)
                ->with('success', 'Question deleted successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to delete question', [
                'error' => $e->getMessage(),
                'assessment_id' => $assessment->id,
                'question_id' => $question->id
            ]);

            return redirect()
                ->route('admin.assessments.show', $assessment)
                ->with('error', 'Failed to delete question. Please try again.');
        }
    }

    public function create(Assessment $assessment)
    {
        return view('admin.assessments.questions.create', compact('assessment'));
    }

    public function edit(Assessment $assessment, Question $question)
    {
        return view('admin.assessments.questions.edit', compact('assessment', 'question'));
    }

    public function store(Request $request, Assessment $assessment)
    {
        \Illuminate\Support\Facades\Log::info('Question submission started', ['assessment_id' => $assessment->id]);
        \Illuminate\Support\Facades\Log::debug('Request data:', ['data' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:multiple_choice,single_selection,short_answer,paragraph',
            'text' => 'required|string|max:1000',
            'options' => 'required_if:type,multiple_choice,single_selection|array|min:2',
            'options.*' => 'required_if:type,multiple_choice,single_selection|string|max:255',
            'correct_answer' => 'required_if:type,single_selection|integer|min:0',
            'correct_answers' => 'required_if:type,multiple_choice|array|min:1',
            'correct_answers.*' => 'required_if:type,multiple_choice|integer|min:0',
            'word_limit' => 'nullable|integer|min:1'
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'assessment_id' => $assessment->id
            ]);
            return redirect()
                ->route('admin.assessments.questions.create', $assessment)
                ->withErrors($validator)
                ->withInput();
        }

        \Illuminate\Support\Facades\Log::info('Validation passed', ['assessment_id' => $assessment->id]);

        $question = new Question([
            'type' => $request->type,
            'text' => $request->text,
            'options' => in_array($request->type, ['multiple_choice', 'single_selection']) ? $request->options : null,
            'correct_answer' => $request->type === 'multiple_choice' ? 
                implode(',', $request->correct_answers) : 
                ($request->type === 'single_selection' ? $request->correct_answer : null),
            'word_limit' => $request->word_limit,
        ]);
        
        try {
            $assessment->questions()->save($question);
            \Illuminate\Support\Facades\Log::info('Question saved successfully', [
                'question_id' => $question->id,
                'assessment_id' => $assessment->id
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to save question', [
                'error' => $e->getMessage(),
                'assessment_id' => $assessment->id
            ]);
            return redirect()
                ->route('admin.assessments.questions.create', $assessment)
                ->with('error', 'Failed to save question. Please try again.');
        }

        return redirect()
            ->route('admin.assessments.show', $assessment)
            ->with('success', 'Question added successfully!');
    }

    public function update(Request $request, Assessment $assessment, Question $question)
    {
        \Illuminate\Support\Facades\Log::info('Question update started', ['assessment_id' => $assessment->id, 'question_id' => $question->id]);
        \Illuminate\Support\Facades\Log::debug('Request data:', ['data' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:multiple_choice,single_selection,short_answer,paragraph',
            'text' => 'required|string|max:1000',
            'options' => 'required_if:type,multiple_choice,single_selection|array|min:2',
            'options.*' => 'required_if:type,multiple_choice,single_selection|string|max:255',
            'correct_answer' => 'required_if:type,single_selection|integer|min:0',
            'correct_answers' => 'required_if:type,multiple_choice|array|min:1',
            'correct_answers.*' => 'required_if:type,multiple_choice|integer|min:0',
            'word_limit' => 'nullable|integer|min:1'
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'assessment_id' => $assessment->id,
                'question_id' => $question->id
            ]);
            return redirect()
                ->route('admin.assessments.questions.edit', [$assessment, $question])
                ->withErrors($validator)
                ->withInput();
        }

        \Illuminate\Support\Facades\Log::info('Validation passed', ['assessment_id' => $assessment->id, 'question_id' => $question->id]);

        $question->update([
            'type' => $request->type,
            'text' => $request->text,
            'options' => in_array($request->type, ['multiple_choice', 'single_selection']) ? $request->options : null,
            'correct_answer' => $request->type === 'multiple_choice' ? 
                implode(',', $request->correct_answers) : 
                ($request->type === 'single_selection' ? $request->correct_answer : null),
            'word_limit' => $request->word_limit,
        ]);

        \Illuminate\Support\Facades\Log::info('Question updated successfully', [
            'question_id' => $question->id,
            'assessment_id' => $assessment->id
        ]);

        return redirect()
            ->route('admin.assessments.show', $assessment)
            ->with('success', 'Question updated successfully!');
    }
}