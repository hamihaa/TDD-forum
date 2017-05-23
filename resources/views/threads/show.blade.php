@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" getago="{{ $thread->created_at }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                                    <a href="/profiles/{{ $thread->creator->name }}">
                                        {{ $thread->creator->name }}
                                    </a>
                                    <h4>{{ $thread->title }}</h4>
                                </span>

                            @can('delete', $thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <!-- Button Form Input  -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger btn-sm" required>Izbriši</button>
                                        </div>
                                </form>
                                @endcan
                            </div>
                        </div>

                        <div class="panel-body">
                            <article>
                                    {{ $thread->body }}
                            </article>
                        </div>
                    </div>

                    <replies
                    @added="repliesCount++"
                    @removed="repliesCount--"></replies>
                </div>
                    {{--
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
                    --}}


                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                Objavil <a href="/profiles/{{ $thread->creator->name }}"> {{ $thread->creator->name }} </a> <span v-text="postedAt"></span>
                                <br> število komentarjev: <span v-text="repliesCount"></span>
                            </p>
                            <p>
                                <subscribe-button :active="{{  json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </thread-view>
@endsection
