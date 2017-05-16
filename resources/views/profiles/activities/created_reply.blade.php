@component('profiles.activities.activity')
    @slot('heading')
        <span class="glyphicon glyphicon-bullhorn"></span> &nbsp;
        {{ $profileUser->name }} je dodal/a odgovor na
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a>
    @endslot

    @slot('body')
    {{ $activity->subject->body }}
    @endslot
@endcomponent