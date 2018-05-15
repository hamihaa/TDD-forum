@extends('layouts.app')

@section('header')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{ $news->title }}</h2>
                </div>
                <div class="panel-body">
                    <img src="/storage/{{$news->thumbnail}}" width="100%">
                    <article>
                        {{ $news->body }}
                    </article>
                </div>
            </div>
        </div>
    </div>
@endsection
