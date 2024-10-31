@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scores for {{ $assessment->title }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->pivot->score }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
