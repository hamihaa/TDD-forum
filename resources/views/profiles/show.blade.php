@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md8 col-md-offset-2">
            <div class="page-header">
                <h1>
                    <img src="/storage/{{ $profileUser->avatar() }}" class="img-circle" width="200px" height="200px">

                    {{ $profileUser->name }}
                    @if($profileUser->created_at)<small>član od {{ $profileUser->created_at->format('m.Y ') }}</small>@endif
                </h1>
            </div>

            @forelse($activities as $date => $record)
                <h3>
                    {{$date}}
                </h3>
                @foreach($record as $activity)
                    @if(view()->exists("profiles.activities.{$activity->type}"))
                        @include("profiles.activities.{$activity->type}")
                    @endif
                @endforeach
                @empty
                Uporabnik nima preteklih aktivnosti.
            @endforelse
        </div>
        </div>
    </div>
@endsection