<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EvalMate') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div id="app">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-lg">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a class="text-2xl font-bold text-blue-600" href="{{ url('/') }}">
                    EvalMate
                </a>
                <div>
                    <ul class="flex space-x-6">
                        @auth
                            <li>
                                <a href="{{ route(Auth::user()->user_type === 'teacher' ? 'Dashboards.dashboard' : 'courses.index') }}" class="hover:text-blue-600">
                                    Home
                                </a>
                            </li>

                            <li>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->user_type) }})</li>

                            @if (Auth::user()->user_type === 'student')
                                <li><a href="{{ route('courses.index') }}" class="hover:text-blue-600">My Courses</a></li>
                                <li><a href="{{ route('profile.edit') }}" class="hover:text-blue-600">My Profile</a></li>
                            @elseif (Auth::user()->user_type === 'teacher')
                                <li><a href="{{ route('courses.index') }}" class="hover:text-blue-600">Courses I Teach</a></li>
                                <li><a href="{{ route('enrollments.create', ['course' => 1]) }}" class="hover:text-blue-600">Manage Enrollments</a></li>
                                <li><a href="{{ route('assessments.mark', ['assessmentId' => 1]) }}" class="hover:text-blue-600">Mark Assessments</a></li> <!-- Link to mark assessments -->
                            @endif

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="hover:text-blue-600">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @endauth

                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-blue-600">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-blue-600">Register</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-8">
            <div class="container mx-auto px-6">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Welcome Message -->
                <h1 class="text-4xl font-bold mb-6">Welcome to EvalMate</h1>
                <p class="mb-4">Your platform for peer reviews and course management.</p>

                <!-- Content -->
                @yield('content')

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4 mt-10">
            <div class="container mx-auto text-center">
                <p>&copy; {{ date('Y') }}  EvalMate. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
