@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold mb-6">Add Assessment to {{ $course->name }}</h2>

        <!-- Form for creating a new assessment -->
        <form action="{{ route('assessments.store', ['course' => $course->id]) }}" method="POST">
            @csrf

            <!-- Title Input Field -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-bold mb-2">Assessment Title</label>
                <input type="text" name="title" id="title" class="border border-gray-300 rounded p-2 w-full" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instructions Input Field -->
            <div class="mb-4">
                <label for="instructions" class="block text-sm font-bold mb-2">Instructions</label>
                <textarea name="instructions" id="instructions" class="border border-gray-300 rounded p-2 w-full" required>{{ old('instructions') }}</textarea>
                @error('instructions')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Number of Reviews Required Input Field -->
            <div class="mb-4">
                <label for="number_of_reviews" class="block text-sm font-bold mb-2">Number of Reviews Required</label>
                <input type="number" name="number_of_reviews" id="number_of_reviews" class="border border-gray-300 rounded p-2 w-full" value="{{ old('number_of_reviews') }}" required min="1">
                @error('number_of_reviews')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Maximum Score Input Field -->
            <div class="mb-4">
                <label for="maximum_score" class="block text-sm font-bold mb-2">Maximum Score</label>
                <input type="number" name="maximum_score" id="maximum_score" class="border border-gray-300 rounded p-2 w-full" value="{{ old('maximum_score') }}" >
                @error('maximum_score')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Due Date Input Field -->
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-bold mb-2">Due Date</label>
                <input type="datetime-local" name="due_date" id="due_date" class="border border-gray-300 rounded p-2 w-full" value="{{ old('due_date') }}" required>
                @error('due_date')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assessment Type Selection -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-bold mb-2">Assessment Type</label>
                <select name="type" id="type" class="border border-gray-300 rounded p-2 w-full" required>
                    <option value="student-select" {{ old('type') == 'student-select' ? 'selected' : '' }}>Student Select</option>
                    <option value="teacher-assign" {{ old('type') == 'teacher-assign' ? 'selected' : '' }}>Teacher Assign</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Assessment</button>

            <!-- Button to assign groups -->
            <div class="mt-4">
                <button onclick="assignGroups()" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">
                    Assign Groups
                </button>
            </div>
        </form>
    </div>

    <script>
        function assignGroups() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('groups.assign', ['assessment' => $course->id]) }}";

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}'; 

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit(); 
        }
    </script>
@endsection
