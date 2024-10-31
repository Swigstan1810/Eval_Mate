@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Edit Assessment</h1>

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="title">Assessment Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $assessment->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $assessment->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $assessment->due_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="total_marks">Total Marks</label>
            <input type="number" name="total_marks" id="total_marks" class="form-control" value="{{ old('total_marks', $assessment->total_marks) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Assessment</button>
        <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
