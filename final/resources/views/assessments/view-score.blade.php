@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Score for {{ $assessment->title }}</h1>
    <p>Your Score: <strong>{{ $score }}</strong></p>
</div>
@endsection
