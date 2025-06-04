<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResponse;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Feedback;
use App\Models\QuestionResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $feedback = Feedback::where('feedback_text', 'like', '%' . $search . '%')->paginate(10);
        return view('admin.feedback', compact('feedback'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

}