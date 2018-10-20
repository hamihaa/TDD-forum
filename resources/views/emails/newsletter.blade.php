<p>Spoštovani, spodaj najdete povezave do zadnjih objavljenih predlogov uporabnikov in odzivov pristojnih vladnih organov na
    predloge posredovane preko spletnega orodja predlagam.vladi.si. Prav tako vam pošiljamo seznam največkrat komentiranih
    predlogov in predlogov, ki so v preteklem tednu prejeli največ glasov.
</p>

<p><strong>Zadnji predlogi:</strong></p>

@foreach($lastPosts as $post)
<p><a href="{{env('APP_URL') . $post->path()  }}">{{$post->title}}</a> {{$post->created_at->format('d.m.Y')}}</p> @endforeach

<p><strong>Zadnji odzivi pristojnih vladnih organov:</strong></p>
@foreach($lastWithResponse as $post)
<p><a href="{{env('APP_URL') . $post->path()  }}">{{$post->title}}</a> {{$post->created_at->format('d.m.Y') }}</p> @endforeach

<p><strong>Predlogi, ki so v preteklem tednu dobili največ  glasov: </strong></p>
@foreach($mostVoted as $post)
<p><a href="{{env('APP_URL') . $post->path()  }}">{{$post->title}}</a> ({{$post->votes_count}})</p> @endforeach

<p><strong>Predlogi, ki so bili v preteklem tednu deležni največ  komentarjev: </strong></p>
@foreach($mostVoted as $post)
<p><a href="{{env('APP_URL') . $post->path()  }}">{{$post->title}}</a> ({{$post->replies_count}})</p> @endforeach


<p>Prijazen pozdrav
</p>