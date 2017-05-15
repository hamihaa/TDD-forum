<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $profileUser->name }} je ustvaril/a objavo
            </span>
        </div>
    </div>

    <div class="panel-body">
        <article>
            {{ $activity->subject->body }}
        </article>
    </div>
</div>


