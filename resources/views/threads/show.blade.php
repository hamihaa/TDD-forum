@extends('layouts.app') 
@section('header')

<link href="{{ asset('css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection
 
@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" getago="{{ $thread->created_at }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                    <img src="/storage/{{ $thread->creator->avatar() }}" class="img-circle" width="75px" height="75px">
                                    <a href="/profiles/{{ $thread->creator->name }}">
                                        {{ $thread->creator->name }}
                                    </a>
                                    <h3>{{ $thread->title }}</h3>
                                </span> @if(Auth::check() && $thread->thread_status_id == 2 ||
                            $thread->thread_status_id == 3)
                            <!-- UpVote -->
                            <form action="{{$thread->path()}}/votes" method="POST">
                                {{ csrf_field() }} @if($isUpVotedOn) {{ method_field('DELETE') }} @endif @if($isDownVotedOn) {{ method_field('PATCH') }}
                                @endif

                                <input type="hidden" name="vote_type" value="1">

                                <!-- Button Form Input  -->
                                <div class="form-group">
                                    <button type="submit" class="btn  {{$isUpVotedOn ? 'btn-success white-color' :'btn-default' }} glyphicon glyphicon-thumbs-up">
                                                {{ $thread->upvotesCount }}
                                            </button> &nbsp;
                                </div>
                            </form>

                            <!-- DownVote -->
                            <form action="{{$thread->path()}}/votes" method="POST">
                                {{ csrf_field() }} @if($isDownVotedOn) {{ method_field('DELETE') }} @endif @if($isUpVotedOn) {{ method_field('PATCH') }}
                                @endif

                                <input type="hidden" name="vote_type" value="0">
                                <div class="form-group">
                                    <!-- Button Form Input  -->
                                    <button type="submit" class="btn  {{$isDownVotedOn ? 'btn-danger white-color' :'btn-default' }} glyphicon glyphicon-thumbs-down">
                                                {{ $thread->downvotesCount }}
                                            </button> &nbsp;
                                </div>
                            </form>
                            @else
                            <p style="font-weight:800; padding-right:10px">
                                Za: {{ $thread->upvotesCount }}
                                <br> Proti: {{ $thread->downvotesCount }}
                            </p>
                            @endif @can('delete', $thread)
                            <form action="{{$thread->path()}}" method="POST">
                                {{ csrf_field() }} {{ method_field('DELETE') }}

                                <!-- Button Form Input  -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-sm" required>Izbriši predlog</button>
                                </div>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(isset($thread->image))<img src="/storage/{{$thread->image}}" style="width:auto;height:auto;max-width:100%;padding-bottom:20px;">@endif

                        <article>
                            {!! $thread->body !!}
                        </article>
                    </div>
                    <div>
                        @can('editBody', $thread)
                        <a href="{{ $thread->path() }}/edit" class="btn btn-link btn-sm">
                                    Uredi predlog
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a> @endcan
                    </div>
                </div>

                <!-- Odgovor organa -->
                @if(isset($governmentReply) && ($thread->thread_status_id == 5 || $thread->thread_status_id == 6))
                <div class="gov-reply-section well well-lg">
                    <h4>Odgovor organa</h4> <small> <strong>odgovor objavljen: </strong> {{  $thread->updated_at->format('d.m.y') }}
                            </small>
                    <section class=" reply-body">
                        <div class="reply-date">
                        </div>
                        {!! $governmentReply !!}
                    </section>
                </div>
                @endif

                <replies @added="repliesCount++" @removed="repliesCount--"></replies>

            </div>
            {{-- @if (auth()->check())

            <div class="panel-heading">Dodaj komentar</div>
            <form method="POST" action="{{ $thread->path() }} /replies">
                {{ csrf_field() }}
                <!-- Body Form Input  -->
                <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                    <textarea class="form-control" name="body" id="body" rows="3" placeholder="Vsebina komentarja..." required></textarea>                    {!! $errors->first('body', '<span class="Error">:message</span>') !!}
                </div>
                <!-- Button Form Input  -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" required>Objavi</button>
                </div>
            </form>

            @else
            <p>Za komentiranje se je potrebno <a href="{{ route('login') }}"> prijaviti.</a></p>
            @endif --}}

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div>
                            @if(Auth::check())
                            <subscribe-button :active="{{  json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            @endif
                        </div>
                        <p><strong style="padding-top:8px; font-size:16px;color:#d58512">STATUS: {{ $thread->status->status_name }} </strong></p>
                        <p>
                            Objavljeno <span v-text="postedAt"></span>
                            <p>
                                število komentarjev: <span v-text="repliesCount"></span>
                                <br> število glasov: {{ $thread->upvotesCount + $thread->downvotesCount }}
                            </p>

                            @if($thread->upvotesCount || $thread->downvotesCount)
                            <label style="text-align: center" for="doughnut">
                                    <doughnut-chart id="doughnut" class="chart" :pro="{{ json_encode($thread->upvotesCount) }}" :against="{{ json_encode($thread->downvotesCount) }}"></doughnut-chart>
                                    @if($neededVotes > 0)
                                        Število potrebnih glasov za sprejetje: {{ $neededVotes  }}
                                    @else
                                       <p>Predlog je prejel dovolj glasov.</p>
                                    @endif
                                </label> @else
                            <p>Za ta predlog še ni bilo oddanih glasov.</p>
                            @endif


                            <!-- Facebook social -->
                            <div>
                                <div id="fb-root">
                                </div>
                                <div class="fb-like" data-href="http://localhost/learn-vue/tab/test.html#" data-send="false" data-layout="button_count" data-width="100"
                                    data-show-faces="false">
                                </div>

                                <div class="fb-share-button" data-href="http://localhost/learn-vue/tab/test.html" data-layout="button_count">
                                </div>
                            </div>
                            <!-- /Facebook social -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</thread-view>

<!-- Facebook social -->
<script type="text/javascript">
    (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

</script>
@endsection