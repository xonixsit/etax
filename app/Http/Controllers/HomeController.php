<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // In your controller method (e.g., HomeController@index)
    public function index()
    {
        $features = [
            [
                'title' => 'Assessment Creation',
                'description' => 'Build custom assessments with multiple question types (MCQ, paragraph, etc.)',
                'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6M12 12V4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'title' => 'Employee Management',
                'description' => 'Add, edit, and organize employees with role-based access',
                'icon' => 'M12 4v16m8-8H4a2 2 0 00-2 2v4a2 2 0 002 2h16a2 2 0 002-2v-4a2 2 0 00-2-2h-2'
            ],
            // Add more features here...
        ];

        $steps = [
            ['title' => 'Create Assessment', 'description' => 'Design assessments with due dates and question types'],
            ['title' => 'Assign to Employees', 'description' => 'Send assessments with employee-specific due dates'],
            ['title' => 'Monitor Submissions', 'description' => 'Track completion status and scores in real-time'],
            ['title' => 'Generate Reports', 'description' => 'Export detailed analytics and feedback reports']
        ];

        $benefits = [
            [
                'title' => 'Time-Saving',
                'description' => 'Automate scoring and reduce administrative workload',
                'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'
            ],
            [
                'title' => 'Real-Time Analytics',
                'description' => 'Get instant insights into employee performance trends',
                'icon' => 'M12 4v16m8-8H4a2 2 0 00-2 2v4a2 2 0 002 2h16a2 2 0 002-2v-4a2 2 0 00-2-2h-2'
            ],
            // Add more benefits...
        ];

        return view('welcome', compact('features', 'steps', 'benefits'));
    }
}
