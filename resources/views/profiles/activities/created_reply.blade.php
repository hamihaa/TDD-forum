@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} je dodal/a odgovor na
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a>
    @endslot

    @slot('body')
    {{ $activity->subject->body }}
    @endslot
@endcomponent