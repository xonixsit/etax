<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Employee Assessment Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @if (app()->environment('local'))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <script src="{{ Vite::asset('resources/js/app.js') }}" defer></script>
    @endif
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 to-slate-800 text-gray-200">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-slate-800/60 backdrop-blur-md border-r border-slate-700/50">
                <div class="flex items-center mb-5 p-2">
                    <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span class="text-xl font-semibold">Employee Portal</span>
                </div>

                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('employee.dashboard') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.assessments.index') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">Assessments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.results') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">Results</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.profile') }}" class="flex items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">     
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="URL_ADDRESS.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="ml-3">Profile</span>
                        </a>
                    </li>
                            
                            
                    <!-- Add more sidebar items as needed -->

                </ul>

                <div class="pt-4 mt-4 space-y-2 border-t border-slate-700/50">
                </ul>

                <div class="pt-4 mt-4 space-y-2 border-t border-slate-700/50">
                    <form method="POST" action="{{ route('employee.logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center p-2 text-base text-gray-300 rounded-lg hover:bg-slate-800/70 group transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="ml-3">Sign out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 h-full overflow-x-hidden overflow-y-auto lg:ml-64 transition-all duration-300">
            <!-- Top Navigation -->
            <nav class="fixed top-0 z-30 w-full bg-slate-800/60 backdrop-blur-md border-b border-slate-700/50 transition-all duration-300">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start">
                            <button type="button" class="inline-flex items-center p-2 text-sm text-gray-400 rounded-lg lg:hidden hover:bg-slate-800/70 focus:outline-none focus:ring-2 focus:ring-slate-700/50">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center ml-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-300">{{ Auth::guard('employee')->user()->name }}</span>
                                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('employee')->user()->name) }}&background=6366f1&color=fff" alt="user photo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="pt-16">
                @if (session('success'))
                    <div class="max-w-7xl mx-auto px-4 mb-4">
                        <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
        @stack('scripts')
    </div>
</body>
</html>