@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold mb-6">{{ $course->name }} ({{ $course->course_code }})</h2>
        <div class="mb-4">
            <strong>Instructor(s):</strong>
            
            @if($course->teachers->isNotEmpty())
                <ul>
                    @foreach($course->teachers as $teacher)
                        <li>{{ $teacher->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>No instructors assigned.</p>
            @endif
        </div>

        <h3 class="text-xl font-semibold mb-4">Assessments</h3>
        @if ($assessments->isEmpty())
            <p>No assessments available for this course.</p>
        @else
            <ul class="list-disc pl-6">
                @foreach ($assessments as $assessment)
                    <li class="mb-2">
                        <a href="{{ route('assessments.show', $assessment->id) }}" class="text-blue-600 hover:text-blue-400">
                            {{ $assessment->title }} (Due: {{ $assessment->due_date->format('F j, Y') }})
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if (auth()->user()->isTeacher())
            <a href="{{ route('assessments.create', $course->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">
                Add Assessment
            </a>
        @endif
    </div>
@endsection
