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
                @if(isset($news->thumbnail))<img src="/storage/{{$news->thumbnail}}" style="width:auto;height:auto;max-width:100%;padding-bottom:20px;">@endif
                <article>
                    {!! $news->body !!}
                </article>
            </div>
        </div>
    </div>
</div>
@endsection