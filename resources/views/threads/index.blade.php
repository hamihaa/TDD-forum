@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Left sidebar -->
            <div class="col-md-2" id="left-sidebar">
                <!-- Rašišči -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-info">
                            <h3 class="sidebar-title">
                                Razišči
                            </h3>
                        </div>

                        <div class="list-group">
                            <a href="/threads" class="list-group-item">
                                <span class="glyphicon glyphicon-globe"></span>
                                Novi predlogi
                            </a>
                            @if(Auth::check())
                                <a class="list-group-item" href="?by={{ auth()->user()->name }}">
                                    <span class="fa fa-lightbulb-o"></span>
                                    Moji predlogi
                                </a>
                            @endif
                            <a href="/threads?votes=1" class="list-group-item">
                                <span class="glyphicon glyphicon-fire"></span>
                                Predlogi z največ glasovi
                            </a>
                            <a href="/threads?popular=1" class="list-group-item">
                                <span class="glyphicon glyphicon-fire"></span>
                                Predlogi z največ odgovori
                            </a>

                            <a href="/threads?unanswered=1" class="list-group-item">
                                <span class="glyphicon glyphicon-warning-sign"></span>
                                Predlogi brez odgovorov
                            </a>

                        </div>

                    </div>
                </div>
                <!-- Rašišči -->
                <!-- Kategorije -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-info">
                            <h3 class="sidebar-title">
                                Kategorije
                            </h3>
                            <div class="list-group" id="kategorije">
                                <a href="/threads/davki_finance" class="list-group-item">
                                    <i class="fa fa-eur fa-2x" aria-hidden="true"></i>
                                    Davki in finance
                                </a>
                                <a href="/threads/gospodarstvo" class="list-group-item">
                                    <i class="fa fa-industry fa-2x" aria-hidden="true"></i>
                                    Gospodarstvo
                                </a>
                                <a href="/threads/javna_uprava" class="list-group-item">
                                    <i class="fa fa-bank fa-2x" aria-hidden="true"></i>
                                    Javna uprava</a>
                                <a href="/threads/kultura" class="list-group-item">
                                    <i class="glyphicon glyphicon-book fa-2x" aria-hidden="true"></i>
                                    Kultura</a>
                                <a href="/threads/kmetijstvo" class="list-group-item">
                                    <i class="fa fa-envira fa-2x" aria-hidden="true"></i>
                                    Kmetijstvo</a>
                                <a href="/threads/notranje" class="list-group-item">
                                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                                    Notranje zadeve</a>
                                <a href="/threads/obramba" class="list-group-item">
                                    <i class="fa fa-fighter-jet fa-2x" aria-hidden="true"></i>
                                    Obramba</a>
                                <a href="/threads/okolje" class="list-group-item">
                                    <i class="fa fa-tree fa-2x" aria-hidden="true"></i>
                                    Okolje in prostor</a>
                                <a href="/threads/pravosodje" class="list-group-item">
                                    <i class="fa fa-legal fa-2x" aria-hidden="true"></i>
                                    Pravosodje</a>
                                <a href="/threads/promet" class="list-group-item">
                                    <i class="fa fa-car fa-2x" aria-hidden="true"></i>
                                    Promet</a>
                                <a href="/threads/sociala" class="list-group-item">
                                    <i class="fa fa-child fa-2x" aria-hidden="true"></i>
                                    Socialne zadeve</a>
                                <a href="/threads/splosno" class="list-group-item">
                                    <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                                    Splošno</a>
                                <a href="/threads/solstvo" class="list-group-item">
                                    <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                                    Šolstvo</a>
                                <a href="/threads/visoko_solstvo_znanost" class="list-group-item">
                                    <i class="fa fa-flask fa-2x" aria-hidden="true"></i>
                                    Visoko šolstvo in znanost</a>
                                <a href="/threads/zdravje" class="list-group-item">
                                    <i class="fa fa-heartbeat fa-2x" aria-hidden="true"></i>
                                    Zdravje</a>
                                <a href="/threads/zunanje" class="list-group-item">
                                    <i class="fa fa-handshake-o fa-2x" aria-hidden="true"></i>
                                    Zunanje zadeve</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Kategorije -->
            </div>
            <!-- /Left sidebar -->

            <!-- Objave -->
            <div class="col-md-8">
                <div class="row">
                    @include('threads.list')
                </div>
                <div style="text-align: center">
                    {{ $threads->appends($_GET)->links() }}
                </div>
            </div>
            <!-- /Objave -->
            <!-- Right side -->
            <div class="col-md-2">

                <!-- Oznake -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-info">
                            <h3 class="sidebar-title">
                                Najpogostejše oznake
                            </h3>
                            <tag-cloud :data="{{ json_encode($cloud) }}"></tag-cloud>
                        </div>
                    </div>
                </div>
                <!-- /Oznake -->
                <!-- Date filter -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-info">
                            <h3 class="sidebar-title">
                                Iskanje po datumu
                            </h3>
                            <form method="GET" action="/threads?">
                                <date-picker></date-picker>
                                <button class="btn btn-default" style="margin-top: 10px;" type="submit">
                                    Potrdi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Date filter -->
            </div>
        </div>
    </div>
@endsection

