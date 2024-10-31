@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">{{ $assessment->title }} - Mark</h1>

    <!-- Button to View Assigned Groups -->
    @auth
        <div class="mb-4">
            <a href="{{ route('groups.view', $assessment->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">
                View Assigned Groups
            </a>
        </div>
    @endauth

    <table class="table-auto w-full mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2">Student</th>
                <th class="px-4 py-2">Submitted Reviews</th>
                <th class="px-4 py-2">Received Reviews</th>
                <th class="px-4 py-2">Score</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $data)  
            <tr>
                <td class="border px-4 py-2">{{ $data['student']->name }}</td>
                <td class="border px-4 py-2">{{ $data['submitted_reviews'] }}</td>
                <td class="border px-4 py-2">{{ $data['received_reviews'] }}</td>
                <td class="border px-4 py-2">
                    <form action="{{ route('assessments.assignScore', ['assessmentId' => $assessment->id, 'studentId' => $data['student']->id]) }}" method="POST">
                        @csrf
                        <input type="number" name="score" value="{{ old('score', $data['student']->pivot->score ?? '') }}" max="{{ $assessment->maximum_score }}" min="0" class="border p-2 w-20">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">Assign Score</button>
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('reviews.show', $data['student']->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">View Reviews</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $students->links() }}  
    </div>
</div>
@endsection
