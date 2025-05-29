<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Traits\HasRoles;
use App\Models\AssessmentResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{

    public function index()
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Get assigned assessments that haven't been started
        $assignedAssessments = $user->assessments()->get();
        $assessments = Assessment::withCount('questions')
            ->orderBy('created_at', 'desc')
            ->paginate(10)->where('is_published', true)
            ->get();
        Log::info('Assigned assessments', [
            'count' => $assessments->count(),
            'assessments' => $assignedAssessments->toArray(),
            $assessments
        ]);

        $totalAssessments = Assessment::count();

        Log::info('Assigned assessments', [
            'count' => $assessments->count(),
            'assessments' => $assignedAssessments->toArray(),
            $totalAssessments => $totalAssessments,
            $assessments
        ]);

        // Get assessment responses
        $responses = $user->assessmentResponses()
            ->with('assessment')
            ->get();

        // Calculate counts
        //include only published assessments

        $pendingCount = $assessments->where('is_published', true)->count() + 
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
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'averageScore' => round($averageScore, 1),
            'recentAssessments' => $recentAssessments
        ]);
    }
    /**
     * Show the employee login form.
     */
    public function showLoginForm()
    {
        return view('employee.login');
    }

    /**
     * Handle an employee authentication attempt.
     */
    public function login(Request $request)
    {
        Log::info('Executing employee login function');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            /** @var \App\Models\User $user */
            // Check if user has employee role
            if (!$user->hasRole('employee')) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['This account does not have employee access.'],
                ]);
            }
            //check if employee is active
            if ($user->status == 'inactive') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['This account is inactive.'],
                ]);
            }
            $request->session()->regenerate();

            // Log successful login
            Log::info('Employee login successful', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);
            if (Auth::guard('employee')->attempt($credentials)) {
                return redirect()->intended(route('employee.dashboard'));
            }

            // return redirect()->intended(route('employee.dashboard'));
        }

        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    //user profile page
    public function profile(Request $request, User $employee)
    {
        $user = Auth::user();

        return view('employee.profile', compact('user'));
    }

    //user profile update
    public function update(Request $request, User $employee)
    {
        $user = Auth::id();

        Log::info('Updating user profile', [
            'user_id' => Auth::id(),
            'user_email' => $request->email,
            'user_name' => $request->name,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

       
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $validated['password'] = Hash::make($request->password);
        }
        //validate current password with existing
        if (!Hash::check($request->current_password, $employee->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match our records.'],
            ]);
        }
        
        Log::info('Validated data:', $validated);
        Log::info('Auth user ID: ' . Auth::id());
        Log::info('Target employee ID: ' . $employee->id);

        
        $isUpdate = $employee->update($validated);
        Log::info(['isUpdated' => $isUpdate]);
        
        if (!$isUpdate) {
            Log::warning('Employee update returned false.');
        }        

        return redirect()->route('employee.profile')
            ->with('success', 'Profile updated successfully.');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
