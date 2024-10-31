@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">Edit Review</h1>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="rating" class="block text-gray-700">Rating</label>
            <input type="number" name="rating" id="rating" value="{{ old('rating', $review->rating) }}" max="5" min="1" class="border p-2 w-20">
            @error('rating')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="feedback" class="block text-gray-700">feedback</label>
            <textarea name="feedback" id="feedback" class="border p-2 w-full">{{ old('feedback', $review->feedback) }}</textarea>
            @error('feedback')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">Update Review</button>
    </form>
</div>
@endsection
