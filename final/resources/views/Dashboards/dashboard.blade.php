@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-6">Course Management Dashboard</h2>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-10">
            <h3 class="text-2xl font-semibold mb-4">Upload Course Information</h3>
            <p class="text-gray-700 mb-4">Upload a text file to add course details including:</p>
            <ul class="list-disc list-inside text-gray-600 mb-6">
                <li>Course name and code</li>
                <li>Teachers (by email)</li>
                <li>Students (by email)</li>
                <li>Assessments (title, instructions, number of reviews, maximum score, due date, type)</li>
            </ul>
            <p class="text-gray-500 mb-4">Ensure the file follows this format:</p>
            <pre class="bg-gray-100 p-4 rounded-md text-sm text-gray-800">
Course: Course Code, Course Name
Teacher: teacher@example.com
Student: student1@example.com
Student: student2@example.com
Assessment: Title, Instructions, Number of Reviews, Maximum Score, Due Date, Type
            </pre>

            <form action="{{ route('courses.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-lg font-medium text-gray-700">Upload Course File (TXT)</label>
                    <input type="file" name="file" class="mt-2 mb-4 w-full border border-gray-300 p-2 rounded" required>
                    @error('file')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">
                    Upload Course
                </button>
            </form>
        </div>

       
        <div class="bg-white rounded-lg shadow-lg p-6 mb-10">
            <h3 class="text-2xl font-semibold mb-4">Your Courses</h3>
            <ul class="space-y-4">
                @auth
                    @if ($courses->isEmpty())
                        <li class="text-gray-600">No courses available.</li>
                    @else
                        @foreach ($courses as $course)
                            <li class="mb-4">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-xl text-blue-600 hover:underline">
                                    {{ $course->course_code }} - {{ $course->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endauth
            </ul>
        </div>

        @if (auth()->user()->role == 'teacher')
            <div class="bg-white rounded-lg shadow-lg p-6 mb-10">
                <h3 class="text-2xl font-semibold mb-4">Assign Peer Review Groups</h3>
                <p class="text-gray-700 mb-4">Randomly assign students to groups for peer reviews.</p>
                <form action="{{ route('groups.assign', $selectedAssessment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">
                        Assign Groups
                    </button>
                </form>
                <div class="mt-4">
                    <a href="{{ route('groups.view', $selectedAssessment->id) }}" class="text-blue-600 hover:underline">
                        View Assigned Groups
                    </a>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-semibold mb-4">Top Reviewers Leaderboard</h3>
            <p class="text-gray-700 mb-4">These are the top 5 reviewers based on reviewee ratings.</p>
            <ul class="space-y-2">
                @forelse ($topReviewers as $reviewer)
                    <li class="flex justify-between">
                        <span>{{ $reviewer->reviewer->name }}</span>
                        <span class="font-semibold">{{ number_format($reviewer->average_score, 2) }} / 5</span>
                    </li>
                @empty
                    <li>No reviewers rated yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
