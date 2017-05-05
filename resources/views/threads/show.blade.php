@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a>
                        <h4>{{ $thread->title }}</h4>
                    </div>

                    <div class="panel-body">
                        <article>
                                {{ $thread->body }}
                        </article>
                    </div>
                </div>
                <div class="panel panel-default">
                            @foreach($replies as $reply)
                                @include('threads.partials.reply')
                            @endforeach
                            {{ $replies->links() }}
                </div>

                @if (auth()->check())

                    <div class="panel-heading">Dodaj komentar</div>
                    <form method="POST" action="{{ $thread->path() }} /replies">
                    {{ csrf_field() }}
                    <!-- Body Form Input  -->
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <textarea class="form-control" name="body" id="body" rows="3"
                                      placeholder="Vsebina komentarja..." required></textarea>
                            {!! $errors->first('body', '<span class="Error">:message</span>') !!}
                        </div>
                        <!-- Button Form Input  -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" required>Objavi</button>
                        </div>
                    </form>

                @else
                    <p>Za komentiranje se je potrebno <a href="{{ route('login') }}"> prijaviti.</a></p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">


                    <div class="panel-body">
                        <p>
                            Objavil <a href="#"> {{ $thread->creator->name }} </a> {{ $thread->created_at->diffForHumans() }}
                            <br> število komentarjev: {{ $thread->replies_count }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
