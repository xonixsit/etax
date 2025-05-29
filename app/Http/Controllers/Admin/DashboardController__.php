<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {

        /** @var \App\Models\User $user */

        $user = Auth::user();

        $totalAssessments = Assessment::count();
        // $activeEmployees = 0; 
        // get active employees count
        $activeEmployees =  User::role('employee')->count(); // if using roles
        
        // using Spatie's HasRoles trait
        $pendingReviews = 0; // To be implemented
        $completionRate = '20%'; // To be implemented
        $recentActivities = []; // To be implemented

        Log::info('Assigned users', [
            'count' =>  $activeEmployees 
        ]);
        return view('admin.dashboard', compact(
            'totalAssessments',
            'activeEmployees',
            'pendingReviews',
            'completionRate',
            'recentActivities'
        ));
    }
}