@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Objave</div>
                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex">
                                        <a href="{{ $thread->path() }}">
                                            {{ $thread->title }}
                                        </a> <small>avtor: {{ $thread->creator->name }}</small>

                                    </h4>

                                    <strong>
                                        število odgovorov: {{ $thread->replies_count }}
                                    </strong>
                                </div>
                                <div class="body">
                                    {{ $thread->body }}
                                </div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
