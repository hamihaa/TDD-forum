@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                    <small>avtor:
                                        <a href="/profiles/{{ $thread->creator->name }}">
                                            {{ $thread->creator->name }}
                                        </a>
                                    </small>
                                </h4>
                                <strong>
                                    število odgovorov: {{ $thread->replies_count }}
                                </strong>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p>Ni tem, ki ustrezajo tej kategoriji.</p>
                @endforelse
            </div>
                {{ $threads->appends($_GET)->links() }}

        </div>
    </div>
@endsection

