<article>
    <div class="panel-heading">
        <div class="level">
                <h5 class="flex">
                {{ $reply->owner->name }},  {{ $reply->created_at->diffForHumans() }}
                </h5>
            <form method="POST" action="/replies/{{ $reply->id }}/favorite">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }}
                </button>
            </form>


    </div>
    <div class="body">
        {{ $reply->body }}
    </div>
</article>
<hr>