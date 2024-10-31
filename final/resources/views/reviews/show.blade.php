@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">{{ $student->name }}'s Peer Reviews</h1>

    <h2 class="text-xl font-bold mb-2">Submitted Reviews</h2>
    @if ($submittedReviews->isEmpty())
        <p>No reviews submitted by this student.</p>
    @else
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Reviewee</th>
                    <th class="px-4 py-2">Rating</th>
                    <th class="px-4 py-2">Feedback</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submittedReviews as $review)
                <tr>
                    <td class="border px-4 py-2">{{ $review->reviewee->name }}</td>
                    <td class="border px-4 py-2">{{ $review->rating }}</td>
                    <td class="border px-4 py-2">{{ $review->feedback }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2 class="text-xl font-bold mb-2">Received Reviews</h2>
    @if ($receivedReviews->isEmpty())
        <p>No reviews received by this student.</p>
    @else
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Reviewer</th>
                    <th class="px-4 py-2">Rating</th>
                    <th class="px-4 py-2">Feedback</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receivedReviews as $review)
                <tr>
                    <td class="border px-4 py-2">{{ $review->reviewer->name }}</td>
                    <td class="border px-4 py-2">{{ $review->rating }}</td>
                    <td class="border px-4 py-2">{{ $review->feedback }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
