@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dodajanje novice</div>
                    <div class="panel-body">
                        <form method="POST" action="/news" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <!-- Title Form Input  -->
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Naslov:</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       required value="{{ old('title') }}">
                                {!! $errors->first('title', '<span class="Error">:message</span>') !!}
                            </div>
                            <!--  Form Input  -->
                            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                <label for="">Vsebina:</label>
                                <textarea class="form-control" name="body" id="body" rows="8" required>
                                    {{ old('body') }}
                                </textarea>
                                {!! $errors->first('body', '<span class="Error">:message</span>') !!}
                            </div>
                            <!-- Image Form Input  -->
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                <label for="image">Predstavitvena slika:</label>
                                <input type="file" class="form-control" name="image" id="image"
                                       value="{{ old('image') }}">
                                {!! $errors->first('image', '<span class="Error">:message</span>') !!}
                            </div>
                            <!-- Button Form Input  -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" required>Objavi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
