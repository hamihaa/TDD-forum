@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md8 col-md-offset-2">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                    <small>član od {{ $profileUser->created_at->format('m.Y ') }}</small>
                </h1>
            </div>

            @foreach($activities as $date => $record)
                <h3>
                    {{$date}}
                </h3>
                @foreach($record as $activity)
                    @include("profiles.activities.{$activity->type}")
                @endforeach
            @endforeach
        </div>
        </div>
    </div>
@endsection