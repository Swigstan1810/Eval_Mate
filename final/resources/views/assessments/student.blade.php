@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">{{ $assessment->title }}</h1>
    <p class="text-gray-600 mb-4">Instructions: {{ $assessment->instructions }}</p>
    <p class="text-gray-600 mb-4">Due Date: {{ $assessment->due_date->format('F j, Y') }}</p>
    <p class="text-gray-600 mb-4">Number of Required Reviews: {{ $assessment->number_of_reviews }}</p>

    @if (Auth::user()->user_type == 'student')
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Submit Peer Review</h2>
            <form action="{{ route('reviews.store', $assessment->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700" for="reviewee_id">Select Reviewee</label>
                    <select name="reviewee_id" id="reviewee_id" class="w-full p-2 border rounded-lg" required>
                        <option value="">-- Select a student --</option>
                        @foreach ($otherStudents as $student)
                            <option value="{{ $student->id }}" 
                                {{ in_array($student->id, $alreadyReviewedIds) ? 'disabled' : '' }}
                                {{ old('reviewee_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->s_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('reviewee_id')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700" for="content">Your Review</label>
                    <textarea name="content" id="content" class="w-full p-2 border rounded-lg" rows="4" required>{{ old('content') }}</textarea>
                    <small class="text-gray-500">Please enter at least 5 words.</small>
                    @error('content')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Add Score Input Field -->
                <div class="mb-4">
                    <label class="block text-gray-700" for="score">Score (1-100)</label>
                    <input type="number" name="score" id="score" class="w-full p-2 border rounded-lg" min="1" max="100" required value="{{ old('score') }}">
                    @error('score')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="rating">Rate the Reviewer (1-5)</label>
                    <input type="number" name="rating" id="rating" class="w-full p-2 border rounded-lg" min="1" max="5" required value="{{ old('rating') }}">
                    @error('rating')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Add A Feedback Input Field -->
                <div class="mb-4">
                    <label class="block text-gray-700" for="feedback">Feedback</label>
                    <textarea name="feedback" id="feedback" class="w-full p-2 border rounded-lg" rows="4">{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">
                    Submit Review
                </button>
            </form>
        </div>
    @endif

    <!-- Display Submitted Reviews -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Your Submitted Reviews</h2>
        @if ($submittedReviews->isEmpty())
            <p class="text-gray-600">You have not submitted any reviews yet.</p>
        @else
            <ul class="bg-white shadow-md rounded-lg p-6">
                @foreach ($submittedReviews as $review)
                    <li class="mb-4">
                        <div class="text-gray-700">{{ $review->content }}</div>
                        <small class="text-gray-500">- Reviewed {{ $review->reviewee->name }} ({{ $review->reviewee->s_number }})</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Display Received Reviews -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Peer Reviews You Received</h2>
        @if ($receivedReviews->isEmpty())
            <p class="text-gray-600">You have not received any reviews yet.</p>
        @else
            <ul class="bg-white shadow-md rounded-lg p-6">
                @foreach ($receivedReviews as $review)
                    <li class="mb-4">
                        <div class="text-gray-700">{{ $review->content }}</div>
                        <small class="text-gray-500">- Reviewed by {{ $review->reviewer->name }} ({{ $review->reviewer->s_number }})</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
