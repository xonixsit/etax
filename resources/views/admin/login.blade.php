<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Employee Assessment Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>

</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 to-slate-800 text-gray-200 min-h-screen flex flex-col items-center justify-center p-6">

    <main class="w-full max-w-md">
        <div class="bg-slate-800/60 backdrop-blur-md shadow-2xl rounded-xl p-8 md:p-10">
            <div class="text-center mb-8">
                <svg class="mx-auto h-12 w-auto text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-100 sm:text-4xl">Admin Portal</h1>
                <p class="mt-2 text-sm text-gray-400">Access the Employee Assessment Platform</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <strong class="font-semibold">Oops! Something went wrong.</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-300">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 placeholder-gray-500"
                               value="{{ old('email') }}" placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-300">Password</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-gray-100 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 placeholder-gray-500"
                               placeholder="••••••••">
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300/50 text-indigo-600 focus:ring-indigo-600 bg-white/10 focus:ring-offset-slate-900">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-400">Remember me</label>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 transition-colors duration-150 ease-in-out">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Don't have an account?
                <a href="{{ route('admin.register') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">Register</a>
            </p>

            <p class="mt-10 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Employee Assessment Platform. All rights reserved.
            </p>
        </div>
    </main>

</body>
</html>