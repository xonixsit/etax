<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use function PHPUnit\Framework\isArray;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // Log::info('User Role', [
        //     'user_id' => $user->id,
        //     'user_email' => $user->email,
        //     'user_role' => $user->roles->pluck('name')->toArray(),
        // ]);
        
        if(!$user){
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user_role = $user->roles->pluck('name')->toArray();
        Log::info('user role', $user_role);
        //condition for user is not employee User Role {"user_id":2,"user_email":"userone@gmail.com","user_role":["employee"]} 
        //check empty array when admin login User Role {"user_id":1,"user_email":"admin@xonixs.com","user_role":[]}

        // Check if user is not an employee
        if (!in_array('employee', $user_role)) {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

        Log::info('$credentials', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // // Check if user has admin role and redirect to admin dashboard
        // $user = User::where('email', $request->email)->first();

        // Log::info('User Role', [
        //     'user_id' => $user->id,
        //     'user_email' => $user->email,
        //     'user_role' => $user->roles->pluck('name')->toArray(),
        //     'ip' => $request->ip(),
        //     'user_agent' => $request->userAgent(),
        //     'timestamp' => now(),
        // ]);
        if ($user && $user->hasRole('admin')) {
            Auth::login($user);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalAssessments = Assessment::count();
        $activeEmployees = User::role('employee')->count();
        $pendingReviews = AssessmentResponse::where('status', 'pending_review')->count();
        $totalResponses = AssessmentResponse::count();
        // $completedResponses = AssessmentResponse::where('status', 'completed')->count();
        $completedResponses = AssessmentResponse::whereRaw('LOWER(TRIM(status)) = ?', ['completed'])->count();

        Log::info("Total Responses: $totalResponses, Completed Responses: $completedResponses");

        // dd($totalResponses, $completedResponses);

        $completionRate = $totalResponses > 0
            ? round(($completedResponses / $totalResponses) * 100) . '%'
            : '0%';
        // dd($completionRate);

        $users = User::role('employee')->withCount([
            'assessmentResponses as completed_count' => function ($query) {
                $query->where('status', 'completed');
            },
            'assessmentResponses as total_count'
        ])->get();

        if ($users->count() > 0) {
            $averageCompletionRate = round(
                $users->map(function ($user) {
                    return $user->total_count > 0 ? ($user->completed_count / $user->total_count) : 0;
                })->average() * 100
            ) . '%';
        } else {
            $averageCompletionRate = '0%';
        }

        $recentActivities = AssessmentResponse::with(['user', 'assessment'])
            ->latest() // orders by created_at DESC
            ->take(4)  // get the 4 most recent
            ->get();


        return view('admin.dashboard', compact(
            'totalAssessments',
            'activeEmployees',
            'pendingReviews',
            'completionRate',
            'recentActivities'
        ));
    }
}
