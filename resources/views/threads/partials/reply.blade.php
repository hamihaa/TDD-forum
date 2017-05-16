<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div class="panel-heading">
        <div id="reply-{{ $reply->id }}" class="level">
                <h5 class="flex">
                    <a href="/profiles/{{ $reply->owner->name }}">
                        {{ $reply->owner->name }}</a>,
                          {{ $reply->created_at->diffForHumans() }}
                </h5>
            <form method="POST" action="/replies/{{ $reply->id }}/favorite">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }}
                </button>
            </form>


        </div>

        <div class="panel-footer">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-success" @click="update">Potrdi</button>
                <button class="btn btn-xs btn-default" @click="editing = false">Prekliči</button>
            </div>
            <div v-else v-text="body"></div>
        </div>


        @can('delete', $reply)
            <div class="panel-content level">
                @can('update', $reply)
                    <button class="btn btn-link btn-sm" @click="editing = true">
                        Uredi
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                @endcan
                <button class="btn btn-link btn-sm mr-1" @click="destroy">
                        Odstrani komentar
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>

            </div>
        @endcan
    </div>
</reply>
