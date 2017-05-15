<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $profileUser->name }} je dodal/a odgovor
            </span>
        </div>
    </div>

    <div class="panel-body">
        <article>
            {{ $activity->subject->body }}
        </article>
    </div>
</div>
