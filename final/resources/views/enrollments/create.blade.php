@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-bold mb-5">Enroll Students in {{ $course->title }}</h2>

    <!-- Success and error messages -->
    @if (session('success'))
        <div class="bg-green-200 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-200 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Enrollment form -->
    <form method="POST" action="{{ route('enrollments.store', $course->id) }}">
        @csrf
        <div class="mb-4">
            <label for="student_id" class="block text-lg font-semibold mb-2">Select a Student:</label>
            <select name="student_id" id="student_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                @endforeach
            </select>
            @error('student_id')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="course_id" value="{{ $course->id }}">

        <!-- Submit button -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Enroll Student</button>
    </form>
</div>
@endsection
