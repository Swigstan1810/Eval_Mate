<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DASHBOARD</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <!-- Navigation -->
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a class="text-2xl font-bold text-blue-600" href="{{ url('/') }}">
                    Peer Review System
                </a>
                <div>
                    <ul class="flex space-x-6">
                        @auth
                            <li>{{ Auth::user()->name }} ({{ Auth::user()->role }})</li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="hover:text-blue-600">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-blue-600">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-blue-600">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-blue-600 text-white">
            <div class="container mx-auto px-6 py-16 text-center">
                <h1 class="text-5xl font-bold mb-6">Welcome to EvalMate</h1>
                <p class="text-xl mb-12">A platform for peer reviews and course management.</p>
                <a href="{{ route('login') }}" class="bg-white text-blue-600 font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-gray-200 transition ease-in-out duration-150">
                    Get Started
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-gray-100 py-12">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-bold text-center mb-12">Why Choose Us?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <img class="w-16 mx-auto mb-4" src="./images/s1.webp" alt="Feature Icon 1">
                        <h3 class="text-2xl font-semibold mb-2">For Students</h3>
                        <p class="text-gray-600">Manage your enrollments, submit peer reviews, and monitor your progress in one place.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <img class="w-16 mx-auto mb-4" src="./images/t1.webp" alt="Feature Icon 2">
                        <h3 class="text-2xl font-semibold mb-2">For Teachers</h3>
                        <p class="text-gray-600">Oversee multiple courses, track student progress, and provide valuable feedback efficiently.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <img class="w-16 mx-auto mb-4" src="./images/p1.webp" alt="Feature Icon 3">
                        <h3 class="text-2xl font-semibold mb-2">Peer Review</h3>
                        <p class="text-gray-600">A seamless platform for students and teachers to engage in quality peer reviews and feedback.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="bg-white py-16">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-6">Ready to Join?</h2>
                <p class="text-gray-600 mb-8">Sign up now and start managing your courses and peer reviews efficiently.</p>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-blue-500 transition ease-in-out duration-150">
                    Sign up
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-6 text-center">
                <p>&copy; {{ date('Y') }} EvalMate. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
