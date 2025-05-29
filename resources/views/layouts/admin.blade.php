<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employee Assessment Platform') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-900 to-slate-900 min-h-screen text-gray-100">
    <!-- Navigation -->
    <nav class="fixed top-0 z-50 w-full bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-lg border-b border-slate-700/50">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="p-2 text-gray-400 rounded-lg lg:hidden hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="flex ml-2 md:mr-24">
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">Admin Panel</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div class="relative">
                            <button type="button" class="flex text-sm bg-gray-700 rounded-full focus:ring-4 focus:ring-gray-600" id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                <div class="relative w-8 h-8 overflow-hidden bg-gray-600 rounded-full">
                                    <svg class="absolute w-10 h-10 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-lg border-r border-slate-700/50 lg:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assessments.index') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Assessments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.employees.index') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        <span class="ml-3">Employees</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.analytics') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.profile.index') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Profile</span>
                    </a>
                </li>
               
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300"> 
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="URL_ADDRESS.w3.org/2000/svg">        
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Error Toaster -->
    @if ($errors->any())
    <div class="fixed top-24 right-4 z-40 max-w-sm w-full">
        <div class="bg-red-500/10 backdrop-blur-lg border border-red-500/50 rounded-lg shadow-lg overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-red-400">Please fix the following errors:</p>
                        <ul class="mt-2 text-sm text-red-300 space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button type="button" class="bg-transparent rounded-md inline-flex text-red-400 hover:text-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-x-hidden overflow-y-auto pt-16 lg:ml-64 transition-all duration-300">
        <main class="flex-1 px-4 pt-6 pb-8">
            @yield('content')
        </main>
    </div>

    <script>
        // Error toaster close functionality
        document.addEventListener('DOMContentLoaded', function() {
            const errorToaster = document.querySelector('.fixed.top-50.right-4');
            if (errorToaster) {
                const closeButton = errorToaster.querySelector('button');
                closeButton.addEventListener('click', function() {
                    errorToaster.remove();
                });

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    errorToaster.remove();
                }, 5000);
            }
        });

        // Mobile menu toggle
        document.getElementById('toggleSidebarMobile').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('toggleSidebarMobileHamburger').classList.toggle('hidden');
            document.getElementById('toggleSidebarMobileClose').classList.toggle('hidden');
        });
    </script>
        @stack('scripts')

</body>
</html>