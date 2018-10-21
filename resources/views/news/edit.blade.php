@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dodajanje novice</div>
                <div class="panel-body">
                    <form method="POST" action="{{ $news->path() }}">
                        {{ csrf_field() }} {{ method_field('PATCH') }}
                        <!-- Title Form Input  -->
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">Naslov:</label>
                            <input type="text" class="form-control" name="title" id="title" required value="{{ $news->title }}">                            {!! $errors->first('title', '<span class="Error">:message</span>') !!}
                        </div>
                        <!--  Form Input  -->
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <label for="">Vsebina:</label>
                            <textarea class="form-control" name="body" id="contentbody" rows="8" required>
                                    {{ $news->body }}
                                </textarea> {!! $errors->first('body', '<span class="Error">:message</span>')
                            !!}
                        </div>
                        <!-- Button Form Input  -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" required>Potrdi spremembe</button>
                            <a href="/threads" class="btn btn-default">Prekliči</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection