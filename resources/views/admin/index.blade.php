@extends('layouts.app') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Copy -->

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#menu1">Predlogi</a></li>
                <li><a data-toggle="tab" href="#menu2">Uporabniki</a></li>
                <li><a data-toggle="tab" href="#menu3">Novice</a></li>
            </ul>
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <h2>Nadzorna plošča- Vsi predlogi</h2>
                    <div class="table-responsive full">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Uredi predlog</th>
                                    <th>Dodaj odgovor</th>
                                    <th>ID</th>
                                    <th>Naslov</th>
                                    <th>Vsebina</th>
                                    <th>Datum oddaje</th>
                                    <th>Zadnja sprememba</th>
                                    <th>Spremeni status</th>
                                </tr>
                                <tr></tr>
                            </thead>
                            <tbody>
                                @foreach ($threads as $thread)
                                <tr>
                                    <td> <a href="{{ $thread->path() }}/edit"><i class="fa fa-pencil"></i></a> </td>
                                    <td> <a href="{{ $thread->path() }}/edit/gov"><i class="fa fa-pencil"></i></a> </td>
                                    <td> {{ $thread->id }} </td>
                                    <td> {{ $thread->title }} </td>
                                    <td> {{ substr($thread->body, 0, 300) }} </td>
                                    <td> {{ $thread->created_at }} </td>
                                    <td> {{ $thread->updated_at }} </td>
                                    <td>
                                        <form method="POST" action="{{ $thread->path() }}">
                                            {{csrf_field()}} {{ method_field('PATCH') }}
                                            <select class="form-control" name="thread_status_id">
                                                    <option selected disabled>Izberi status</option>
                                                    <option value="1" {{ $thread->status->id == "1" ? 'selected' : '' }} }}>Nepotrjeno</option>
                                                    <option value="2" {{ $thread->status->id == "2" ? 'selected' : '' }}>V razpravi</option>
                                                    <option value="3" {{ $thread->status->id == "3" ? 'selected' : '' }}>V glasovanju</option>
                                                    <option value="4" {{ $thread->status->id == "4" ? 'selected' : '' }}>Posredovano</option>
                                                    <option value="5" {{ $thread->status->id == "5" ? 'selected' : '' }}>Sprejet predlog</option>
                                                    <option value="6" {{ $thread->status->id == "6" ? 'selected' : '' }}>Zavrnjen predlog</option>
                                                    <option value="7" {{ $thread->status->id == "7" ? 'selected' : '' }}>Neustrezno</option>
                                                </select>
                                            <button class="btn btn-link">
                                                    Potrdi spremembo<i class="fa fa-check"></i>
                                                </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach;
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users -->
                <div id="menu2" class="tab-pane fade in">
                    <h2>Nadzorna plošča- Vsi uporabniki</h2>
                    <div class="table-responsive full">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Uredi uporabnika</th>
                                    <th>ID</th>
                                    <th>Uporabniško ime</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>Datum registracije</th>
                                </tr>
                                <tr></tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td> <a href="profiles/{{ $user->name }}/edit"><i class="fa fa-pencil"></i></a> </td>
                                    <td> {{ $user->id }} </td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->first_name }} </td>
                                    <td> {{ $user->last_name }} </td>
                                    <td> {{ $user->created_at }} </td>
                                </tr>
                                @endforeach;
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /users -->

                <!-- News-->
                <div id="menu3" class="tab-pane fade in">
                    <h2>Nadzorna plošča- Novice</h2>
                    <a href="news/create" class="btn btn-success">Dodaj novico</a>
                    <div class="table-responsive full">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Naslov</th>
                                    <th>Vsebina</th>
                                    <th>Dodano na</th>
                                </tr>
                                <tr></tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $thread)
                                <tr>
                                    <td> <a href="{{ $thread->path() }}/edit"><i class="fa fa-pencil"></i></a> </td>
                                    <td> {{ $thread->id }} </td>
                                    <td><a href="{{$thread->path() }}"> {{ $thread->title }} </a></td>
                                    <td> {{ $thread->body }} </td>
                                    <td> {{ $thread->created_at }} </td>
                                    <td>
                                        <form method="POST" action="{{ $thread->path() }}">
                                            {{csrf_field()}} {{ method_field('DELETE') }}
                                            <button class="btn btn-link">
                                                Izbriši<i class="fa fa-eraser"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach;
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /news -->
            </div>
        </div>
    </div>
</div>
@endsection