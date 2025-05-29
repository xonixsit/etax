@extends('layouts.admin')

@section('title', 'Employees')

@section('content')
<main class="flex-1 px-6 py-6 space-y-4">
    @if (session('success'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="mb-4">
        <div class="flex items-center justify-between gap-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-100 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Employee List
                </h1>
                <p class="mt-2 text-gray-400 text-lg">Manage and monitor all employees</p>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.employees.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employees..." class="w-64 px-4 py-2 text-sm text-gray-200 bg-slate-800/60 border border-slate-700/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 placeholder-gray-400">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Employee
                </a>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="bg-slate-800/60 backdrop-blur-md rounded-xl shadow-2xl border border-slate-700/50 overflow-hidden">
            @if($employees->isEmpty())
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-300">No employees found</h3>
                <p class="mt-2 text-sm text-gray-400">Get started by adding a new employee.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-700/50">
                    <thead>
                        <tr class="bg-slate-900/30">
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Position</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach ($employees as $employee)
                        <tr class="hover:bg-slate-700/10 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-200">{{ $employee->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $employee->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $employee->department }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $employee->position }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">
                                @if ($employee->status == 'active')
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Active</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end gap-3">
    <!-- Edit Button -->
    <a href="{{ route('admin.employees.edit', $employee) }}"
       class="text-indigo-400 hover:text-indigo-300 transition-colors duration-200 group"
       title="Edit Employee">
        <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    </a>

    <!-- Delete Button -->
    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="inline"
          onsubmit="return confirm('Are you sure you want to delete this employee?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="text-red-400 hover:text-red-300 transition-colors duration-200 group"
                title="Delete Employee">
            <svg class="w-5 h-5 text-red-400 group-hover:text-red-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M10 14h4"></path>
            </svg>
        </button>
    </form>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-3.5 border-t border-slate-700/50">
                {{ $employees->links() }}
            </div>
            @endif
        </div>
</main>
@endsection