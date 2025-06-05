<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Assessment Platform</title>
 <!-- Fonts -->
 <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-green-500 text-white py-20">
    <div class="bg-gradient-to-r from-blue-600 to-green-500 py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Employee Assessment Platform</h1>
        <p class="text-xl text-white max-w-2xl mx-auto mb-8">
            Efficiently create, manage, and analyze employee assessments with modern tools.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
    <a href="#features"
        class="px-6 py-3 bg-white text-blue-600 rounded-full font-semibold flex items-center transition duration-200 hover:bg-blue-100">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Explore Features
    </a>
    <a href="#demo"
        class="px-6 py-3 bg-white text-green-600 rounded-full font-semibold flex items-center transition duration-200 hover:bg-green-100">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3M8 7l4-4m0 0l4 4m-4-4v4m-4 4H4m0 0h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
        </svg>
        Schedule Demo
    </a>
</div>
    </div>
</div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-semibold">Key Features</h2>
                <p class="text-gray-600">Designed to streamline assessment workflows</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium">Assessment Creation</h3>
                    </div>
                    <p class="text-gray-600">Build custom assessments with multiple question types (MCQ, paragraph, etc.)</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4a2 2 0 00-2 2v4a2 2 0 002 2h16a2 2 0 002-2v-4a2 2 0 00-2-2H12z" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium">Employee Management</h3>
                    </div>
                    <p class="text-gray-600">Add, edit, and organize employees with role-based access</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-semibold">How It Works</h2>
                <p class="text-gray-600">A simple 4-step process for seamless assessment management</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <span class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                            1
                        </span>
                        <h3 class="text-lg font-medium">Create Assessment</h3>
                    </div>
                    <p class="text-gray-600">Design assessments with due dates and question types</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <span class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                            2
                        </span>
                        <h3 class="text-lg font-medium">Assign to Employees</h3>
                    </div>
                    <p class="text-gray-600">Send assessments with employee-specific due dates</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <span class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                            3
                        </span>
                        <h3 class="text-lg font-medium">Monitor Submissions</h3>
                    </div>
                    <p class="text-gray-600">Track completion status and scores in real-time</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <span class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                            4
                        </span>
                        <h3 class="text-lg font-medium">Generate Reports</h3>
                    </div>
                    <p class="text-gray-600">Export detailed analytics and feedback reports</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-semibold">Why Choose Us?</h2>
                <p class="text-gray-600">Benefits that set us apart</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <h3 class="text-lg font-medium">Time-Saving</h3>
                    </div>
                    <p class="text-gray-600">Automate scoring and reduce administrative workload</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4a2 2 0 00-2 2v4a2 2 0 002 2h16a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                        </svg>
                        <h3 class="text-lg font-medium">Real-Time Analytics</h3>
                    </div>
                    <p class="text-gray-600">Get instant insights into employee performance trends</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 transition duration-200 hover:shadow-2xl">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium">Secure Access</h3>
                    </div>
                    <p class="text-gray-600">Role-based permissions and encrypted data storage</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Employee Experience -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-semibold">See it in Action</h2>
                <p class="text-gray-600">Watch our demo to understand how it works</p>
            </div>
            <div class="flex justify-center">
                <button onclick="showDemoModal()" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-semibold transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M14.752 18.468a6 6 0 01-9.012-9.012L5 7.59V18a2 2 0 002 2h8a2 2 0 002-2v-4a2 2 0 00-2-2h-2" />
                    </svg>
                    Watch Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Employee Dashboard Mockup -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-semibold">Employee Experience</h2>
                <p class="text-gray-600">Secure and intuitive assessment taking</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                    <div class="flex items-center mb-4">
                        <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <h3 class="text-lg font-medium">Online Assessment Interface</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-600">Time-Tracking Enabled Assessments</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-600">Real-Time Submission Feedback</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-600">Progressive Question Loading</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                    <div class="flex items-center mb-4">
                        <svg class="w-10 h-10 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4a2 2 0 00-2 2v4a2 2 0 002 2h16a2 2 0 002-2v-4a2 2 0 00-2-2H12z" />
                        </svg>
                        <h3 class="text-lg font-medium">Employee Dashboard</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-600">View Assessment Results</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-600">Submit Feedback Post-Completion</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-green-500 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-semibold mb-6">Ready to Elevate Employee Assessments?</h2>
            <p class="text-lg mb-8">Start managing assessments with confidence today.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admin.register') }}" class="px-8 py-3 bg-white text-blue-600 rounded-full font-semibold transition duration-200 hover:bg-blue-100">
                    Get Started
                </a>
                <a href="#contact" class="px-8 py-3 bg-white text-green-600 rounded-full font-semibold transition duration-200 hover:bg-green-100">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Employee Assessment Platform</h3>
                    <p class="text-gray-400">© 2024 Your Company. All rights reserved.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact Support</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Knowledge Base</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Demo Modal -->
    <div id="demo-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <button onclick="hideDemoModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="text-2xl font-semibold mb-4">Watch a Demo</h2>
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ " frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <script>
        function showDemoModal() {
            document.getElementById('demo-modal').classList.remove('hidden');
        }
        
        function hideDemoModal() {
            document.getElementById('demo-modal').classList.add('hidden');
        }
    </script>
</body>
</html>