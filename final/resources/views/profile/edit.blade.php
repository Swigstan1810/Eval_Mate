@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">Edit Profile</h1>
    
    <form action="{{ route('profile.update') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block text-gray-700" for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700" for="password">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded-lg">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">Save Changes</button>
    </form>
</div>
@endsection
