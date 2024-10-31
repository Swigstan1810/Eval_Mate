@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold mb-8 text-center"> Courses</h1>

        @if($courses->isEmpty())
            <p class="text-lg text-gray-600 text-center">You are not enrolled in any courses yet.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                        <a href="{{ route('courses.show', $course->id) }}" class="no-underline">
                            <h3 class="text-xl font-semibold mb-2 text-blue-600 hover:text-blue-500">{{ $course->name }}</h3>
                            <p class="text-gray-700 mb-4">
                                @if(!empty($course->description))
                                    {{ $course->description }}
                                @else
                                    No description available.
                                @endif
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
