@extends('layouts.app') 
@section('content')
<div class="container">
    <h1 class="page-header">Urejanje profila</h1>
    <div class="row">
        <!-- left column -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="text-center">
                <img src="/storage/{{ $user->avatar() }}" class="img-circle" width="200px" height="200px">
            </div>
        </div>
        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            <h3>Osebni podatki</h3>
            <form action="{{ route('avatar', $user) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('PATCH') }}
                <label class="col-lg-3 control-label" for="avatar">Profilna slika:</label>
                <input type="file" name="avatar" class="text-center form-control center-block well well-sm">

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Potrdi profilno sliko</button>
                            <input class="btn btn-default" value="Prekliči" type="reset">
                        </div>
                    </div>
                </div>
            </form>

            <form method="POST" action="/profiles/{{ $user->name }}" class="form-horizontal" role="form">
                <!-- Name Form Input  -->
                {{csrf_field()}} {{ method_field('PATCH') }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="name">Uporabniško ime:</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ $user->name }}" class="form-control" name="name" id="name" required>                        {!! $errors->first('name', '<span class="Error">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="first_name">Ime:</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ $user->first_name }}" class="form-control" name="first_name" id="first_name">                        {!! $errors->first('first_name', '<span class="Error">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="last_name">Priimek:</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ $user->last_name }}" class="form-control" name="last_name" id="last_name">                        {!! $errors->first('last_name', '<span class="Error">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="email">Email:</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ $user->email }}" class="form-control" name="email" id="email" required>                        {!! $errors->first('email', '<span class="Error">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('is_anonymous') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="is_anonymous">Želim biti anonimen:</label>
                    <div class="col-lg-8">
                        <input type="checkbox" name="is_anonymous" value="1" {{ $user->is_anonymous? 'checked' : '' }}><br>                        {!! $errors->first('is_anonymous', '<span class="Error">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('get_notifications') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="get_notifications">Želim prejemati obvestila, kadar me nekdo označi v komentarju:</label>
                    <div class="col-lg-8">
                        <input type="checkbox" name="get_notifications" value="1" {{ $user->get_notifications? 'checked'
                        : '' }}><br> {!! $errors->first('get_notifications', '<span class="Error">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('get_newsletter') ? 'has-error' : '' }}">
                    <label class="col-lg-3 control-label" for="get_notifications">Želim prejemati tedenski bilten z obvestili o novih predlogih, odzivih pristojnih vladnih organov ter seznamom najpopularnejših predlogov tedna:</label>
                    <div class="col-lg-8">
                        <input type="checkbox" name="get_newsletter" value="1" {{ $user->get_newsletter? 'checked' : '' }}><br>                        {!! $errors->first('get_newsletter', '<span class="Error">:message</span>') !!}
                    </div>
                </div>

                <hr>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="col-md-3 control-label">Geslo:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password" value="" type="password"> {!! $errors->first('password',
                        '
                        <span class="Error">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label class="col-md-3 control-label">Ponovi geslo:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password_confirmation" value="" type="password"> {!! $errors->first('password_confirmation',
                        '
                        <span class="Error">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" required>Potrdi urejanje</button>
                            <input class="btn btn-default" value="Prekliči" type="reset">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection