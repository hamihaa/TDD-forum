@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} je ustvaril/a objavo
        <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
