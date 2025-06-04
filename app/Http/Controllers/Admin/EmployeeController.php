<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{

        public function index(Request $request)
{
    $query = User::role('employee');

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%");
        });
    }

    $allowedSortColumns = ['name', 'email', 'department', 'position', 'status'];
    $sort = in_array($request->query('sort'), $allowedSortColumns) 
        ? $request->query('sort') 
        : 'name';
    $direction = $request->query('direction', 'asc');

    // Apply sorting to the existing query
    $employees = $query
        ->orderBy($sort, $direction)
        ->paginate(15)
        ->withQueryString(); // Retain query parameters in pagination links

    return view('admin.employees.index', compact('employees', 'sort', 'direction'));
}

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $employeeRole = Role::where('name', 'employee')->first();
            if (!$employeeRole) {
                throw new \Exception('Employee role does not exist');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'department' => $validated['department'],
                'position' => $validated['position'],
                'status' => $validated['status'],
            ]);

            $user->assignRole($employeeRole);

            Log::info('Employee created: ' . $user->name);

            //add error log in case db creation level faild

            return redirect()->route('admin.employees.index')
                ->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
           
            Log:info('Failed to create employee: '. $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    public function edit(User $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}