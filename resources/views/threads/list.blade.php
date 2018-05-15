@forelse($threads as $thread)
    <div class="thread-item col-md-6">
        <div class="thread-thumbnail"
             style='background: url(/storage/{{$thread->thumbnail()}}) center no-repeat;
                     background-size: 100% auto;'>
        </div>
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="level">
                    <h4 class="flex">
                        <small>
                            avtor:
                            <a href="/profiles/{{ $thread->creator->name }}">
                                {{ $thread->creator->name }}
                            </a> |  kategorija:
                            <a href="/threads/{{ $thread->category->name }}">
                                {{ $thread->category->name }}
                            </a>
                        </small>
                        <br>
                        <a href="{{ $thread->path() }}">
                            {{ $thread->title }}
                        </a>
                        <br>
                        <small>
                            <strong>objavljeno:
                                {{ $thread->created_at->format('d.m.Y') }}</strong>
                        </small>
                    <!--br>
                                        <small>
                                            zadnja sprememba:
                                                {{ $thread->updated_at->format('d.m.Y') }}
                            </small-->
                    </h4>
                    <div class="col">
                        <div class="col">
                            <strong>
                                <span>Status: <span style="color:rgb(213, 133, 18)">{{ $thread->status->status_name }}</span> </span>
                                <br>
                                <span style="color:forestgreen">Za: </span>  {{ $thread->upvotesCount }}
                                <span style="color:darkred">Proti: </span> {{ $thread->downvotesCount }}
                            </strong>
                        </div>
                        <div class="col">
                            <strong>
                                komentarjev: {{ $thread->replies_count }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="body">
                    {!! \Illuminate\Support\Str::limit($thread->body, 100) !!}
                    <br>
                    <a class="pull-right" href=" {{ $thread->path() }}">Preberi več <i class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@empty
    <p><strong>Ni objav, ki ustrezajo tej kategoriji.</strong></p>
@endforelse