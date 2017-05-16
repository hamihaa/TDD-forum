@component('profiles.activities.activity')
@slot('heading')
    <span class="glyphicon glyphicon-thumbs-up"></span>
    {{ $profileUser->name }} je med priljubljene dodal
    <a href="{{ $activity->subject->favorited->path() }}">
        komentar na objavi:
    </a>
@endslot

@slot('body')
{{ $activity->subject->favorited->body }}
@endslot
@endcomponent