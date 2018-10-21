@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dodaj odgovor organa</div>
                <div class="panel-body">
                    <form method="POST" action="{{ $thread->path() }}/gov">
                        {{ csrf_field() }} {{ method_field('PATCH') }}
                        <!-- Category_id Form Input  -->
                        <!--  Form Input  -->
                        <div class="form-group {{ $errors->has('government_reply') ? 'has-error' : '' }}">
                            <label for="">Vsebina odgovora organa:</label>
                            <textarea class="form-control" name="government_reply" id="contentbody" rows="8" required>{{ $thread->government_reply }}</textarea>                            {!! $errors->first('body', '<span class="Error">:message</span>') !!}
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