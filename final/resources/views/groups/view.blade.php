@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Assigned Groups for {{ $assessment->title }}</h1>
        @if ($groups->isEmpty())
            <p>No groups assigned yet.</p>
        @else
            <ul class="list-disc">
                @foreach ($groups as $group)
                    <li>
                        <strong>{{ $group->name }}</strong>
                        <ul class="list-inside">
                            @foreach ($group->users as $groupMember)
                                <li>{{ $groupMember->name }} ({{ $groupMember->s_number }})</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
