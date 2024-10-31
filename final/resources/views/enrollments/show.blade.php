@extends('layouts.app')

@section('content')
<h1>{{ $course->name }} ({{ $course->course_code }})</h1>
<p>Teacher: {{ $teacher->name }}</p>

<h2>Assessments</h2>
<ul>
    @foreach($assessments as $assessment)
        <li>
            <a href="{{ route('assessments.show', $assessment->id) }}">
                {{ $assessment->title }} - Due: {{ $assessment->due_date->format('M d, Y') }}
            </a>
        </li>
    @endforeach
</ul>

@if(auth()->user()->isTeacher())
    <a href="{{ route('assessments.create', $course->id) }}">Add Assessment</a>
    <a href="{{ route('courses.enroll', $course->id) }}">Enroll Students</a>
@endif
@endsection
