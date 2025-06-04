<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{

    public function index()
    {
        $feedbacks = Feedback::all();
        return view('employee.feedback', compact('feedbacks'));
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('employee.feedback', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ' . json_encode($request->all()));
        // $validatedData = $request->validate([
        //     'feedback_text' => 'required|string',
        // ]);
        // Validates: does 123 exist in users.id?
        $feedbackStore = Feedback::create([
            'user_id' => Auth::user()->id,
            'feedback_text' => $request->feedback,
        ]);

        // Feedback::create($validatedData);
        if($feedbackStore)
         Log::info('Feedback submitted successfully', ['user_id' => Auth::user()->id]);
        else
         Log::error('Failed to submit feedback',$feedbackStore);

        return redirect()->route('employee.feedback.index')
                         ->with('success', 'Feedback submitted successfully');
    }
}