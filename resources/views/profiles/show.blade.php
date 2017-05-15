@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md8 col-md-offset-2">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                    <small>član od {{ $profileUser->created_at->format(' F Y ') }}</small>
                </h1>
            </div>

            @foreach($activities as $activity)
                @include("profiles.activities.{$activity->type}")
            @endforeach
            {{-- $threads->links() --}}
        </div>
        </div>
    </div>
@endsection